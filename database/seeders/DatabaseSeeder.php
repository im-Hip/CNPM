<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //$this->call(UserSeeder::class);
        //$this->call(SubjectSeeder::class);
        //$this->call(TeacherSeeder::class);
        //$this->call(ClassSeeder::class);
        //$this->call(StudentSeeder::class);
        $this->call(RoomSeeder::class);
        //$this->call(ScheduleSeeder::class);
        //$this->call(AnnouncementSeeder::class);
        $this->command->info("Success!");
    }
}
