<!DOCTYPE html>
<html>

<head>
    <title>Create Assignment</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl mb-4">Tạo bài tập</h1>
        @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif
        <form action="{{ route('assignments.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Nội dung</label>
                <textarea name="content" id="content" class="mt-1 block w-full border-gray-300 rounded-md" required></textarea>
            </div>
            <div class="mb-4">
                <label for="due_date" class="block text-sm font-medium text-gray-700">Ngày hết hạn</label>
                <input
                    type="datetime-local"
                    name="due_date"
                    id="due_date"
                    class="mt-1 block w-full border-gray-300 rounded-md"
                    min="2025-01-01T00:00"
                    max="2030-12-31T23:59"
                    required
                    min="{{ now()->toDateString() }}" {{-- ngày hiện tại --}}>
            </div>
            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'teacher')
            <label for="class_id" class="block text-sm font-medium text-gray-700">Lớp</label>
            <select name="class_id" id="class_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                @if (Auth::user()->role === 'teacher' && optional(Auth::user()->teacher->teacherAssignments)->isNotEmpty())
                @foreach (Auth::user()->teacher->teacherAssignments as $teacherAssignment)
                <option value="{{ $teacherAssignment->class_id }}">{{ $teacherAssignment->class->name }}</option>
                @endforeach
                @elseif (Auth::user()->role === 'teacher')
                <option disabled>Chưa có lớp nào được phân công</option>
                @else
                @foreach (\App\Models\Classes::all() as $class)
                <option value="{{ $class->id }}">Class {{ $class->name }}</option>
                @endforeach
                @endif
            </select>
    </div>
    @endif
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tạo bài tập</button>
    <a href="{{ route('assignments.index') }}"
        class="bg-green-500 text-white px-4 py-2 rounded">
        Xem bài tập đã tạo
    </a>
    </form>
    </div>
</body>

</html>