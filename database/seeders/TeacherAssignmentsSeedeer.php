<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeacherAssignment;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;

class TeacherAssignmentSeeder extends Seeder
{
    public function run()
    {
        $class10A1 = Classes::where('name', '10A1')->first();
        $math = Subject::where('name', 'Math')->first();
        $teacherA = Teacher::find(User::where('email', 'teacher_a@example.com')->first()->id);

        TeacherAssignment::create([
            'teacher_id' => $teacherA->id,
            'class_id' => $class10A1->id,
            'subject_id' => $math->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $class11A1 = Classes::where('name', '11A1')->first();
        $science = Subject::where('name', 'Science')->first();
        TeacherAssignment::create([
            'teacher_id' => $teacherA->id,
            'class_id' => $class11A1->id,
            'subject_id' => $science->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}