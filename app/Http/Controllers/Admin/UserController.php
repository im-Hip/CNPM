<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $selectedRole = $request->role ?? '';
        $selectedClass = $request->class_id ?? '';
        $selectedSubject = $request->subject_id ?? '';

        $query = User::where('role', '!=', 'admin');

        if ($selectedRole !== '') {
            $query->where('role', $selectedRole);
        }

        if ($selectedRole === 'student') {
            $query->whereHas('student', function ($q) use ($selectedClass) {
                if ($selectedClass) {
                    $q->where('class_id', $selectedClass);
                }
            });
        }

        if ($selectedRole === 'teacher') {
            $query->whereHas('teacher', function ($q) use ($selectedSubject) {
                if ($selectedSubject) {
                    $q->where('subject_id', $selectedSubject);
                }
            })
                ->with(['teacher.classes'])
                ->join('teachers', 'users.id', '=', 'teachers.id') // nối bảng teacher
                ->orderBy('teachers.teacher_id', 'asc')               // sắp xếp theo mã GV
                ->select('users.*');                                    // tránh xung đột cột khi join
        }

        $users = $query->paginate(10);

        $classes = Classes::all();
        $subjects = Subject::all();

        return view('admin.users.index', compact('users', 'selectedRole', 'selectedClass', 'selectedSubject', 'classes', 'subjects'));
    }


    public function create()
    {
        // Tạo teacher_id unique
        do {
            $lastTeacher = Teacher::orderBy('id', 'desc')->first();
            $number = $lastTeacher ? (intval(substr($lastTeacher->teacher_id, 2)) + 1) : 1;
            $newTeacherId = 'GV' . str_pad($number, 3, '0', STR_PAD_LEFT);
        } while (Teacher::where('teacher_id', $newTeacherId)->exists());

        // Tạo student_id unique  
        do {
            $lastStudent = Student::orderBy('id', 'desc')->first();
            $number = $lastStudent ? (intval(substr($lastStudent->student_id, 2)) + 1) : 1;
            $newStudentId = 'SV' . str_pad($number, 4, '0', STR_PAD_LEFT);
        } while (Student::where('student_id', $newStudentId)->exists());

        $classes = Classes::where('number_of_students', '<', 50)->get();
        $subjects = Subject::all();

        return view('admin.users.create', compact('classes', 'subjects', 'newTeacherId', 'newStudentId'));
    }

    public function store(Request $request)
    {
        try {
            // Validation chung
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'role' => ['required', 'in:teacher,student'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            if ($request->role === 'teacher') {
                // ✅ THÊM VALIDATION CHO TEACHER_ID
                $request->validate([
                    'teacher_id' => [
                        'required',
                        'string',
                        'unique:teachers,teacher_id', // Đảm bảo unique mã GV
                        "regex:/^GV\\d{3}$/" // Format GV001, GV002...
                    ],
                    'subject_id' => ['required', 'exists:subjects,id'],
                    'level' => ['required', Rule::in(['Bachelor', 'Master', 'PhD'])],
                ]);

                Teacher::create([
                    'id' => $user->id,
                    'teacher_id' => $request->teacher_id, // ✅ Bây giờ sẽ có giá trị
                    'subject_id' => $request->subject_id,
                    'level' => $request->level,
                    // Không cần set created_at/updated_at thủ công, Laravel tự handle
                ]);
            } elseif ($request->role === 'student') {
                // ✅ THÊM VALIDATION CHO STUDENT_ID
                $request->validate([
                    'student_id' => [
                        'required',
                        'string',
                        'unique:students,student_id', // Đảm bảo unique mã HS
                        "regex:/^SV\\d{4}$/" // Format SV0001, SV0002...
                    ],
                    'day_of_birth' => ['required', 'date'],
                    'gender' => ['required', 'in:male,female'],
                    'class_id' => [
                        'required',
                        'exists:classes,id',
                        function ($attribute, $value, $fail) {
                            $class = Classes::find($value);
                            if ($class && $class->number_of_students >= 50) {
                                $fail('The selected class is already full (50 students).');
                            }
                        },
                    ],
                ]);

                Student::create([
                    'id' => $user->id,
                    'student_id' => $request->student_id, // ✅ Bây giờ sẽ có giá trị
                    'day_of_birth' => $request->day_of_birth,
                    'gender' => $request->gender,
                    'class_id' => $request->class_id,
                    // Không cần set created_at/updated_at
                ]);

                Classes::where('id', $request->class_id)->increment('number_of_students');
            }

            return redirect()->route('admin.users.index')->with('success', 'Tạo người dùng thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Xử lý validation error riêng
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(User $user)
    {
        // Lấy danh sách lớp và môn để hiển thị tùy theo role
        $classes = Classes::all();
        $subjects = Subject::all();

        // Nếu là giáo viên, lấy thông tin từ bảng teachers
        $teacherInfo = $user->role === 'teacher' ? $user->teacher : null;
        // Nếu là học sinh, lấy thông tin từ bảng students
        $studentInfo = $user->role === 'student' ? $user->student : null;

        return view('admin.users.edit', compact('user', 'classes', 'subjects', 'teacherInfo', 'studentInfo'));
    }

    public function update(Request $request, User $user)
    {
        // Validate dữ liệu
        $rules = [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
        ];

        // Nếu có mật khẩu thì validate thêm
        if ($request->filled('password')) {
            $rules['password'] = 'min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Cập nhật thông tin user
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        // Nếu là giáo viên
        if ($user->role === 'teacher') {
            $teacher = $user->teacher; // Quan hệ 1-1 với bảng Teacher

            if ($teacher) {
                // Kiểm tra xem giáo viên có đang phụ trách lớp nào không
                $hasClasses = $teacher->classes()->exists();

                // Nếu có lớp và subject_id bị thay đổi -> không cho phép
                if ($hasClasses && $request->subject_id != $teacher->subject_id) {
                    return back()->with('error', 'Không thể thay đổi môn dạy vì giáo viên này đang phụ trách lớp.');
                }

                // Nếu không vi phạm, cho phép cập nhật thông tin giáo viên
                $teacher->update([
                    'subject_id' => $request->subject_id,
                    'level' => $request->level,
                ]);
            }
        }

        // Nếu là học sinh
        if ($user->role === 'student') {
            $student = $user->student;

            if ($student) {
                // Nếu đổi sang lớp khác
                if ($request->class_id && $request->class_id != $student->class_id) {
                    $oldClass = $student->class; // lớp cũ của học sinh
                    $newClass = Classes::find($request->class_id); // lớp mới

                    if ($newClass) {
                        // Kiểm tra lớp mới có đủ 50 học sinh chưa
                        if ($newClass->number_of_students >= 50) {
                            return back()
                                ->withErrors(['class_id' => "Lớp {$newClass->name} đã đủ 50 học sinh, không thể chuyển thêm."])
                                ->withInput();
                        }

                        // Nếu có cột number_of_students trong bảng classes → cập nhật
                        if ($oldClass && $oldClass->number_of_students > 0) {
                            $oldClass->decrement('number_of_students');
                        }

                        $newClass->increment('number_of_students');
                    }
                }

                // Cập nhật thông tin học sinh
                $student->update([
                    'class_id' => $request->class_id,
                    'gender' => $request->gender,
                    'day_of_birth' => $request->day_of_birth,
                ]);
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'student') {
            $student = $user->student;

            if ($student && $student->class) {
                $student->class->decrement('number_of_students'); // Giảm 1 khi xóa học sinh
            }

            $student?->delete();
        }

        $user->delete();

        return back()->with('success', 'Xóa người dùng thành công!');
    }
}
