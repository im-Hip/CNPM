<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentUsers = DB::table('users')->where('role', 'student')->pluck('id')->toArray();

        if (empty($studentUsers)) {
            $this->command->warn("Không có user nào có role = student!");
            return;
        }

        // Lấy tất cả classes
        $classes = DB::table('classes')->get();

        foreach ($classes as $class) {
            // Xác định tuổi cần thiết dựa vào grade
            $requiredAge = match ($class->grade) {
                '10' => 16,
                '11' => 17,
                '12' => 18,
                default => 16,
            };

            // Sinh học sinh cho class đó
            for ($i = 0; $i < $class->number_of_students; $i++) {
                DB::table('students')->insert([
                    'age'         => $requiredAge,
                    'day_of_birth' => Carbon::now()->subYears($requiredAge)->subDays(rand(0, 365))->toDateString(),
                    'gender'      => rand(0, 1) ? 'male' : 'female',
                    'user_id'     => $studentUsers[array_rand($studentUsers)],
                    'class_id'    => $class->id,
                ]);
            }
        }

        $this->command->info("Success!");
    }
}
