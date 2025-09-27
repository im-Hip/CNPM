<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            'name' => '10A1',
            'capacity' => 50
        ]);

        Room::create([
            'name' => '10A2',
            'capacity' => 50
        ]);

        Room::create([
            'name' => '11A1',
            'capacity' => 50
        ]);

        Room::create([
            'name' => '12A1',
            'capacity' => 50
        ]);

        Room::create([
            'name' => 'computer room 1',
            'capacity' => 50
        ]);

        Room::create([
            'name' => 'seminar room 1',
            'capacity' => 50
        ]);

        Room::create([
            'name' => 'computer room 2',
            'capacity' => 50
        ]);
    }
}
