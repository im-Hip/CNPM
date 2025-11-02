<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Room;
use App\Models\TeacherAssignment;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource. (Xem lịch cho tất cả role)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $classId = $request->class_id ?? null;

        if ($user->role === 'student') {
            $classId = $user->student->class_id;
            $schedules = Schedule::where('class_id', $classId)
                ->with(['subject', 'teacher.user', 'room'])
                ->orderBy('day_of_week')
                ->orderBy('class_period')
                ->get();
            $title = 'Lịch Học Lớp Của Bạn';
            $classes = collect();
        } elseif ($user->role === 'teacher') {
            $schedules = Schedule::where('teacher_id', $user->id)
                ->with(['class', 'subject', 'room'])
                ->orderBy('day_of_week')
                ->orderBy('class_period')
                ->get();
            $title = 'Lịch Dạy Của Bạn';
            $classes = collect();
        } else { // Admin
            if (!$classId) {
                $classId = Classes::first()?->id ?? 0;
            }
            $schedules = Schedule::where('class_id', $classId)
                ->with(['subject', 'teacher.user', 'room'])
                ->orderBy('day_of_week')
                ->orderBy('class_period')
                ->get();
            $classes = Classes::all(['id', 'name']);
            $title = 'Quản Lý Lịch Học Lớp';
        }

        $scheduleByDay = $schedules->groupBy('day_of_week')->map(function ($daySchedules) {
            return $daySchedules->groupBy('class_period')->map(function ($periodSchedules) {
                return $periodSchedules->first();
            });
        });

        return view('schedules.index', [
            'scheduleByDay' => $scheduleByDay,
            'classes' => $classes,
            'title' => $title,
            'classId' => $classId
        ]);
    }

    /**
     * Show the form for creating a new resource. (Admin tạo lịch mới)
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $classes = Classes::all(['id', 'name']);
        $rooms = Room::all(['id', 'name']);

        return view('admin.schedules.create', compact('classes', 'rooms'));
    }

    /**
     * API: Get available subjects for a class (from assignments).
     */
    public function getSubjectsForClass($classId)
    {
        try {
            Log::info('Getting subjects for class', ['class_id' => $classId]);
            
            $subjects = \App\Models\Subject::whereHas('assignments', function ($query) use ($classId) {
                $query->where('class_id', $classId);
            })->get(['id', 'name']);
            
            Log::info('Subjects found', ['count' => $subjects->count()]);
            
            return response()->json($subjects);
            
        } catch (\Exception $e) {
            Log::error('Error getting subjects', [
                'class_id' => $classId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Lỗi khi tải môn học: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Lấy thông tin giáo viên được phân công cho lớp và môn học
     * Copy vào ScheduleController.php
     */
    public function getTeacherForClassSubject($classId, $subjectId)
    {
        try {
            Log::info('Getting teacher', [
                'class_id' => $classId,
                'subject_id' => $subjectId
            ]);
            
            $teacher = \App\Models\TeacherAssignment::getTeacherForClassSubject($classId, $subjectId);
            
            if (!$teacher) {
                Log::warning('No teacher assigned', [
                    'class_id' => $classId,
                    'subject_id' => $subjectId
                ]);
                
                return response()->json([
                    'id' => null,
                    'name' => 'Chưa phân công GV'
                ]);
            }
            
            Log::info('Teacher found', ['teacher_id' => $teacher->id]);
            
            return response()->json([
                'id' => $teacher->id,
                'name' => $teacher->user->name ?? 'GV ' . $teacher->id
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error getting teacher', [
                'class_id' => $classId,
                'subject_id' => $subjectId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Lỗi khi tải giáo viên: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Get available rooms based on day_of_week and class_period.
     */
    public function getAvailableRooms(Request $request)
    {
        $day = $request->query('day_of_week');
        $period = $request->query('class_period');
        $excludeScheduleId = $request->query('exclude_schedule_id');

        $query = Schedule::where('day_of_week', $day)
            ->where('class_period', $period);

        if ($excludeScheduleId) {
            $query->where('id', '!=', $excludeScheduleId);
        }

        $occupiedRoomIds = $query->pluck('room_id')
            ->filter()
            ->toArray();

        $rooms = Room::whereNotIn('id', $occupiedRoomIds)
            ->get(['id', 'name'])
            ->map(function ($room) {
                return ['id' => $room->id, 'name' => $room->name, 'is_occupied' => false];
            });

        $occupiedRooms = Room::whereIn('id', $occupiedRoomIds)
            ->get(['id', 'name'])
            ->map(function ($room) {
                return ['id' => $room->id, 'name' => $room->name, 'is_occupied' => true];
            });

        return response()->json($rooms->merge($occupiedRooms));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'room_id' => 'nullable|exists:rooms,id',
            'day_of_week' => 'required|integer|between:1,7',
            'class_period' => 'required|integer|between:1,10',
            'note' => 'nullable|string|max:255',
        ]);

        // Cast int
        $validated['class_id'] = (int) $validated['class_id'];
        $validated['subject_id'] = (int) $validated['subject_id'];
        $validated['room_id'] = $validated['room_id'] ? (int) $validated['room_id'] : null;
        $validated['day_of_week'] = (int) $validated['day_of_week'];
        $validated['class_period'] = (int) $validated['class_period'];

        // AUTO GÁN GV từ phân công
        $teacherAssignment = TeacherAssignment::where('class_id', $validated['class_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('status', 'active')
            ->first();

        if (!$teacherAssignment) {
            Log::warning('No teacher found for class and subject', [
                'class_id' => $validated['class_id'],
                'subject_id' => $validated['subject_id']
            ]);
            return back()->withErrors(['teacher' => 'Chưa có giáo viên được phân công cho môn này ở lớp này! Vui lòng phân công trước.'])->withInput();
        }

        $validated['teacher_id'] = $teacherAssignment->teacher_id; // Lấy teacher_id từ teacher_assignments

        // Check trùng tiết TRONG LỚP
        $existsInClass = Schedule::where('class_id', $validated['class_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('class_period', $validated['class_period'])
            ->exists();
        if ($existsInClass) {
            return back()->withErrors(['conflict' => 'Tiết này đã có lịch trong lớp!'])->withInput();
        }

        // Check trùng tiết CHO GIÁO VIÊN
        $teacherConflict = Schedule::where('teacher_id', $validated['teacher_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('class_period', $validated['class_period'])
            ->where('class_id', '!=', $validated['class_id'])
            ->exists();
        if ($teacherConflict) {
            $conflictSchedule = Schedule::where('teacher_id', $validated['teacher_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->where('class_period', $validated['class_period'])
                ->first();
            $conflictClass = $conflictSchedule->class->name ?? 'không xác định';
            return back()->withErrors(['teacher_conflict' => "Giáo viên này đã có lịch dạy lớp {$conflictClass} vào tiết này! Không thể trùng lặp."])->withInput();
        }

        // Check trùng phòng học
        if ($validated['room_id']) {
            $roomConflict = Schedule::where('room_id', $validated['room_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->where('class_period', $validated['class_period'])
                ->exists();
            if ($roomConflict) {
                $conflictSchedule = Schedule::where('room_id', $validated['room_id'])
                    ->where('day_of_week', $validated['day_of_week'])
                    ->where('class_period', $validated['class_period'])
                    ->first();
                $conflictClass = $conflictSchedule->class->name ?? 'không xác định';
                $room = Room::find($validated['room_id'])->name ?? 'không xác định';
                return back()->withErrors(['room_conflict' => "Phòng {$room} đã được sử dụng cho lớp {$conflictClass} vào Thứ {$validated['day_of_week']}, tiết {$validated['class_period']}!"])->withInput();
            }
        }

        // Tạo lịch học
        $schedule = Schedule::create($validated);

        return redirect()->route('schedules.index', ['class_id' => $validated['class_id']])
            ->with('success', 'Lịch học đã được thêm thành công với GV ' . ($teacherAssignment->teacher->user->name ?? 'Unknown') . '!');
    }

    /**
     * Store a new schedule via AJAX.
     */
    public function storeInline(Request $request)
    {
        Log::info('storeInline START', ['user_id' => Auth::id() ?? 'guest', 'request_all' => $request->all()]);

        if (!Auth::check() || Auth::user()->role !== 'admin') {
            Log::warning('Unauthorized or not admin');
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            $validated = $request->validate([
                'class_id' => 'required|exists:classes,id',
                'subject_id' => 'required|exists:subjects,id',
                'room_id' => 'nullable|exists:rooms,id',
                'day_of_week' => 'required|integer|between:1,7',
                'class_period' => 'required|integer|between:1,10',
                'note' => 'nullable|string|max:255',
            ]);

            // Cast int
            $validated['class_id'] = (int) $validated['class_id'];
            $validated['subject_id'] = (int) $validated['subject_id'];
            $validated['room_id'] = $validated['room_id'] ? (int) $validated['room_id'] : null;
            $validated['day_of_week'] = (int) $validated['day_of_week'];
            $validated['class_period'] = (int) $validated['class_period'];

            // AUTO GÁN GV từ phân công
            $teacher = TeacherAssignment::where('class_id', $validated['class_id'])
                ->where('subject_id', $validated['subject_id'])
                ->where('status', 'active')
                ->first();

            if (!$teacher) {
                Log::warning('No teacher found for class and subject', [
                    'class_id' => $validated['class_id'],
                    'subject_id' => $validated['subject_id']
                ]);
                return response()->json(['success' => false, 'message' => 'Chưa có giáo viên được phân công cho môn này ở lớp này! Vui lòng phân công trước.'], 422);
            }
            $validated['teacher_id'] = $teacher->id;
            $teacherName = $teacher->user?->name ?? 'Unknown';

            // Check trùng tiết TRONG LỚP
            $exists = Schedule::where('class_id', $validated['class_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->where('class_period', $validated['class_period'])
                ->exists();
            if ($exists) {
                Log::info('Conflict found in class');
                return response()->json(['success' => false, 'message' => 'Tiết này đã có lịch trong lớp!'], 422);
            }

            // Check trùng tiết CHO GIÁO VIÊN
            $teacherConflict = Schedule::where('teacher_id', $validated['teacher_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->where('class_period', $validated['class_period'])
                ->where('class_id', '!=', $validated['class_id'])
                ->exists();
            if ($teacherConflict) {
                $conflictSchedule = Schedule::where('teacher_id', $validated['teacher_id'])
                    ->where('day_of_week', $validated['day_of_week'])
                    ->where('class_period', $validated['class_period'])
                    ->first();
                $conflictClass = $conflictSchedule->class->name ?? 'không xác định';
                Log::warning('Teacher conflict found', ['teacher_id' => $validated['teacher_id'], 'conflict_class' => $conflictClass]);
                return response()->json([
                    'success' => false,
                    'message' => "Giáo viên này đã có lịch dạy lớp {$conflictClass} vào tiết này! Không thể trùng lặp."
                ], 422);
            }

            // Check trùng phòng học
            if ($validated['room_id']) {
                $roomConflict = Schedule::where('room_id', $validated['room_id'])
                    ->where('day_of_week', $validated['day_of_week'])
                    ->where('class_period', $validated['class_period'])
                    ->exists();
                if ($roomConflict) {
                    $conflictSchedule = Schedule::where('room_id', $validated['room_id'])
                        ->where('day_of_week', $validated['day_of_week'])
                        ->where('class_period', $validated['class_period'])
                        ->first();
                    $conflictClass = $conflictSchedule->class->name ?? 'không xác định';
                    $room = Room::find($validated['room_id'])->name ?? 'không xác định';
                    Log::warning('Room conflict found', ['room_id' => $validated['room_id'], 'conflict_class' => $conflictClass]);
                    return response()->json([
                        'success' => false,
                        'message' => "Phòng {$room} đã được sử dụng cho lớp {$conflictClass} vào Thứ {$validated['day_of_week']}, tiết {$validated['class_period']}!"
                    ], 422);
                }
            }

            $schedule = Schedule::create($validated);

            // Gửi thông báo khi tạo lịch (giữ lại, có thể xóa nếu bạn yêu cầu)
            $class = Classes::find($validated['class_id']);
            Notification::create([
                'title' => 'Lịch học mới',
                'content' => "Lịch học mới cho lớp {$class->name}: {$schedule->subject->name} vào Thứ {$validated['day_of_week']}, tiết {$validated['class_period']}" . ($validated['room_id'] ? " tại phòng {$schedule->room->name}" : ""),
                'type' => 'event',
                'sender_id' => Auth::id(),
                'recipient_type' => 'class',
                'recipient_id' => $class->id,
                'sent_at' => now(),
            ]);

            $schedule->load(['subject', 'teacher.user', 'room']);

            return response()->json([
                'success' => true,
                'message' => "Lịch mới đã tạo với GV {$teacherName}!",
                'schedule' => $schedule
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'message' => 'Validation failed: ' . $e->getMessage()], 422);
        } catch (\Throwable $e) {
            Log::error('storeInline EXCEPTION: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Lỗi server: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $classes = Classes::all(['id', 'name']);
        $rooms = Room::all(['id', 'name']);

        return view('admin.schedules.edit', compact('schedule', 'classes', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        if (Auth::user()->role !== 'admin') abort(403);
    
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'room_id' => 'nullable|exists:rooms,id',
            'day_of_week' => 'required|integer|between:1,7',
            'class_period' => 'required|integer|between:1,10',
            'note' => 'nullable|string|max:255',
        ]);
    
        // Cast int
        $validated['class_id'] = (int) $validated['class_id'];
        $validated['subject_id'] = (int) $validated['subject_id'];
        $validated['room_id'] = $validated['room_id'] ? (int) $validated['room_id'] : null;
        $validated['day_of_week'] = (int) $validated['day_of_week'];
        $validated['class_period'] = (int) $validated['class_period'];
    
        // AUTO GÁN GV từ phân công dựa trên class_id và subject_id hiện tại
        $teacherAssignment = TeacherAssignment::where('class_id', $validated['class_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('status', 'active')
            ->first();
    
        if (!$teacherAssignment) {
            Log::warning('No teacher found for class and subject during update', [
                'class_id' => $validated['class_id'],
                'subject_id' => $validated['subject_id'],
                'schedule_id' => $schedule->id
            ]);
            return back()->withErrors(['teacher' => 'Chưa có giáo viên được phân công cho môn này ở lớp này! Vui lòng phân công trước.'])->withInput();
        }
    
        $validated['teacher_id'] = $teacherAssignment->teacher_id; // Lấy teacher_id từ teacher_assignments
    
        // Check trùng tiết TRONG LỚP (trừ bản ghi hiện tại)
        $existsInClass = Schedule::where('class_id', $validated['class_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('class_period', $validated['class_period'])
            ->where('id', '!=', $schedule->id)
            ->exists();
        if ($existsInClass) {
            return back()->withErrors(['conflict' => 'Tiết này đã có lịch trong lớp!'])->withInput();
        }
    
        // Check trùng tiết CHO GIÁO VIÊN (trừ bản ghi hiện tại)
        $teacherConflict = Schedule::where('teacher_id', $validated['teacher_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('class_period', $validated['class_period'])
            ->where('id', '!=', $schedule->id)
            ->where('class_id', '!=', $validated['class_id'])
            ->exists();
        if ($teacherConflict) {
            $conflictSchedule = Schedule::where('teacher_id', $validated['teacher_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->where('class_period', $validated['class_period'])
                ->first();
            $conflictClass = $conflictSchedule->class->name ?? 'không xác định';
            return back()->withErrors(['teacher_conflict' => "Giáo viên này đã có lịch dạy lớp {$conflictClass} vào tiết này! Không thể trùng lặp."])->withInput();
        }
    
        // Check trùng phòng học (trừ bản ghi hiện tại)
        if ($validated['room_id']) {
            $roomConflict = Schedule::where('room_id', $validated['room_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->where('class_period', $validated['class_period'])
                ->where('id', '!=', $schedule->id)
                ->exists();
            if ($roomConflict) {
                $conflictSchedule = Schedule::where('room_id', $validated['room_id'])
                    ->where('day_of_week', $validated['day_of_week'])
                    ->where('class_period', $validated['class_period'])
                    ->first();
                $conflictClass = $conflictSchedule->class->name ?? 'không xác định';
                $room = Room::find($validated['room_id'])->name ?? 'không xác định';
                return back()->withErrors(['room_conflict' => "Phòng {$room} đã được sử dụng cho lớp {$conflictClass} vào Thứ {$validated['day_of_week']}, tiết {$validated['class_period']}!"])->withInput();
            }
        }
    
        // Cập nhật lịch học
        $schedule->update($validated);
    
        return redirect()->route('schedules.index', ['class_id' => $validated['class_id']])
            ->with('success', 'Lịch học đã được cập nhật thành công với GV ' . ($teacherAssignment->teacher->user->name ?? 'Unknown') . '!');
    }

    /**
     * Update schedule via AJAX.
     */
    public function updateInline(Request $request, Schedule $schedule)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'room_id' => 'nullable|exists:rooms,id',
            'note' => 'nullable|string|max:255',
        ]);

        // Auto gán GV mới nếu thay môn
        $teacher = TeacherAssignment::where('class_id', $schedule->class_id)
            ->where('subject_id', $validated['subject_id'])
            ->where('status', 'active')
            ->first();

        if (!$teacher) {
            Log::warning('No teacher found for class and subject', [
                'class_id' => $schedule->class_id,
                'subject_id' => $validated['subject_id']
            ]);
            return response()->json(['success' => false, 'message' => 'Chưa có giáo viên được phân công cho môn này ở lớp này! Vui lòng phân công trước.'], 422);
        }
        $validated['teacher_id'] = $teacher->id;

        // Check trùng phòng học
        if ($validated['room_id']) {
            $roomConflict = Schedule::where('room_id', $validated['room_id'])
                ->where('day_of_week', $schedule->day_of_week)
                ->where('class_period', $schedule->class_period)
                ->where('id', '!=', $schedule->id)
                ->exists();
            if ($roomConflict) {
                $conflictSchedule = Schedule::where('room_id', $validated['room_id'])
                    ->where('day_of_week', $schedule->day_of_week)
                    ->where('class_period', $schedule->class_period)
                    ->first();
                $conflictClass = $conflictSchedule->class->name ?? 'không xác định';
                $room = Room::find($validated['room_id'])->name ?? 'không xác định';
                return response()->json([
                    'success' => false,
                    'message' => "Phòng {$room} đã được sử dụng cho lớp {$conflictClass} vào Thứ {$schedule->day_of_week}, tiết {$schedule->class_period}!"
                ], 422);
            }
        }

        $schedule->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lịch đã cập nhật với GV ' . $teacher->user->name . '!',
            'schedule' => $schedule->fresh()->load(['subject', 'teacher.user', 'room'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $classId = $schedule->class_id;
        $schedule->delete();

        return redirect()->route('schedules.index', ['class_id' => $classId])
            ->with('success', 'Lịch học đã được xóa thành công!');
    }

    /**
     * Remove the specified resource via AJAX.
     */
    public function destroyInline(Schedule $schedule)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $classId = $schedule->class_id;
        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lịch học đã được xóa thành công!',
            'class_id' => $classId
        ]);
    }

    /**
     * Export PDF lịch học theo lớp (student/admin)
     */
    public function exportPdf(Request $request, $classId = null)
    {
        $user = Auth::user();
        $classId = $classId ?? $request->class_id ?? null;
    
        if ($user->role === 'student') {
            $classId = $user->student->class_id;
        } elseif (!$classId && $user->role === 'admin') {
            $classId = Classes::first()?->id ?? 1;
        }
    
        $schedules = Schedule::where('class_id', $classId)
            ->with(['subject', 'teacher.user', 'room', 'class'])
            ->orderBy('day_of_week')
            ->orderBy('class_period')
            ->get();
    
        $scheduleByDay = $schedules->groupBy('day_of_week')->map(function ($daySchedules) {
            return $daySchedules->groupBy('class_period')->map(function ($periodSchedules) {
                return $periodSchedules->first();
            });
        });
    
        $className = Classes::find($classId)->name ?? 'Không xác định';
        $title = $user->role === 'student' ? 'Lịch Học' : 'Lịch Học Lớp ' . $className;
    
        $pdf = Pdf::loadView('schedules.pdf', compact('scheduleByDay', 'title', 'className'));
        return $pdf->download("lich-hoc-{$className}.pdf");
    }

    /**
     * Export PDF lịch dạy theo giáo viên (teacher)
     */
    public function exportTeacherPdf(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'teacher') abort(403);
    
        $schedules = Schedule::where('teacher_id', $user->id)
            ->with(['class', 'subject', 'room'])
            ->orderBy('day_of_week')
            ->orderBy('class_period')
            ->get();
    
        $scheduleByDay = $schedules->groupBy('day_of_week')->map(function ($daySchedules) {
            return $daySchedules->groupBy('class_period')->map(function ($periodSchedules) {
                return $periodSchedules->first();
            });
        });
    
        $title = 'Lịch Dạy Của ' . $user->name;
        $classNames = $schedules->pluck('class.name')->unique()->implode(', ');
    
        $pdf = Pdf::loadView('schedules.pdf', compact('scheduleByDay', 'title', 'classNames'));
        return $pdf->download("lich-day-{$user->name}.pdf");
    }
}