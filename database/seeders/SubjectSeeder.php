<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;
//             'math', 4
//             'physics', 3
//             'chemistry', 3
//             'biology', 3
//             'literature', 4
//             'history', 3
//             'geography', 3
//             'english', 4
//             'IT', 2
//             'exercise' 1

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create([
            'name' => 'math',
            'subject_id' => 'MATH001',
            'number_of_periods' => '4'
        ]);

        Subject::create([
            'name' => 'physics',
            'subject_id' => 'PHYS001',
            'number_of_periods' => '3'
        ]);

        Subject::create([
            'name' => 'chemistry',
            'subject_id' => 'CHEM001',
            'number_of_periods' => '3'
        ]);

        Subject::create([
            'name' => 'biology',
            'subject_id' => 'BIOL001',
            'number_of_periods' => '3'
        ]);

        Subject::create([
            'name' => 'literature',
            'subject_id' => 'LITE001',
            'number_of_periods' => '4'
        ]);

        Subject::create([
            'name' => 'history',
            'subject_id' => 'HIST001',
            'number_of_periods' => '3'
        ]);

        Subject::create([
            'name' => 'geography',
            'subject_id' => 'GEOG001',
            'number_of_periods' => '3'
        ]);

        Subject::create([
            'name' => 'english',
            'subject_id' => 'ENGL001',
            'number_of_periods' => '4'
        ]);

        Subject::create([
            'name' => 'IT',
            'subject_id' => 'COMP001',
            'number_of_periods' => '2'
        ]);

        Subject::create([
            'name' => 'exercise',
            'subject_id' => 'EXER001',
            'number_of_periods' => '1'
        ]);
    }
}
