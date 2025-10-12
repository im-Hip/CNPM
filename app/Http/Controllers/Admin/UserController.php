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
    public function create()
    {
        //Tự động tạo mã giáo viên
        $lastTeacher = Teacher::orderBy('id', 'desc')->first();
        $newTeacherId = 'GV001';

        if ($lastTeacher && preg_match('/GV(\d+)/', $lastTeacher->teacher_id, $matches)) {
            $number = intval($matches[1]) + 1;
            $newTeacherId = 'GV' . str_pad($number, 3, '0', STR_PAD_LEFT);
        }

        //Tự động tạo mã học sinh
        $lastStudent = Student::orderBy('id', 'desc')->first();
        $newStudentId = 'SV0001';

        if ($lastStudent && preg_match('/SV(\d+)/', $lastStudent->student_id, $matches)) {
            $number = intval($matches[1]) + 1;
            $newStudentId = 'SV' . str_pad($number, 4, '0', STR_PAD_LEFT);
        }

        //Lọc lớp chưa đủ 50 học sinh
        $classes = Classes::where('number_of_students', '<', 50)->get();

        $subjects = Subject::all();
        return view('admin.users.create', compact('classes', 'subjects', 'newTeacherId', 'newStudentId'));
    }

    public function store(Request $request)
    {
        try {
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
                $request->validate([
                    'subject_id' => ['required', 'exists:subjects,id'],
                    'level' => [
                        'required',
                        Rule::in(['Bachelor', 'Master', 'PhD']),
                    ],
                ]);

                Teacher::create([
                    'id' => $user->id,
                    'teacher_id' => $request->teacher_id,
                    'subject_id' => $request->subject_id,
                    'level' => $request->level,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } elseif ($request->role === 'student') {
                $request->validate([
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
                    'student_id' => $request->student_id,
                    'day_of_birth' => $request->day_of_birth,
                    'gender' => $request->gender,
                    'class_id' => $request->class_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Classes::where('id', $request->class_id)->increment('number_of_students');
            }

            return redirect()->route('admin.users.create')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
