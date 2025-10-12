<!DOCTYPE html>
<html>

<head>
    <title>Chi tiết bài tập</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container mx-auto p-4">

        {{-- Thông tin bài tập --}}
        <div class="bg-white p-4 rounded shadow mb-6">
            <h1 class="text-2xl font-bold mb-2">{{ $assignment->title }}</h1>
            <p class="mb-1"><strong>Môn học:</strong> {{ $assignment->teacherAssignment->subject->name ?? 'Không rõ' }}</p>
            <p class="mb-1"><strong>Lớp:</strong> {{ $assignment->teacherAssignment->class->name ?? 'Không rõ' }}</p>
            <p class="mb-1"><strong>Hạn nộp:</strong> {{ $assignment->due_date }}</p>
            <p class="mt-2"><strong>Nội dung:</strong> {{ $assignment->content }}</p>
            <p class="mt-2"><strong>Số lượng học sinh đã nộp bài:</strong> {{ $submittedStudents }} / {{ $totalStudents }}</p>
        </div>

        {{-- Danh sách học sinh nộp bài --}}
        <h2 class="text-xl font-semibold mb-2">Danh sách học sinh đã nộp</h2>

        @if($assignment->submissions->isEmpty())
            <p class="text-gray-600">Chưa có học sinh nào nộp bài.</p>
        @else
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Tên học sinh</th>
                        <th class="border p-2">Ngày nộp</th>
                        <th class="border p-2">File bài làm</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($latestSubmissions as $submission)
                        <tr>
                            <td class="border p-2">{{ $submission->student->user->name ?? 'Không rõ' }}</td>
                            <td class="border p-2">{{ $submission->submitted_at }}</td>
                            <td class="border p-2 text-center">
                                @if($submission->file_path)
                                    <a href="{{ asset('storage/' . $submission->file_path) }}" 
                                       target="_blank"
                                       class="text-blue-600 hover:underline">
                                        Xem file
                                    </a>
                                @else
                                    <span class="text-gray-500">Không có file</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        
        {{-- Nút quay lại --}}
        <div class="mb-4">
            <a href="{{ route('assignments.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">
                Quay lại
            </a>
        </div>
    </div>
</body>
</html>
