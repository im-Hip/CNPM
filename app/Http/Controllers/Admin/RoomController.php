<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Classes;

class RoomController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:10|unique:rooms,name',
            'capacity' => 'required|integer|min:10|max:500',
        ]);
    }

    public function getBySubject($subjectId, $classId){
        $subject = Subject::findOrFail($subjectId);
        $class = Classes::findOrFail($classId);

        $rooms = [];

        if($subject->name === 'IT'){
            $rooms = Room::where('type', 'computer')->get();
        }
        elseif(in_array($subject->name, ['physics', 'chemistry', 'biology'])) {
            $rooms = Room::where('type', 'lab')
                        ->orWhere('id', $class->room_id)
                        ->get();
        }
        else{
            $rooms = Room::where('id', $classId)->get();
        }

        return response()->json($rooms);
    }
}
