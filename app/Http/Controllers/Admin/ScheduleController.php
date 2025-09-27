<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Room;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::with('teacher.subject')->get();
        $start_periods = [
            1 => '07h00',
            2 => '07h50',
            3 => '08h50',
            4 => '09h40',
            5 => '10h30',
            6 => '13h00',
            7 => '13h50',
            8 => '14h50',
            9 => '15h40',
            10 => '16h30',
        ];

        $end_periods = [
            1 => '07h45',
            2 => '08h35',
            3 => '09h35',
            4 => '10h25',
            5 => '11h15',
            6 => '13h45',
            7 => '14h35',
            8 => '15h35',
            9 => '16h25',
            10 => '17h15',
        ];
        return view('admin.schedules.index', compact('schedules', 'start_periods', 'end_periods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classes::all();
        $subjects = Subject::all();
        $rooms = Room::all();
        
        return view('admin.schedules.create', compact('classes', 'subjects', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'teacher' => 'required',
            'date' => 'required|date|before:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        Schedule::create($request->all());

        return redirect()->route('schedules.index')->with('success', 'The class schedule has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        return view('admin.schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'subject' => 'required',
            'teacher' => 'required',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $schedule->update($request->all());

        return redirect()->route('schedules.next')->with('success', 'The schedule has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'The class schedule has been cleared.');
    }
}
