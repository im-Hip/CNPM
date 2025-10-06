<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Room;
use App\Models\Teacher;

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        $class10A1 = Classes::where('name', '10A1')->first();
        $math = Subject::where('name', 'Math')->first();
        $room101 = Room::where('name', 'Room 101')->first();
        $teacherA = Teacher::find(User::where('email', 'teacher_a@example.com')->first()->id);

        Schedule::create([
            'class_id' => $class10A1->id,
            'subject_id' => $math->id,
            'teacher_id' => $teacherA->id,
            'room_id' => $room101->id,
            'day_of_week' => 1,
            'class_period' => 1,
            'note' => 'Sample note',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $class11A1 = Classes::where('name', '11A1')->first();
        $science = Subject::where('name', 'Science')->first();
        $room102 = Room::where('name', 'Room 102')->first();

        Schedule::create([
            'class_id' => $class11A1->id,
            'subject_id' => $science->id,
            'teacher_id' => $teacherA->id,
            'room_id' => $room102->id,
            'day_of_week' => 2,
            'class_period' => 2,
            'note' => 'Sample note 2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}