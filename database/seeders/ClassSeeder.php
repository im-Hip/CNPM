<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classes;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classes::create([
            'name' => '10A1',
            'grade' => 10,
            'number_of_students' => 50,
        ]);
        
        Classes::create([
            'name' => '10A2',
            'grade' => 10,
            'number_of_students' => 50,
        ]);

        Classes::create([
            'name' => '11A1',
            'grade' => 11,
            'number_of_students' => 50,
        ]);

        Classes::create([
            'name' => '12A1',
            'grade' => 12,
            'number_of_students' => 50,
        ]);
    }
}
