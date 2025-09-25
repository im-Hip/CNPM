<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('announcements')->insert([
            [
                'title' => 'Thông báo kiểm tra giữa kỳ',
                'content' => 'Học sinh chuẩn bị cho bài kiểm tra giữa kỳ môn Toán.',
                'receiver' => 'student',
                'seeding_time' => now()->addDays(1),
                'schedule_id' => 1, // giả sử tồn tại schedule_id=1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Họp giáo viên',
                'content' => 'Toàn thể giáo viên họp vào thứ 6 tuần này tại phòng hội đồng.',
                'receiver' => 'teacher',
                'seeding_time' => now()->addDays(2),
                'schedule_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Nghỉ học toàn trường',
                'content' => 'Toàn trường nghỉ học vào ngày 10/10/2025 để bảo trì hệ thống.',
                'receiver' => 'all',
                'seeding_time' => now()->addDays(5),
                'schedule_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
