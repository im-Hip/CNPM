<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherAssignment;
use App\Models\Teacher;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class TeacherAssignmentController extends Controller
{
    /**
     * Display a listing of assignments (danh sách phân công).
     */
    public function index()
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $assignments = TeacherAssignment::with(['teacher.user', 'class', 'subject'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('teacher_assignments.index', compact('assignments'));
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
        ], [
            'teacher_id.required' => 'Chọn giáo viên.',
            'class_id.required' => 'Chọn lớp.',
            'subject_id.required' => 'Chọn môn.',
        ]);
    
        // QUY ĐỊNH: Check tồn tại phân công cho môn + lớp (1 GV/môn/lớp)
        $exists = TeacherAssignment::where('class_id', $validated['class_id'])
            ->where('subject_id', $validated['subject_id'])
            ->exists();
        if ($exists) {
            return back()->with('error', 'Lớp này đã có giáo viên dạy môn này rồi! Không thể phân công GV khác.');
        }
    
        TeacherAssignment::create($validated);
    
        return redirect()->route('teacher_assignments.index')->with('success', 'Phân công giáo viên thành công!');
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
        ]);

        // Unique check (bỏ qua chính record này)
        $exists = TeacherAssignment::where('teacher_id', $validated['teacher_id'])
            ->where('class_id', $validated['class_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('id', '!=', $teacherAssignment->id)
            ->exists();
        if ($exists) {
            return back()->with('error', 'Phân công này đã tồn tại!');
        }

        $teacherAssignment->update($validated);

        return redirect()->route('teacher_assignments.index')->with('success', 'Phân công đã cập nhật!');
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