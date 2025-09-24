<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeleteRoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ids = DB::table('rooms')
            ->orderBy('id')
            ->skip('22')
            ->take(2)
            ->pluck('id');
        DB::table('rooms')->whereIn('id', $ids)->delete();

        $this->command->info("Da xoa dong 23 va 24 thanh cong");
    }
}
