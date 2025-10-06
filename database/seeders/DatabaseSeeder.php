<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            ClassSeeder::class,
            SubjectSeeder::class,
            RoomSeeder::class,
            TeacherAssignmentSeeder::class,
            ScheduleSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}