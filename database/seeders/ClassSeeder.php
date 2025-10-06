<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classes;

class ClassSeeder extends Seeder
{
    public function run()
    {
        Classes::create([
            'name' => '10A1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Classes::create([
            'name' => '11A1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Classes::create([
            'name' => '12A1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}