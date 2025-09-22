<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $subjects = [
            'Programming', 'Data Structures', 'Operating Systems', 'Database Management', 'Cybersecurity', 'Artificial Intelligence', 
            'Cloud Computing', 'Data Analytics'
        ];

        $sessions = [
            ['06:30:00', '09:00:00'],
            ['09:10:00', '11:40:00'],
            ['12:30:00', '15:00:00'],
            ['15:10:00', '17:40:00'],
        ];

        for ($i = 0; $i<10; $i++){
            $subject = $faker->randomElement($subjects);
            $session = $faker->randomElement($sessions);

            DB::table('schedules')->insert([
                'subject'    => $subject,
                'teacher'    => $faker->name,
                'date'       => $faker->dateTimeBetween('2020-01-01', 'now')->format('Y-m-d'),
                'start_time' => $session[0],
                'end_time'   => $session[1],
                'room'       => $faker->randomElement(['A', 'B', 'C', 'I']) . $faker->numberBetween(101, 310),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
