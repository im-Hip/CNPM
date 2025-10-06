<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run()
    {
        Room::create([
            'name' => 'Room 101',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Room::create([
            'name' => 'Room 102',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Room::create([
            'name' => 'Room 103',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}