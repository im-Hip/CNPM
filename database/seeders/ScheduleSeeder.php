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
            Schedule::create([
                'teacher_id' => Teacher::inRandomOrder()->first()->id,
                'class_id' => Classes::inRandomOrder()->first()->id,
                'room_id' => Room::inRandomOrder()->first()->id,
                'day_of_week' => fake()->randomElement(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']),
                'start_time' => 1,
                'end_time'   => 2,
                'note' => NULL,
            ]);
        }
    }
}
