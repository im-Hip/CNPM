<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\TeacherAssignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AssignmentController extends Controller
{
    public function create()
    {
        return view('assignments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'due_date' => ['required', 'date', 'after_or_equal:today, before:2031-01-01'],
        ]);

        $teacherId = Auth::user()->teacher->id ?? null;

        if (!$teacherId) {
            return redirect()->back()->withErrors(['Không xác định được giáo viên.']);
        }

        $teacherAssignment = TeacherAssignment::where('teacher_id', $teacherId)
            ->where('class_id', $request->class_id)
            ->first();

        if (!$teacherAssignment) {
            return redirect()->back()->withErrors(['Không tìm thấy phân công giảng dạy phù hợp.']);
        }

        Assignment::create([
            'teacherassignment_id' => $teacherAssignment->id,
            'title' => $request->title,
            'content' => $request->content,
            'due_date' => $request->due_date,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Assignment created successfully.');
    }

    public function index()
    {
        $user = Auth::user();

        // Nếu là học sinh
        if ($user->role === 'student') {
            $studentClassId = $user->student->class_id ?? null;
            $studentId = $user->id;

            if (!$studentClassId) {
                $assignments = collect();
            } else {
                $assignments = Assignment::with([
                    'teacherAssignment.teacher.user',
                    'teacherAssignment.subject',
                ])
                    ->whereHas('teacherAssignment', function ($query) use ($studentClassId) {
                        $query->where('class_id', $studentClassId);
                    })
                    ->get();
            }

            // Đánh dấu bài nào đã nộp
            foreach ($assignments as $assignment) {
                $assignment->submitted = Submission::where('assignment_id', $assignment->id)
                    ->where('student_id', $studentId)
                    ->exists();
            }

            return view('assignments.index', compact('assignments'));
        }

        // Nếu là giáo viên
        elseif ($user->role === 'teacher') {
            $teacherId = $user->teacher->id;

            $assignments = Assignment::with([
                'teacherAssignment.subject',
                'teacherAssignment.class',
            ])
                ->whereHas('teacherAssignment', function ($query) use ($teacherId) {
                    $query->where('teacher_id', $teacherId);
                })
                ->get();

            // Trả về view riêng cho giáo viên
            return view('assignments.index', compact('assignments'));
        }

        // Nếu không thuộc loại nào
        else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    }

    public function uploadFile(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);

        if (Carbon::parse($assignment->due_date)->isPast()) {
        return back()->with('error', 'Bài tập này đã hết hạn nộp!');
    }

        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,zip,png,jpg,jpeg|max:10240', // Giới hạn 10MB
        ]);

        // Lưu file vào storage/app/public/submissions/
        $path = $request->file('file')->store('submissions', 'public');

        Submission::create([
            'assignment_id' => $id,
            'student_id' => Auth::id(),
            'file_path' => $path,
        ]);

        return back()->with('success', 'Nộp bài thành công!');
    }

    public function show($id)
    {
        $assignment = Assignment::with([
            'teacherAssignment.subject',
            'teacherAssignment.class',
            'submissions.student.user'
        ])->findOrFail($id);

        return view('assignments.show', compact('assignment'));
    }
}
