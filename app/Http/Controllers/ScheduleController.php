<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;  // Sửa từ 'Use'
use Carbon\Carbon;  // Dùng để xử lý thời gian
use App\Models\Schedule;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Room;
use App\Models\TeacherAssignment;  // Thêm cho check assignment
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;  // Thư viện PDF

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
            $classes = collect();  // Fix: Định nghĩa rỗng cho student (không filter)
        } elseif ($user->role === 'teacher') {
            $schedules = Schedule::where('teacher_id', $user->id)
                ->with(['class', 'subject', 'room'])
                ->orderBy('day_of_week')
                ->orderBy('class_period')
                ->get();
            $title = 'Lịch Dạy Của Bạn';
            $classes = collect();  // Fix: Rỗng cho teacher
        } else {  // Admin
            if (!$classId) {
                $classId = Classes::first()?->id ?? 0;
            }
            $schedules = Schedule::where('class_id', $classId)
                ->with(['subject', 'teacher.user', 'room'])
                ->orderBy('day_of_week')
                ->orderBy('class_period')
                ->get();
            $classes = Classes::all(['id', 'name']);  // Chỉ admin có filter
            $title = 'Quản Lý Lịch Học Lớp';
        }

        $scheduleByDay = $schedules->groupBy('day_of_week')->map(function ($daySchedules) {
            return $daySchedules->groupBy('class_period')->map(function ($periodSchedules) {
                return $periodSchedules->first();
            });
        });

        // Dùng array thay compact để tránh undefined
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

        // Subjects load dynamic bằng JS/API, không load static
        return view('admin.schedules.create', compact('classes', 'rooms'));  // Thêm "admin." để match path
    }

    /**
     * API: Get available subjects for a class (from assignments).
     */
    public function getSubjectsForClass($classId)
    {
        $subjects = Subject::whereHas('assignments', function ($q) use ($classId) {
            $q->where('class_id', $classId);
        })->get(['id', 'name']);
    
        return response()->json($subjects);
    }

    /**
     * API: Get available subjects for a class (from assignments).
     */
    /**
 * API: Get assigned teacher for class + subject (auto show read-only).
 */
    public function getTeacherForClassSubject($classId, $subjectId)
    {
        $teacher = TeacherAssignment::getTeacherForClassSubject($classId, $subjectId);
        if (!$teacher) {
            return response()->json(['name' => 'Chưa phân công GV', 'id' => null]);
        }

        return response()->json([
            'name' => $teacher->user->name ?? 'GV ' . $teacher->id,
            'id' => $teacher->id
        ]);
    }
    /**
     * Store a newly created resource in storage. (Tạo lịch với teacher null)
         */
        /**
     * Store a newly created resource in storage. (Tạo lịch với teacher null)
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

        // Cast string to int
        $validated['class_id'] = (int) $validated['class_id'];
        $validated['subject_id'] = (int) $validated['subject_id'];
        $validated['room_id'] = $validated['room_id'] ? (int) $validated['room_id'] : null;
        $validated['day_of_week'] = (int) $validated['day_of_week'];
        $validated['class_period'] = (int) $validated['class_period'];

        // AUTO GÁN GV từ phân công
        $teacher = TeacherAssignment::getTeacherForClassSubject($validated['class_id'], $validated['subject_id']);
        if (!$teacher) {
            return back()->withErrors(['teacher' => 'Chưa có GV cho môn này ở lớp! Phân công trước.'])->withInput();
        }
        $validated['teacher_id'] = $teacher->id;

        // Check trùng tiết TRONG CỖNG LỚP (giữ nguyên)
        $existsInClass = Schedule::where('class_id', $validated['class_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('class_period', $validated['class_period'])
            ->exists();
        if ($existsInClass) {
            return back()->withErrors(['conflict' => 'Tiết này đã có lịch trong lớp!'])->withInput();
        }

        // THÊM MỚI: Check trùng tiết CHO GIÁO VIÊN (trên tất cả lớp)
        $teacherConflict = Schedule::where('teacher_id', $validated['teacher_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('class_period', $validated['class_period'])
            ->where('class_id', '!=', $validated['class_id'])  // Không check lớp hiện tại (đã check ở trên)
            ->exists();
        if ($teacherConflict) {
            $conflictSchedule = Schedule::where('teacher_id', $validated['teacher_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->where('class_period', $validated['class_period'])
                ->first();
            $conflictClass = $conflictSchedule->class->name ?? 'không xác định';
            return back()->withErrors(['teacher_conflict' => "Giáo viên này đã có lịch dạy lớp {$conflictClass} vào tiết này! Không thể trùng lặp."])->withInput();
        }

        Schedule::create($validated);

        return redirect()->route('schedules.index', ['class_id' => $validated['class_id']])
            ->with('success', 'Lịch học đã được thêm thành công với GV ' . ($teacher->user?->name ?? 'Unknown') . '!');
    }

    // Các method resource khác (nếu cần CRUD đầy đủ - tùy chọn)
    public function show(Schedule $schedule)
    {
        $schedule->load(['class', 'subject', 'teacher.user', 'room']);
        return view('schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $classes = Classes::all(['id', 'name']);
        $rooms = Room::all(['id', 'name']);

        return view('admin.schedules.edit', compact('schedule', 'classes', 'rooms'));
    }   

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

        // AUTO GÁN GV từ phân công (giữ nguyên teacher_id nếu không đổi class/subject)
        $teacher = TeacherAssignment::getTeacherForClassSubject($validated['class_id'], $validated['subject_id']);
        if (!$teacher) {
            return back()->withErrors(['teacher' => 'Chưa có GV cho môn này ở lớp! Phân công trước.'])->withInput();
        }
        $validated['teacher_id'] = $teacher->id;

        // Check trùng tiết TRONG LỚP (loại trừ id hiện tại)
        $existsInClass = Schedule::where('class_id', $validated['class_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('class_period', $validated['class_period'])
            ->where('id', '!=', $schedule->id)  // Không check chính nó
            ->exists();
        if ($existsInClass) {
            return back()->withErrors(['conflict' => 'Tiết này đã có lịch trong lớp!'])->withInput();
        }

        // Check trùng tiết CHO GIÁO VIÊN (trên lớp khác, loại trừ id hiện tại)
        $teacherConflict = Schedule::where('teacher_id', $validated['teacher_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('class_period', $validated['class_period'])
            ->where('class_id', '!=', $validated['class_id'])
            ->where('id', '!=', $schedule->id)  // Không check chính nó
            ->exists();
        if ($teacherConflict) {
            $conflictSchedule = Schedule::where('teacher_id', $validated['teacher_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->where('class_period', $validated['class_period'])
                ->where('class_id', '!=', $validated['class_id'])
                ->where('id', '!=', $schedule->id)
                ->with('class')
                ->first();
            $conflictClassName = $conflictSchedule->class->name ?? 'không xác định';
            return back()->withErrors(['teacher_conflict' => "Giáo viên này đã có lịch dạy lớp {$conflictClassName} vào tiết này!"])->withInput();
        }

        $schedule->update($validated);

        return redirect()->route('schedules.index', ['class_id' => $validated['class_id']])
            ->with('success', 'Lịch học đã được cập nhật thành công!');
    }

    public function destroy(Schedule $schedule)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $oldClassId = $schedule->class_id;
        $schedule->delete();

        return redirect()->route('schedules.index', ['class_id' => $oldClassId])
            ->with('success', 'Lịch học đã được xóa thành công!');
    }

        /**
     * Inline update schedule (AJAX từ bảng)
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
            // day_of_week/class_period fixed, không validate
        ]);

        // Auto gán GV mới nếu thay môn
        $teacher = TeacherAssignment::getTeacherForClassSubject($schedule->class_id, $validated['subject_id']);
        if (!$teacher) {
            return response()->json(['success' => false, 'message' => 'Chưa có GV cho môn mới!'], 422);
        }
        $validated['teacher_id'] = $teacher->id;

        $schedule->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lịch đã cập nhật với GV ' . $teacher->user->name . '!',
            'schedule' => $schedule->fresh()->load(['subject', 'teacher.user', 'room'])
        ]);
    }

    /**
     * Inline delete schedule (AJAX)
     */
    public function destroyInline(Schedule $schedule)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lịch đã xóa!'
        ]);
    }

    /**
     * Inline add new schedule (AJAX từ ô trống)
     */
    public function storeInline(Request $request)
    {
        Log::info('storeInline START', ['user_id' => Auth::id() ?? 'guest', 'request_all' => $request->all()]);
    
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            Log::warning('Unauthorized or not admin');
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
    
        try {
            Log::info('Before validation');
            $validated = $request->validate([
                'class_id' => 'required|exists:classes,id',
                'subject_id' => 'required|exists:subjects,id',
                'room_id' => 'nullable|exists:rooms,id',
                'day_of_week' => 'required|integer|between:1,7',
                'class_period' => 'required|integer|between:1,10',
                'note' => 'nullable|string|max:255',
            ]);
            Log::info('Validation PASSED', ['validated' => $validated]);
        
            // Cast string to int (thêm để an toàn, tránh truncated)
            $validated['class_id'] = (int) $validated['class_id'];
            $validated['subject_id'] = (int) $validated['subject_id'];
            $validated['room_id'] = $validated['room_id'] ? (int) $validated['room_id'] : null;
            $validated['day_of_week'] = (int) $validated['day_of_week'];
            $validated['class_period'] = (int) $validated['class_period'];
        
            // AUTO GÁN GV từ phân công
            Log::info('Before getTeacher');
            $teacher = TeacherAssignment::getTeacherForClassSubject($validated['class_id'], $validated['subject_id']);
            if (!$teacher) {
                Log::warning('No teacher found', ['class_id' => $validated['class_id'], 'subject_id' => $validated['subject_id']]);
                return response()->json(['success' => false, 'message' => 'Chưa có GV cho môn này ở lớp! Phân công trước.'], 422);
            }
            $validated['teacher_id'] = $teacher->id;
            $teacherName = $teacher->user?->name ?? 'Unknown';
            Log::info('Teacher ASSIGNED', ['teacher_id' => $teacher->id, 'teacher_name' => $teacherName]);
        
            // Check trùng tiết TRONG CỖNG LỚP (giữ nguyên)
            Log::info('Before conflict check');
            $exists = Schedule::where('class_id', $validated['class_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->where('class_period', $validated['class_period'])
                ->exists();
            if ($exists) {
                Log::info('Conflict found in class');
                return response()->json(['success' => false, 'message' => 'Tiết này đã có lịch trong lớp!'], 422);
            }
        
            // THÊM MỚI: Check trùng tiết CHO GIÁO VIÊN (trên tất cả lớp khác)
            Log::info('Before teacher conflict check');
            $teacherConflict = Schedule::where('teacher_id', $validated['teacher_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->where('class_period', $validated['class_period'])
                ->where('class_id', '!=', $validated['class_id'])  // Không check lớp hiện tại
                ->with('class')  // Load relation class để lấy tên lớp conflict
                ->exists();
            if ($teacherConflict) {
                $conflictSchedule = Schedule::where('teacher_id', $validated['teacher_id'])
                    ->where('day_of_week', $validated['day_of_week'])
                    ->where('class_period', $validated['class_period'])
                    ->where('class_id', '!=', $validated['class_id'])
                    ->with('class')
                    ->first();
                $conflictClassName = $conflictSchedule->class->name ?? 'không xác định';
                Log::warning('Teacher conflict found', ['teacher_id' => $validated['teacher_id'], 'conflict_class' => $conflictClassName]);
                return response()->json([
                    'success' => false, 
                    'message' => "Giáo viên này đã có lịch dạy lớp {$conflictClassName} vào tiết này! Không thể trùng lặp."
                ], 422);
            }
        
            Log::info('Before create schedule');
            $schedule = Schedule::create($validated);
            Log::info('Schedule CREATED', ['id' => $schedule->id, 'validated' => $validated]);
        
            // Load relations safe
            $schedule->load(['subject', 'teacher.user', 'room']);
        
            Log::info('SUCCESS: Returning JSON');
            return response()->json([
                'success' => true,
                'message' => "Lịch mới đã tạo với GV {$teacherName}!",
                'schedule' => $schedule
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'message' => 'Validation failed: ' . $e->getMessage()], 422);
        } catch (\Throwable $e) {  // Catch all (Exception + Error)
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

    public function getTeachersForClass($classId)
    {
        $teacher = TeacherAssignment::getTeacherForClassSubject($classId, $subjectId);
        if (!$teacher) {
            return response()->json(['name' => 'Chưa phân công GV', 'id' => null]);
        }

        return response()->json([
            'name' => $teacher->user->name ?? 'GV ' . $teacher->id,
            'id' => $teacher->id
        ]);
    }  
    
    public function assignTeacherForm(Schedule $schedule)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $availableTeachers = $this->getTeachersForClass($schedule->class_id);  // GV khả dụng cho lớp

        return view('admin.schedules.assign-teacher', compact('schedule', 'availableTeachers'));
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
    
        $pdf = Pdf::loadView('schedules.pdf', compact('scheduleByDay', 'title', 'className'));  // Xóa 'period'
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

        $pdf = Pdf::loadView('schedules.teacher-pdf', compact('scheduleByDay', 'title'));
        return $pdf->download("lich-day-{$user->name}.pdf");
    }
}