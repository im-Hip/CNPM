<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:100|unique:classes,name',
            'number_of_students' => 'required|integer|min:1|max:50',
            'room_id'            => 'required|exists:rooms,id',
            'teacher_id'         => 'required|exists:teachers,id',
        ]);
    }
}
