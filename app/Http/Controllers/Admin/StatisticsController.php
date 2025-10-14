<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StatisticsController extends Controller
{
    public function index()
    {
        // 1. Thống kê học sinh theo lớp
        $classStats = DB::table('classes')
            ->leftJoin('students', 'classes.id', '=', 'students.class_id')
            ->groupBy('classes.id', 'classes.name')
            ->selectRaw('classes.name as label, COALESCE(COUNT(students.id), 0) as value')
            ->orderBy('label')
            ->get()
            ->map(fn($row) => ['label' => $row->label, 'value' => (int)$row->value])
            ->toArray();

        // 2. Thống kê giáo viên theo môn học
        $subjectStats = DB::table('subjects')
            ->leftJoin('teachers', 'subjects.id', '=', 'teachers.subject_id')
            ->groupBy('subjects.id', 'subjects.name')
            ->selectRaw('subjects.name as label, COUNT(DISTINCT teachers.id) as value')
            ->orderBy('label')
            ->get()
            ->map(fn($row) => ['label' => $row->label, 'value' => (int)$row->value])
            ->toArray();

        // 3. Thống kê giáo viên theo học hàm
        $levelStats = DB::table('teachers')
            ->selectRaw('level, COUNT(*) as count')
            ->groupBy('level')
            ->get()
            ->map(function ($teacher) {
                $vietnamese = [
                    'Bachelor' => 'Cử nhân',
                    'Master' => 'Thạc sĩ',
                    'PhD' => 'Tiến sĩ'
                ];
                return [
                    'label' => $vietnamese[$teacher->level] ?? $teacher->level ?? 'Không xác định',
                    'value' => (int)$teacher->count
                ];
            })->toArray();

        // 4. Thống kê lịch học theo lớp (pie chart)
        $scheduleRaw = DB::table('schedules')
            ->join('classes', 'schedules.class_id', '=', 'classes.id')
            ->leftJoin('subjects', 'schedules.subject_id', '=', 'subjects.id')
            ->selectRaw('
                classes.name as class_name,
                COALESCE(subjects.name, "Không xác định") as subject_name,
                COUNT(schedules.id) as session_count
            ')
            ->groupBy('classes.id', 'classes.name', 'subjects.id', 'subjects.name')
            ->orderBy('classes.name')
            ->get();

        // Group thành cấu trúc cho pie chart
        $scheduleStats = $scheduleRaw
            ->groupBy('class_name')
            ->map(function ($group, $className) {
                $subjects = $group->map(fn($row) => [
                    'label' => $row->subject_name,
                    'value' => (int)$row->session_count
                ])->filter(fn($s) => $s['value'] > 0)->values()->toArray();
                
                return [
                    'class_name' => $className,
                    'subjects' => $subjects
                ];
            })
            ->filter(fn($stat) => !empty($stat['subjects'])) // Chỉ giữ lớp có môn
            ->values()
            ->toArray();
        $notificationTypeStats = \DB::table('notifications')
        ->selectRaw('type, COUNT(DISTINCT CONCAT(sender_id, title, content, DATE(sent_at))) as send_count')
        ->groupBy('type')
        ->get()
        ->map(function ($row) {
            $typeNames = [
                'event' => 'Sự kiện',
                'exam' => 'Kỳ thi',
                'assignment' => 'Bài tập',
                'warning' => 'Cảnh báo',
                'scholarship' => 'Học bổng'
            ];
            return [
                'label' => $typeNames[$row->type] ?? $row->type,
                'value' => (int)$row->send_count
            ];
        })->toArray();

    // Fallback nếu rỗng
    if (empty($notificationTypeStats)) {
        $notificationTypeStats = [
            ['label' => 'Sự kiện', 'value' => 0],
            ['label' => 'Kỳ thi', 'value' => 0],
            ['label' => 'Bài tập', 'value' => 0],
            ['label' => 'Cảnh báo', 'value' => 0],
            ['label' => 'Học bổng', 'value' => 0]
        ];
    }

        return view('admin.statistics.index', compact(
            'classStats', 'subjectStats', 'levelStats', 'scheduleStats', 'notificationTypeStats'
        ));
    }
}