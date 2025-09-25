<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Classes;
use App\Models\Student;
use Carbon\Carbon;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'student')->get();
        $classes = Classes::all();

        if (!$classes->first()->grade) {
            throw new \Exception("Bảng classes cần có cột grade để xác định khối!");
        }

        $chunks = $users->chunk(50);

        foreach ($chunks as $index => $group) {
            $classId = $classes[$index]->id;
            $grade = $classes[$index]->grade;

            switch ($grade) {
                case 10:
                    $minAge = 16;
                    break;
                case 11:
                    $minAge = 17;
                    break;
                case 12:
                    $minAge = 18;
                    break;
                default:
                    $minAge = 18;
            }

            foreach ($group as $user) {
                $year = now()->year - $minAge;
                $dob = Carbon::createFromDate($year, fake()->numberBetween(1, 12), fake()->numberBetween(1, 28));

                Student::create([
                    'id' => $user->id, // FK trỏ tới users
                    'student_id' => 'SV' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'day_of_birth' => $dob,
                    'gender' => fake()->randomElement(['male', 'female']),
                    'class_id' => $classId,
                ]);
            }
        }
    }
}
