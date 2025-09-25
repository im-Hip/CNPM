<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'teacher')->get();
        $subjects = Subject::pluck('id')->toArray();
        $levels  = ['Bachelor', 'Master', 'PhD'];

        $i = 1;
        foreach ($users as $user) {
            DB::table('teachers')->insert([
                'id'         => $user->id, // PK đồng thời là FK đến users
                'teacher_id' => 'GV' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'subject_id' => fake()->randomElement($subjects),
                'level'      => fake()->randomElement($levels),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $i++;
        }
    }
}
