<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'subject_id' => [
                'required',
                'string',
                'max:20',
                'unique:subjects,subject_id',
                'regex:/^[A-Za-z0-9\-_]+$/',
            ],
            'number_of_periods' => 'required|integer|min:1|max:5',
        ];

        $messages = [
            'subject_id.required' => 'Mã môn học là bắt buộc.',
            'subject_id.unique'   => 'Mã môn học này đã tồn tại.',
            'subject_id.max'      => 'Mã môn học không được quá 20 ký tự.',
            'subject_id.regex'    => 'Mã môn học không được chứa khoảng trắng và chỉ được chứa chữ, số, gạch ngang hoặc gạch dưới.',
            'name.required'       => 'Tên môn học là bắt buộc.',
            'number_of_periods.required' => 'Số tiết là bắt buộc.',
            // ... các thông báo khác nếu cần
        ];

        $validated = $request->validate($rules, $messages);

        Subject::create($validated);

        return redirect()->route('subjects.index')->with('success', 'Thêm môn học thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = Subject::findOrFail($id);
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subject = Subject::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'subject_id' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Za-z0-9\-_]+$/', // không chứa khoảng trắng
                'unique:subjects,subject_id,' . $subject->id, // bỏ qua id hiện tại
            ],
            'number_of_periods' => 'required|integer|min:1|max:5',
        ];

        $messages = [
            'subject_id.required' => 'Mã môn học là bắt buộc.',
            'subject_id.unique'   => 'Mã môn học này đã tồn tại.',
            'subject_id.regex'    => 'Mã môn học không được chứa khoảng trắng và chỉ được chứa chữ, số, gạch ngang hoặc gạch dưới.',
            'name.required'       => 'Tên môn học là bắt buộc.',
            'number_of_periods.required' => 'Số tiết là bắt buộc.',
        ];

        $validated = $request->validate($rules, $messages);

        $subject->update($validated);

        return redirect()->route('subjects.index')->with('success', 'Cập nhật môn học thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        
        if($subject->teachers()->exists() || $subject->schedules()->exists() || $subject->teacher_assignments()->exists()){
            return redirect()->back()->with('error', 'Không thể xóa vì môn học đang được tham chiếu bởi dữ liệu khác!');
        }
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Xóa môn học thành công!');
    }
}
