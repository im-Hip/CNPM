<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[\p{L}\s\'.-]+$/u', // chỉ cho chữ cái + khoảng trắng + ký tự hợp lệ
            ],
            'phone' => [
                'required',
                'regex:/^(0|\+84)([0-9]{9})$/', // chuẩn số điện thoại VN: 10 số, bắt đầu bằng 0 hoặc +84
                'unique:teachers,phone', // không trùng
            ],
            'subject' => 'required|string|max:50',
            'user_id' => 'required|exists:users,id',
        ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getBySubject($subject_id)
    {
        $teachers = Teacher::with('user')
            ->where('subject_id', $subject_id)
            ->get();
        return response()->json(
            $teachers->map(function ($t) {
                return [
                    'id'   => $t->id,
                    'name' => $t->user->name, // lấy tên từ users
                ];
            })
        );
    }
}
