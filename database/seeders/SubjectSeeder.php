<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        Subject::create([
            'name' => 'Math',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Subject::create([
            'name' => 'Science',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Subject::create([
            'name' => 'English',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}