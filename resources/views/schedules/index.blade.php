<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Lịch Học / Lịch Dạy' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">  <!-- Dán ở đây -->
</head>
<body class="antialiased bg-gray-50">
    <div class="container mx-auto p-4 max-w-7xl">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">{{ $title ?? 'Lịch Học' }}</h1>
        {{-- Nút export --}}
        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'student')
            <a href="{{ route('schedules.export.pdf', $classId) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Xuất PDF Lịch Học</a>
        @endif
        
        @if (auth()->user()->role === 'teacher')
            <a href="{{ route('schedules.teacher.export.pdf') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Xuất PDF Lịch Dạy</a>
        @endif
        
        {{-- Nút thêm lịch mới cho admin --}}
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('schedules.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">+ Thêm Lịch Mới</a>
        @endif

        {{-- Filter lớp (chỉ admin) --}}
        @if (isset($classes) && auth()->user()->role === 'admin')
            <form method="GET" class="mb-4 bg-white p-4 rounded shadow">
                <div class="flex flex-wrap gap-2 items-center">
                    <select name="class_id" class="border rounded p-2" onchange="this.form.submit()">
                        <option value="">Chọn lớp</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        @endif

        {{-- Bảng lịch --}}
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tiết học</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thứ 2</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thứ 3</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thứ 4</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thứ 5</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thứ 6</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thứ 7</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Chủ Nhật</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- SÁNG --}}
                    <tr class="bg-yellow-50">
                        <td class="px-6 py-2 text-sm font-semibold text-gray-700" colspan="8">SÁNG</td>
                    </tr>
                    @for ($period = 1; $period <= 5; $period++)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Tiết {{ $period }}</td>
                            @for ($day = 1; $day <= 7; $day++)
                                <td class="px-6 py-4 relative cell-{{ $day }}-{{ $period }}" data-day="{{ $day }}" data-period="{{ $period }}">
                                    @php $schedule = $scheduleByDay->get($day)?->get($period); @endphp
                                    @if ($schedule)
                                        <div class="schedule-cell bg-{{ $period <= 5 ? 'blue' : 'green' }}-100 p-2 rounded text-sm border-l-4 border-{{ $period <= 5 ? 'blue' : 'green' }}-500 relative group" data-id="{{ $schedule->id }}">
                                            <strong>{{ $schedule->subject->name ?? 'Môn học' }}@if (auth()->user()->role === 'teacher') - Lớp {{ $schedule->class->name ?? 'N/A' }}@endif</strong>
                                            @if ($schedule->teacher)
                                                <br><small class="text-gray-600">GV: {{ $schedule->teacher->user->name ?? 'N/A' }}</small>
                                            @endif
                                            @if ($schedule->room)
                                                <br><small class="text-gray-600">Phòng: {{ $schedule->room->name ?? 'N/A' }}</small>
                                            @endif
                                            @if ($schedule->note)
                                                <br><small class="text-gray-400">Ghi chú: {{ $schedule->note }}</small>
                                            @endif
                                            @if (auth()->user()->role === 'admin')
                                                <div class="absolute top-0 right-0 flex space-x-1 opacity-0 group-hover:opacity-100 transition">
                                                    <a href="{{ route('schedules.edit', $schedule) }}" class="bg-yellow-500 text-white p-1 rounded text-xs hover:bg-yellow-600">Sửa</a>
                                                    <form method="POST" action="{{ route('schedules.destroy', $schedule) }}" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa lịch này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-500 text-white p-1 rounded text-xs hover:bg-red-600">Xóa</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">Trống</span>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endfor

                    {{-- CHIỀU --}}
                    <tr class="bg-orange-50">
                        <td class="px-6 py-2 text-sm font-semibold text-gray-700" colspan="8">CHIỀU</td>
                    </tr>
                    @for ($period = 6; $period <= 10; $period++)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Tiết {{ $period }}</td>
                            @for ($day = 1; $day <= 7; $day++)
                                <td class="px-6 py-4 relative cell-{{ $day }}-{{ $period }}" data-day="{{ $day }}" data-period="{{ $period }}">
                                    @php $schedule = $scheduleByDay->get($day)?->get($period); @endphp
                                    @if ($schedule)
                                        <div class="schedule-cell bg-{{ $period <= 5 ? 'blue' : 'green' }}-100 p-2 rounded text-sm border-l-4 border-{{ $period <= 5 ? 'blue' : 'green' }}-500 relative group" data-id="{{ $schedule->id }}">
                                            <strong>{{ $schedule->subject->name ?? 'Môn học' }}@if (auth()->user()->role === 'teacher') - Lớp {{ $schedule->class->name ?? 'N/A' }}@endif</strong>
                                            @if ($schedule->teacher)
                                                <br><small class="text-gray-600">GV: {{ $schedule->teacher->user->name ?? 'N/A' }}</small>
                                            @endif
                                            @if ($schedule->room)
                                                <br><small class="text-gray-600">Phòng: {{ $schedule->room->name ?? 'N/A' }}</small>
                                            @endif
                                            @if ($schedule->note)
                                                <br><small class="text-gray-400">Ghi chú: {{ $schedule->note }}</small>
                                            @endif
                                            @if (auth()->user()->role === 'admin')
                                                <div class="absolute top-0 right-0 flex space-x-1 opacity-0 group-hover:opacity-100 transition">
                                                    <a href="{{ route('schedules.edit', $schedule) }}" class="bg-yellow-500 text-white p-1 rounded text-xs hover:bg-yellow-600">Sửa</a>
                                                    <form method="POST" action="{{ route('schedules.destroy', $schedule) }}" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa lịch này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-500 text-white p-1 rounded text-xs hover:bg-red-600">Xóa</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">Trống</span>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        {{-- Không có lịch --}}
        @if ($scheduleByDay->flatten()->isEmpty())
            <div class="mt-4 text-center text-gray-500 p-4 bg-white rounded shadow">
                Chưa có lịch học/dạy. 
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('schedules.create') }}" class="text-blue-500 underline">Thêm lịch đầu tiên</a>.
                @endif
            </div>
        @endif
    </div>

</body>
</html>