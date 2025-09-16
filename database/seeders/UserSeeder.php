<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'hadanghiep@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Teacher User',
            'email' => 'hadanghiep001@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'teacher',
        ]);

        User::create([
            'name' => 'Student User',
            'email' => 'hiepha.sgeovn@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'student',
        ]);
    }
}
