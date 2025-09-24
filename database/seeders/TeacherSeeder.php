<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'teacher')->get();

        foreach ($users as $user) {
            Teacher::create([
                'user_id' => $user->id,
                'phone' => fake()->numerify('0#########'),
                'subject' => fake()->randomElement(['Math','Physics','Chemistry','History','Geography','Biology','English','Civic education','Technology','National Defense Education','Physical Education','Computer Science']),
            ]);
        }

        $this->command->info("Success!");
    }
}
