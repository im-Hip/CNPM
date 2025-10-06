<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        Notification::create([
            'title' => 'Sample Notification 1',
            'content' => 'This is a sample notification',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Notification::create([
            'title' => 'Sample Notification 2',
            'content' => 'This is another sample notification',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}