<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherAssignment;
use App\Models\Teacher;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TeacherAssignmentController extends Controller
{
    /**
     * Display a listing of assignments (danh sách phân công).
     */
    public function index()
    {
        $classes = Classes::all(['id', 'name']);
        $assignments = TeacherAssignment::with(['teacher.user', 'class', 'subject'])
            ->where('status', 'active')
            ->when(request('class_id'), function ($query) {
                return $query->where('class_id', request('class_id'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('teacher_assignments.index', compact('assignments', 'classes'));
    }

    /**
     * Show form phân công mới.
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') abort(403);
        // FIX: Bỏ 'user_id' khỏi select (không tồn tại, relationship with('user') load name)
        $teachers = Teacher::with('user', 'subject')->get(['id', 'subject_id']);  // Chỉ id + subject_id
        $classes = Classes::all(['id', 'name']);
        $subjects = Subject::all(['id', 'name']);
        return view('teacher_assignments.create', compact('teachers', 'classes', 'subjects'));
    }

    /**
     * Store phân công mới (unique GV/môn/lớp).
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);
    
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'note' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
    
        // Kiểm tra trùng lặp subject_id và class_id
        $existingAssignment = TeacherAssignment::where('class_id', $validated['class_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('status', 'active')
            ->first();
    
        if ($existingAssignment) {
            $existingTeacherName = $existingAssignment->teacher->user->name ?? 'Unknown';
            return back()->withErrors(['duplicate' => "Đã có giáo viên {$existingTeacherName} được phân công cho môn này ở lớp này!"])->withInput();
        }
    
        // Tạo phân công mới
        $teacherAssignment = TeacherAssignment::create($validated);
    
        // Cập nhật lịch học liên quan nếu cần (cần thêm logic nếu có form lịch)
        try {
            // Giả sử bạn muốn tạo lịch mặc định, cần điều chỉnh nếu có form chi tiết
            Schedule::create([
                'class_id' => $validated['class_id'],
                'subject_id' => $validated['subject_id'],
                'teacher_id' => $validated['teacher_id'],
                'day_of_week' => 1, // Giá trị mặc định, cần điều chỉnh
                'class_period' => 1, // Giá trị mặc định, cần điều chỉnh
            ]);
        
            Log::info('Created new teacher assignment and schedule at ' . now(), [
                'teacher_id' => $validated['teacher_id'],
                'class_id' => $validated['class_id'],
                'subject_id' => $validated['subject_id'],
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating schedule at ' . now(), [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['schedule_create' => 'Lỗi khi tạo lịch học: ' . $e->getMessage()])->withInput();
        }
    
        return redirect()->route('teacher_assignments.index')->with('success', 'Phân công đã được tạo thành công!');
    }

    /**
     * Show form sửa phân công.
     */
    public function edit(TeacherAssignment $teacherAssignment)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $teachers = Teacher::with('user', 'subject')->get(['id', 'subject_id']);  // FIX: Bỏ user_id
        $classes = Classes::all(['id', 'name']);
        $subjects = Subject::all(['id', 'name']);
        return view('teacher_assignments.edit', compact('teacherAssignment', 'teachers', 'classes', 'subjects'));
    }

    /**
     * Update phân công (tiếp tục từ chỗ cắt).
     */
    public function update(Request $request, TeacherAssignment $teacherAssignment)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'note' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        // Kiểm tra trùng lặp subject_id và class_id (trừ bản ghi hiện tại)
        $existingAssignment = TeacherAssignment::where('class_id', $validated['class_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('id', '!=', $teacherAssignment->id)
            ->where('status', 'active') // Chỉ kiểm tra bản ghi active
            ->first();

        if ($existingAssignment) {
            $existingTeacherName = $existingAssignment->teacher->user->name ?? 'Unknown';
            return back()->withErrors(['duplicate' => "Đã có giáo viên {$existingTeacherName} được phân công cho môn này ở lớp này!"])->withInput();
        }

        // Lấy giá trị cũ trước khi update
        $oldSubjectId = $teacherAssignment->subject_id;
        $oldClassId = $teacherAssignment->class_id;

        // Cập nhật trạng thái
        $teacherAssignment->update($validated);

        // Cập nhật lịch học liên quan nếu thay đổi subject_id hoặc class_id
        if ($validated['subject_id'] != $oldSubjectId || $validated['class_id'] != $oldClassId) {
            try {
                $updatedRows = Schedule::where('class_id', $oldClassId)
                    ->where('subject_id', $oldSubjectId)
                    ->update([
                        'class_id' => $validated['class_id'],
                        'subject_id' => $validated['subject_id'],
                        'teacher_id' => $validated['teacher_id']
                    ]);

                Log::info('Updated schedules for class_id and subject_id at ' . now(), [
                    'old_class_id' => $oldClassId,
                    'old_subject_id' => $oldSubjectId,
                    'new_class_id' => $validated['class_id'],
                    'new_subject_id' => $validated['subject_id'],
                    'new_teacher_id' => $validated['teacher_id'],
                    'rows_updated' => $updatedRows
                ]);
            } catch (\Exception $e) {
                Log::error('Error updating schedules at ' . now(), [
                    'old_class_id' => $oldClassId,
                    'old_subject_id' => $oldSubjectId,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->withErrors(['schedule_update' => 'Lỗi khi cập nhật lịch học: ' . $e->getMessage()])->withInput();
            }
        }

        return redirect()->route('teacher_assignments.index')->with('success', 'Phân công đã được cập nhật!');
    }

    /**
     * Delete phân công.
     */
    public function destroy(TeacherAssignment $teacherAssignment)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $teacherAssignment->delete();
        return redirect()->route('teacher_assignments.index')->with('success', 'Phân công đã xóa!');
    }
}