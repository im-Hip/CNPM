@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- VIEW CHO GIÁO VIÊN --}}
    @if(Auth::user()->role === 'teacher')
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-6 text-center lg:text-center" 
            style="color: #1e3a8a;">
            Danh sách bài tập đã tạo
        </h1>
        
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Desktop View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr style="background-color: #e5e7eb;">
                            <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                                style="color: #1e3a8a; background-color: #e5e7eb;">
                                TIÊU ĐỀ
                            </th>
                            <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                                style="color: #1e3a8a; background-color: #e5e7eb;">
                                NỘI DUNG
                            </th>
                            <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                                style="color: #1e3a8a; background-color: #e5e7eb;">
                                MÔN HỌC
                            </th>
                            <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                                style="color: #1e3a8a; background-color: #e5e7eb;">
                                LỚP HỌC
                            </th>
                            <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                                style="color: #1e3a8a; background-color: #e5e7eb;">
                                NGÀY HẾT HẠN
                            </th>
                            <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                                style="color: #1e3a8a; background-color: #e5e7eb;">
                                THAO TÁC
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($assignments as $assignment)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm lg:text-base font-medium"
                                    style="color: #1e3a8a;">
                                    {{ $assignment->title }}
                                </td>
                                <td class="px-6 py-4 text-sm lg:text-base font-medium"
                                    style="color: #1e3a8a;">
                                    {{ Str::limit($assignment->content, 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base font-medium"
                                    style="color: #1e3a8a;">
                                    {{ $assignment->teacherAssignment->subject->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base font-medium"
                                    style="color: #1e3a8a;">
                                    {{ $assignment->teacherAssignment->class->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base font-medium"
                                    style="color: #1e3a8a;">
                                    {{ \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('assignments.show', $assignment->id) }}" 
                                       class="px-4 py-2 rounded font-medium text-sm
                                              transition-all duration-200 hover:opacity-90"
                                       style="background-color: #2563eb; color: white; min-width: 70px; text-align: center; display: inline-block;">
                                        Xem danh sách nộp bài
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <p class="text-lg mb-2">Bạn chưa tạo bài tập nào</p>
                                        <a href="{{ route('assignments.create') }}" 
                                           class="text-blue-600 hover:text-blue-800 underline font-medium">
                                            Tạo bài tập đầu tiên
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden">
                @forelse ($assignments as $assignment)
                    <div class="border-b border-gray-200 p-4 hover:bg-gray-50">
                        <div class="space-y-3">
                            <div>
                                <span class="font-bold text-sm" style="color: #1e3a8a;">TIÊU ĐỀ:</span>
                                <p class="font-medium" style="color: #1e3a8a;">
                                    {{ $assignment->title }}
                                </p>
                            </div>
                            <div>
                                <span class="font-bold text-sm" style="color: #1e3a8a;">NỘI DUNG:</span>
                                <p class="text-gray-500 text-sm">
                                    {{ $assignment->content }}
                                </p>
                            </div>
                            <div>
                                <span class="font-bold text-sm" style="color: #1e3a8a;">MÔN HỌC:</span>
                                <p class="font-medium" style="color: #1e3a8a;">
                                    {{ $assignment->teacherAssignment->subject->name }}
                                </p>
                            </div>
                            <div>
                                <span class="font-bold text-sm" style="color: #1e3a8a;">LỚP HỌC:</span>
                                <p class="font-medium" style="color: #1e3a8a;">
                                    {{ $assignment->teacherAssignment->class->name }}
                                </p>
                            </div>
                            <div>
                                <span class="font-bold text-sm" style="color: #1e3a8a;">NGÀY HẾT HẠN:</span>
                                <p class="font-medium" style="color: #1e3a8a;">
                                    {{ \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="pt-2">
                                <a href="{{ route('assignments.show', $assignment->id) }}" 
                                   class="w-full px-4 py-2 rounded text-white font-medium text-sm text-center
                                          transition-all duration-200 block"
                                   style="background-color: #2563eb;">
                                    Xem danh sách nộp bài
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <p class="text-gray-500 mb-2">Bạn chưa tạo bài tập nào</p>
                        <a href="{{ route('assignments.create') }}" 
                           class="text-blue-600 hover:text-blue-800 underline font-medium">
                            Tạo bài tập đầu tiên
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

    {{-- VIEW CHO HỌC SINH --}}
    @else
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-6 text-center lg:text-center" 
            style="color: #1e3a8a;">
            Danh sách bài tập
        </h1>
        
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @php
            // Áp dụng lọc trạng thái nếu có
            $filteredAssignments = $assignments->filter(function($assignment) {
                if (request('status') === 'submitted') {
                    return $assignment->submitted;
                } elseif (request('status') === 'not_submitted') {
                    return !$assignment->submitted;
                }
                return true;
            });
        @endphp

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Desktop View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr style="background-color: #e5e7eb;">
                            <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                                style="color: #1e3a8a; background-color: #e5e7eb;">
                                TIÊU ĐỀ
                            </th>
                            <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                                style="color: #1e3a8a; background-color: #e5e7eb;">
                                NỘI DUNG
                            </th>
                            <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                                style="color: #1e3a8a; background-color: #e5e7eb;">
                                GIÁO VIÊN
                            </th>
                            <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                                style="color: #1e3a8a; background-color: #e5e7eb;">
                                MÔN HỌC
                            </th>
                            <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                                style="color: #1e3a8a; background-color: #e5e7eb;">
                                HẾT HẠN
                            </th>
                            <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                                style="color: #1e3a8a; background-color: #e5e7eb;">
                                NỘP BÀI
                            </th>
                            <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                                style="color: #1e3a8a; background-color: #e5e7eb;">
                                <div class="flex items-center justify-between">
                                    <span>TRẠNG THÁI</span>
                                    <form method="GET" action="{{ route('assignments.index') }}">
                                        <select name="status" onchange="this.form.submit()" 
                                                class="border border-gray-300 rounded p-1 text-xs ml-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                style="color: #374151; background-color: white;">
                                            <option value="">Tất cả</option>
                                            <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Đã nộp</option>
                                            <option value="not_submitted" {{ request('status') === 'not_submitted' ? 'selected' : '' }}>Chưa nộp</option>
                                        </select>
                                    </form>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($filteredAssignments as $assignment)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm lg:text-base font-medium"
                                    style="color: #1e3a8a;">
                                    {{ $assignment->title }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ Str::limit($assignment->content, 40) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base font-medium"
                                    style="color: #1e3a8a;">
                                    {{ $assignment->teacherAssignment->teacher->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base font-medium"
                                    style="color: #1e3a8a;">
                                    {{ $assignment->teacherAssignment->subject->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base">
                                    {{ \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $isExpired = \Carbon\Carbon::parse($assignment->due_date)->isPast();
                                    @endphp
                                    @if ($isExpired)
                                        <span class="text-gray-400 italic text-sm">Đã hết hạn</span>
                                    @else
                                        <form action="{{ route('assignments.upload', $assignment->id) }}"
                                              method="POST"
                                              enctype="multipart/form-data"
                                              class="flex items-center space-x-2">
                                            @csrf
                                            <input type="file" name="file" 
                                                   class="text-xs border border-gray-300 rounded p-1 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                   required>
                                            <button type="submit"
                                                    class="px-3 py-1 rounded text-white text-xs font-medium
                                                           transition-all duration-200 hover:opacity-90"
                                                    style="background-color: #2563eb;">
                                                Upload
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($assignment->submitted)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold" 
                                              style="background-color: #d1fae5; color: #065f46;">
                                            ✓ Đã nộp
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold" 
                                              style="background-color: #fee2e2; color: #991b1b;">
                                            ✗ Chưa nộp
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <p class="text-lg">Không có bài tập nào</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile View Students -->
            <div class="md:hidden">
                <!-- Filter Mobile -->
                <div class="p-4 bg-gray-50 border-b">
                    <form method="GET" action="{{ route('assignments.index') }}">
                        <label class="block text-sm font-bold mb-2" style="color: #1e3a8a;">Lọc trạng thái:</label>
                        <select name="status" onchange="this.form.submit()" 
                                class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Tất cả</option>
                            <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Đã nộp</option>
                            <option value="not_submitted" {{ request('status') === 'not_submitted' ? 'selected' : '' }}>Chưa nộp</option>
                        </select>
                    </form>
                </div>

                @forelse ($filteredAssignments as $assignment)
                    <div class="border-b border-gray-200 p-4 hover:bg-gray-50">
                        <div class="space-y-3">
                            <div>
                                <span class="font-bold text-sm" style="color: #1e3a8a;">TIÊU ĐỀ:</span>
                                <p class="font-medium" style="color: #1e3a8a;">
                                    {{ $assignment->title }}
                                </p>
                            </div>
                            <div>
                                <span class="font-bold text-sm" style="color: #1e3a8a;">NỘI DUNG:</span>
                                <p class="text-gray-500 text-sm">
                                    {{ $assignment->content }}
                                </p>
                            </div>
                            <div>
                                <span class="font-bold text-sm" style="color: #1e3a8a;">GIÁO VIÊN:</span>
                                <p class="font-medium" style="color: #1e3a8a;">
                                    {{ $assignment->teacherAssignment->teacher->user->name ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <span class="font-bold text-sm" style="color: #1e3a8a;">MÔN HỌC:</span>
                                <p class="font-medium" style="color: #1e3a8a;">
                                    {{ $assignment->teacherAssignment->subject->name ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <span class="font-bold text-sm" style="color: #1e3a8a;">HẾT HẠN:</span>
                                <p class="font-medium" style="color: #1e3a8a;">
                                    {{ \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div>
                                <span class="font-bold text-sm" style="color: #1e3a8a;">TRẠNG THÁI:</span>
                                @if($assignment->submitted)
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold mt-1" 
                                          style="background-color: #d1fae5; color: #065f46;">
                                        ✓ Đã nộp
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold mt-1" 
                                          style="background-color: #fee2e2; color: #991b1b;">
                                        ✗ Chưa nộp
                                    </span>
                                @endif
                            </div>
                            @php
                                $isExpired = \Carbon\Carbon::parse($assignment->due_date)->isPast();
                            @endphp
                            @if (!$isExpired)
                                <div class="pt-2">
                                    <span class="font-bold text-sm block mb-2" style="color: #1e3a8a;">NỘP BÀI:</span>
                                    <form action="{{ route('assignments.upload', $assignment->id) }}"
                                          method="POST"
                                          enctype="multipart/form-data"
                                          class="space-y-2">
                                        @csrf
                                        <input type="file" name="file" 
                                               class="w-full text-sm border border-gray-300 rounded p-2" 
                                               required>
                                        <button type="submit"
                                                class="w-full px-4 py-2 rounded text-white font-medium text-sm
                                                       transition-all duration-200"
                                                style="background-color: #2563eb;">
                                            Upload bài làm
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="pt-2">
                                    <span class="text-gray-400 italic text-sm">Đã hết hạn nộp bài</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <p class="text-gray-500">Không có bài tập nào</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif
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

    input[type="file"]::-webkit-file-upload-button {
        background-color: #e5e7eb;
        border: none;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        cursor: pointer;
        font-size: 0.75rem;
    }

    input[type="file"]::-webkit-file-upload-button:hover {
        background-color: #d1d5db;
    }
</style>
@endsection