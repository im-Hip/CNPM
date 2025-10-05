<!DOCTYPE html>
  <html>
  <head>
      <title>Create Assignment</title>
      @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body>
      <div class="container mx-auto p-4">
          <h1 class="text-2xl mb-4">Create Assignment</h1>
          @if (session('success'))
              <div class="bg-green-100 text-green-700 p-2 mb-4">{{ session('success') }}</div>
          @endif
          <form action="{{ route('assignments.store') }}" method="POST">
              @csrf
              <div class="mb-4">
                  <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                  <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md" required>
              </div>
              <div class="mb-4">
                  <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                  <textarea name="content" id="content" class="mt-1 block w-full border-gray-300 rounded-md" required></textarea>
              </div>
              <div class="mb-4">
                  <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                  <input type="date" name="due_date" id="due_date" class="mt-1 block w-full border-gray-300 rounded-md" required>
              </div>
              @if (Auth::user()->role === 'admin' || Auth::user()->role === 'teacher')
                  <div class="mb-4">
                      <label for="class_id" class="block text-sm font-medium text-gray-700">Class</label>
                      <select name="class_id" id="class_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                          @if (Auth::user()->role === 'teacher')
                              @foreach (Auth::user()->teacher->teacherAssignments as $assignment)
                                  <option value="{{ $assignment->class_id }}">Class {{ $assignment->class->name }}</option>
                              @endforeach
                          @else
                              @foreach (\App\Models\Classes::all() as $class)
                                  <option value="{{ $class->id }}">Class {{ $class->name }}</option>
                              @endforeach
                          @endif
                      </select>
                  </div>
              @endif
              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Assignment</button>
          </form>
  </div>
  </body>
  </html>