<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Room;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i<=10; $i++){
            $class = Classes::inRandomOrder()->first();
            $start = rand(1,10);

            Schedule::create([
                'teacher_id' => Teacher::inRandomOrder()->first()->id,
                'class_id' => $class->id,
                'room_id' => $class->room_id,
                'day_of_week' => fake()->randomElement(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']),
                'start_time' => $start,
                'end_time'   => $start,
                'note' => NULL,
            ]);
        }
    }
}
