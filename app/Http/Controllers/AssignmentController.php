<?php

  namespace App\Http\Controllers;

  use App\Models\Assignment;
  use Illuminate\Http\Request;

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
              'due_date' => 'required|date',
              'class_id' => 'required|exists:classes,id',
          ]);

          Assignment::create([
              'title' => $request->title,
              'content' => $request->content,
              'due_date' => $request->due_date,
              'class_id' => $request->class_id,
              'created_at' => now(),
              'updated_at' => now(),
          ]);

          return redirect()->back()->with('success', 'Assignment created successfully.');
      }

      public function index()
      {
          $assignments = Assignment::where('class_id', Auth::user()->student->class_id ?? null)->get();
          return view('assignments.index', compact('assignments'));
      }
  }