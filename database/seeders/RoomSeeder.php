<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
    [ 'name'=> 'Classroom 10A1', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 10A2', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 10A3', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 10A4', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 10A5', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 10A6', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 10A7', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 11A1', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 11A2', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 11A3', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 11A4', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 11A5', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 11A6', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 11A7', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 12A1', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 12A2', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 12A3', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 12A4', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 12A5', 'capacity'=> 50 ],
    [ 'name'=> 'Classroom 12A6', 'capacity'=> 50 ],
    [ 'name'=> 'Lab G701', 'capacity'=> 50 ],
    [ 'name'=> 'Lab G702', 'capacity'=> 50 ],
    [ 'name'=> 'Lecture Hall 5', 'capacity'=> 150 ],
    [ 'name'=> 'Lecture Hall 6', 'capacity'=> 150 ],
    [ 'name'=> 'Seminar Room 5', 'capacity'=> 50 ],
    [ 'name'=> 'Seminar Room 6', 'capacity'=> 50 ],
    [ 'name'=> 'Seminar Room 7', 'capacity'=> 50 ],
    [ 'name'=> 'Lab I202', 'capacity'=> 50 ],
    [ 'name'=> 'Seminar Room 8', 'capacity'=> 50 ],
    [ 'name'=> 'Lab I902', 'capacity'=> 50 ],
        ]);
    }
}
