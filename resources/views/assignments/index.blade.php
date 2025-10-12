<!DOCTYPE html>
<html>

<head>
    <title>Assignments</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container mx-auto p-4">
        {{--View xem bai tap danh cho giao vien--}}
        @if(Auth::user()->role === 'teacher')
        <h1 class="text-2xl mb-4">Danh sách bài tập đã tạo</h1>
        @if ($assignments->isEmpty())
        <p>Hiện bạn chưa tạo bài tập nào.</p>
        @else
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="border p-2">Tiêu đề</th>
                    <th class="border p-2">Nội dung</th>
                    <th class="border p-2">Môn học</th>
                    <th class="border p-2">Lớp học</th>
                    <th class="border p-2">Ngày hết hạn</th>
                    <th class="border p-2">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assignments as $assignment)
                <tr>
                    <td class="border p-2">{{ $assignment->title }}</td>
                    <td class="border p-2">{{ $assignment->content }}</td>
                    <td class="border p-2">{{ $assignment->teacherAssignment->subject->name }}</td>
                    <td class="border p-2">{{ $assignment->teacherAssignment->class->name }}</td>
                    <td class="border p-2">{{ $assignment->due_date }}</td>
                    <td class="border p-2 text-center">
                        <a href="{{ route('assignments.show', $assignment->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                            Xem danh sách nộp bài
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{--View xem bai tap danh cho hoc sinh--}}
        @endif
        @else
        <h1 class="text-2xl mb-4">Danh sách bài tập</h1>
        @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4">{{ session('success') }}</div>
        @endif

        @php
            // Áp dụng lọc trạng thái nếu có
            $filteredAssignments = $assignments->filter(function($assignment) {
                if (request('status') === 'submitted') {
                    return $assignment->submitted;
                } elseif (request('status') === 'not_submitted') {
                    return !$assignment->submitted;
                }
                return true; // Không lọc
            });
        @endphp

        @if ($filteredAssignments->isEmpty())
        <p>Hiện không có bài tập.</p>
        @else
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="border p-2">Tiêu đề</th>
                    <th class="border p-2">Nội dung</th>
                    <th class="border p-2">Giáo viên</th>
                    <th class="border p-2">Môn học</th>
                    <th class="border p-2">Ngày hết hạn</th>
                    <th class="border p-2">Nộp bài</th>
                    <th class="border p-2">
                        <div class="flex items-center justify-between">
                            <span>Trạng thái</span>
                            {{-- Bộ lọc nằm bên phải chữ --}}
                            <form method="GET" action="{{ route('assignments.index') }}">
                                <select name="status" onchange="this.form.submit()" class="border rounded p-1 text-sm ml-2">
                                    <option value="">Tất cả</option>
                                    <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Đã nộp</option>
                                    <option value="not_submitted" {{ request('status') === 'not_submitted' ? 'selected' : '' }}>Chưa nộp</option>
                                </select>
                            </form>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filteredAssignments as $assignment)
                <tr>
                    <td class="border p-2">{{ $assignment->title }}</td>
                    <td class="border p-2">{{ $assignment->content }}</td>
                    <td class="border p-2">{{ $assignment->teacherAssignment->teacher->user->name ?? 'Không rõ' }}</td>
                    <td class="border p-2">{{ $assignment->teacherAssignment->subject->name ?? 'Không rõ' }}</td>
                    <td class="border p-2">{{ $assignment->due_date }}</td>
                    <td class="border p-2">
                        @php
                        $isExpired = \Carbon\Carbon::parse($assignment->due_date)->isPast();
                        @endphp
                        @if ($isExpired)
                        <span class="text-gray-500 italic">Đã hết hạn</span>
                        @else
                        <form action="{{ route('assignments.upload', $assignment->id) }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="flex items-center space-x-2">
                            @csrf
                            <input type="file" name="file" class="text-sm border rounded p-1" required>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">
                                Upload
                            </button>
                        </form>
                        @endif
                    </td>
                    <td>
                        @if($assignment->submitted)
                        <span style="color: green;">Đã nộp</span>
                        @else
                        <span style="color: red;">Chưa nộp</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        @endif
    </div>
</body>

</html>