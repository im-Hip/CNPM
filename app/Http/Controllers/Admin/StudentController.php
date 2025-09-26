<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'age' => 'required|integer|min:6|max:100',
            'day_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            'user_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
        ]);
    }
}
