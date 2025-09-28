<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:10|unique:rooms,name',
            'capacity' => 'required|integer|min:10|max:500',
        ]);
    }
}
