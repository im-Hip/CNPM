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
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['teacher', 'student'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
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

            return redirect()->route('admin.users.create') // ✅ Thay vì quay lại create
                ->with('success', 'Tạo tài khoản thành công.');
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
}
