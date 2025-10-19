@extends('layouts.app')

@section('title', 'Chi tiết bài tập')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-6 text-left lg:text-left" 
        style="color: #1e3a8a;">
        Chi tiết bài tập
    </h1>

    {{-- Thông tin bài tập --}}
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl sm:text-2xl font-bold mb-4" style="color: #1e3a8a;">
            {{ $assignment->title }}
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <span class="font-bold text-sm" style="color: #1e3a8a;">MÔN HỌC:</span>
                <p class="text-gray-700">{{ $assignment->teacherAssignment->subject->name ?? 'N/A' }}</p>
            </div>
            <div>
                <span class="font-bold text-sm" style="color: #1e3a8a;">LỚP HỌC:</span>
                <p class="text-gray-700">{{ $assignment->teacherAssignment->class->name ?? 'N/A' }}</p>
            </div>
            <div>
                <span class="font-bold text-sm" style="color: #1e3a8a;">HẠN NỘP:</span>
                <p class="text-gray-700">{{ \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <span class="font-bold text-sm" style="color: #1e3a8a;">TIẾN ĐỘ NỘP BÀI:</span>
                <p class="text-gray-700">
                    <span class="font-semibold">{{ $submittedStudents }} / {{ $totalStudents }}</span> học sinh
                    <span class="text-sm text-gray-500">
                        ({{ $totalStudents > 0 ? round(($submittedStudents / $totalStudents) * 100, 1) : 0 }}%)
                    </span>
                </p>
            </div>
        </div>

        <div class="border-t pt-4">
            <span class="font-bold text-sm" style="color: #1e3a8a;">NỘI DUNG BÀI TẬP:</span>
            <p class="text-gray-700 mt-2 whitespace-pre-line">{{ $assignment->content }}</p>
        </div>
    </div>

    {{-- Danh sách học sinh nộp bài --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b" style="background-color: #f9fafb;">
            <h2 class="text-xl font-bold" style="color: #1e3a8a;">
                Danh sách học sinh đã nộp bài
            </h2>
        </div>

        <!-- Desktop View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr style="background-color: #e5e7eb;">
                        <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                            style="color: #1e3a8a; background-color: #e5e7eb;">
                            TÊN HỌC SINH
                        </th>
                        <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                            style="color: #1e3a8a; background-color: #e5e7eb;">
                            NGÀY NỘP
                        </th>
                        <th class="px-6 py-4 text-center text-sm lg:text-base font-bold tracking-wider"
                            style="color: #1e3a8a; background-color: #e5e7eb;">
                            FILE BÀI LÀM
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($latestSubmissions as $submission)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base font-medium"
                                style="color: #1e3a8a;">
                                {{ $submission->student->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base text-gray-700">
                                {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($submission->file_path)
                                    <a href="{{ asset('storage/' . $submission->file_path) }}" 
                                       target="_blank"
                                       class="px-4 py-2 rounded font-medium text-sm
                                              transition-all duration-200 hover:opacity-90 inline-block"
                                       style="background-color: #2563eb; color: white;">
                                        Xem file
                                    </a>
                                @else
                                    <span class="text-gray-400 italic text-sm">Không có file</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <p class="text-lg">Chưa có học sinh nào nộp bài</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="md:hidden">
            @forelse ($latestSubmissions as $submission)
                <div class="border-b border-gray-200 p-4 hover:bg-gray-50">
                    <div class="space-y-3">
                        <div>
                            <span class="font-bold text-sm" style="color: #1e3a8a;">TÊN HỌC SINH:</span>
                            <p class="font-medium" style="color: #1e3a8a;">
                                {{ $submission->student->user->name ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <span class="font-bold text-sm" style="color: #1e3a8a;">NGÀY NỘP:</span>
                            <p class="text-gray-700">
                                {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <span class="font-bold text-sm" style="color: #1e3a8a;">FILE BÀI LÀM:</span>
                            @if($submission->file_path)
                                <a href="{{ asset('storage/' . $submission->file_path) }}" 
                                   target="_blank"
                                   class="block mt-2 w-full px-4 py-2 rounded text-white font-medium text-sm text-center
                                          transition-all duration-200"
                                   style="background-color: #2563eb;">
                                    Xem file
                                </a>
                            @else
                                <p class="text-gray-400 italic text-sm mt-1">Không có file</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <p class="text-gray-500">Chưa có học sinh nào nộp bài</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Nút quay lại --}}
    <div class="mt-6">
        <a href="{{ route('assignments.index') }}" 
           class="inline-block px-6 py-3 rounded-lg text-white font-semibold
                  duration-200 transform hover:scale-105 text-sm sm:text-base"
           style="background-color: #6b7280;">
            ← Quay lại
        </a>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .container {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
    }

    button:hover, a:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    * {
        transition-property: background-color, border-color, color, fill, stroke;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
</style>
@endsection