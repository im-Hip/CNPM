<!DOCTYPE html>
  <html>
  <head>
      <title>Assignments</title>
      @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body>
      <div class="container mx-auto p-4">
          <h1 class="text-2xl mb-4">Assignments</h1>
          @if (session('success'))
              <div class="bg-green-100 text-green-700 p-2 mb-4">{{ session('success') }}</div>
          @endif
          @if ($assignments->isEmpty())
              <p>No assignments available.</p>
          @else
              <table class="min-w-full bg-white border">
                  <thead>
                      <tr>
                          <th class="border p-2">Title</th>
                          <th class="border p-2">Content</th>
                          <th class="border p-2">Due Date</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($assignments as $assignment)
                          <tr>
                              <td class="border p-2">{{ $assignment->title }}</td>
                              <td class="border p-2">{{ $assignment->content }}</td>
                              <td class="border p-2">{{ $assignment->due_date }}</td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          @endif
      </div>
  </body>
  </html>