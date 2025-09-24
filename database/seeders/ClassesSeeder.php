<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomIds = DB::table('rooms')->orderBy('id')->limit(20)->pluck('id')->toArray();
        $teacherIds = DB::table('teachers')->pluck('id')->take(20)->toArray();

        if(count($roomIds) < 20){
            $this->command->warn("Chua co du 20 phong trong bang rooms!");
        }

        if(count($teacherIds) < 20){
            $this->command->warn("Chua co du 20 teacher trong bang teachers!");
        }

        foreach($roomIds as $index => $roomId) {
            DB::table('classes')->insert([
                'number_of_students' => rand(40,50),
                'room_id'            => $roomId,
                'teacher_id'         =>$teacherIds[$index],
            ]);
        }

        $this->command->info("Success!");
    }
}
