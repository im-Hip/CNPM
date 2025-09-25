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
            'name' => 'classroom 1',
            'capacity' => 50
        ]);

        Room::create([
            'name' => 'classroom 2',
            'capacity' => 50
        ]);

        Room::create([
            'name' => 'classroom 3',
            'capacity' => 50
        ]);

        Room::create([
            'name' => 'classroom 4',
            'capacity' => 50
        ]);

        Room::create([
            'name' => 'classroom 5',
            'capacity' => 50
        ]);

        Room::create([
            'name' => 'seminar room 1',
            'capacity' => 50
        ]);

        Room::create([
            'name' => 'computer room 1',
            'capacity' => 50
        ]);
    }
}
