@extends('layouts.app')

@section('title', $title ?? 'Quản lý lịch học')

@section('content')
    <style>
        .schedule-header {
            margin-bottom: 1.5rem;
        }

        .schedule-title {
            color: #1e3a8a;
            font-size: 2rem;
            font-weight: bold;
            margin: 0 0 1rem 0;
        }

        .schedule-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        @media (max-width: 640px) {
            .schedule-title {
                font-size: 1.5rem;
                margin-bottom: 0.75rem;
            }
            
            .schedule-actions {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .schedule-actions a {
                width: 100%;
                text-align: center;
            }
        }

        .btn-primary {
            background-color: #2563eb;
            color: white;
            font-weight: bold;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            display: inline-block;
            white-space: nowrap;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        .btn-success {
            background-color: #16a34a;
            color: white;
            font-weight: bold;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            display: inline-block;
            white-space: nowrap;
            transition: background-color 0.3s;
        }

        .btn-success:hover {
            background-color: #15803d;
        }
    </style>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <div class="schedule-header">
            <h1 class="schedule-title">
                Quản lý lịch học
            </h1>
            
            <div class="schedule-actions">
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('schedules.create') }}" class="btn-primary">
                        Thêm lịch học
                    </a>
                @endif
                
                @php
                    $exportRoute = '#';
                    $exportText = 'Xuất PDF lịch học';
                    
                    if (auth()->user()->role === 'teacher') {
                        $exportRoute = route('schedules.teacher.export.pdf');
                        $exportText = 'Xuất PDF lịch dạy';
                    } elseif (isset($classId)) {
                        $exportRoute = route('schedules.export.pdf', $classId);
                    } else {
                        $exportRoute = route('schedules.export.pdf', 0);
                    }
                @endphp
                
                <a href="{{ $exportRoute }}" class="btn-success">
                    {{ $exportText }}
                </a>
            </div>
        </div>

        @if (isset($classes) && auth()->user()->role === 'admin')
            <form method="GET" class="mb-6 bg-gray-50 p-4 rounded-lg">
                <div class="flex flex-wrap gap-2 items-center">
                    <select name="class_id" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                        <option value="">Chọn lớp</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ (isset($classId) && $classId == $class->id) ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        @endif

        <div class="overflow-x-auto" style="border: 1px solid #d1d5db;">
            <table class="min-w-full" style="border-collapse: collapse;">
                <thead style="background-color: #f9fafb;">
                    <tr>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: bold; color: #111827; text-transform: uppercase; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db;">Tiết học</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: bold; color: #111827; text-transform: uppercase; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db;">Thứ 2</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: bold; color: #111827; text-transform: uppercase; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db;">Thứ 3</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: bold; color: #111827; text-transform: uppercase; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db;">Thứ 4</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: bold; color: #111827; text-transform: uppercase; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db;">Thứ 5</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: bold; color: #111827; text-transform: uppercase; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db;">Thứ 6</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: bold; color: #111827; text-transform: uppercase; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db;">Thứ 7</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: bold; color: #111827; text-transform: uppercase; border-bottom: 1px solid #d1d5db;">Chủ Nhật</th>
                    </tr>
                </thead>
                <tbody style="background-color: white;">
                    {{-- SÁNG --}}
                    <tr style="background-color: #dbeafe;">
                        <td colspan="8" style="padding: 0.5rem 0.75rem; font-size: 0.875rem; font-weight: bold; color: #111827; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db;">SÁNG</td>
                    </tr>
                    @for ($period = 1; $period <= 5; $period++)
                        <tr class="hover:bg-gray-50">
                            <td style="padding: 0.75rem; font-size: 0.875rem; font-weight: 600; color: #374151; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db;">Tiết {{ $period }}</td>
                            @for ($day = 1; $day <= 7; $day++)
                                <td style="padding: 0.75rem; position: relative; border-right: {{ $day < 7 ? '1px solid #d1d5db' : 'none' }}; border-bottom: 1px solid #d1d5db;" data-day="{{ $day }}" data-period="{{ $period }}">
                                    @php $schedule = $scheduleByDay->get($day)?->get($period); @endphp
                                    @if ($schedule)
                                        <div class="relative group" style="padding: 0.5rem; border-left: 4px solid #60a5fa; background-color: #eff6ff; border-radius: 0.25rem;">
                                            <strong style="color: #1e40af; font-size: 0.875rem;">{{ $schedule->subject->name ?? 'Môn học' }}@if (auth()->user()->role === 'teacher') - Lớp {{ $schedule->class->name ?? 'N/A' }}@endif</strong>
                                            @if ($schedule->teacher)
                                                <br><small style="color: #3b82f6; font-size: 0.75rem;">GV: {{ $schedule->teacher->user->name ?? 'N/A' }}</small>
                                            @endif
                                            @if ($schedule->room)
                                                <br><small style="color: #3b82f6; font-size: 0.75rem;">Phòng: {{ $schedule->room->name ?? 'N/A' }}</small>
                                            @endif
                                            @if ($schedule->note)
                                                <br><small style="color: #6b7280; font-size: 0.75rem;">Ghi chú: {{ $schedule->note }}</small>
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
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endfor

                    {{-- CHIỀU --}}
                    <tr style="background-color: #fce7f3;">
                        <td colspan="8" style="padding: 0.5rem 0.75rem; font-size: 0.875rem; font-weight: bold; color: #111827; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db;">CHIỀU</td>
                    </tr>
                    @for ($period = 6; $period <= 10; $period++)
                        <tr class="hover:bg-gray-50">
                            <td style="padding: 0.75rem; font-size: 0.875rem; font-weight: 600; color: #374151; border-right: 1px solid #d1d5db; {{ $period < 10 ? 'border-bottom: 1px solid #d1d5db;' : '' }}">Tiết {{ $period }}</td>
                            @for ($day = 1; $day <= 7; $day++)
                                <td style="padding: 0.75rem; position: relative; border-right: {{ $day < 7 ? '1px solid #d1d5db' : 'none' }}; {{ $period < 10 ? 'border-bottom: 1px solid #d1d5db;' : '' }}" data-day="{{ $day }}" data-period="{{ $period }}">
                                    @php $schedule = $scheduleByDay->get($day)?->get($period); @endphp
                                    @if ($schedule)
                                        <div class="relative group" style="padding: 0.5rem; border-left: 4px solid #f9a8d4; background-color: #fdf2f8; border-radius: 0.25rem;">
                                            <strong style="color: #be185d; font-size: 0.875rem;">{{ $schedule->subject->name ?? 'Môn học' }}@if (auth()->user()->role === 'teacher') - Lớp {{ $schedule->class->name ?? 'N/A' }}@endif</strong>
                                            @if ($schedule->teacher)
                                                <br><small style="color: #ec4899; font-size: 0.75rem;">GV: {{ $schedule->teacher->user->name ?? 'N/A' }}</small>
                                            @endif
                                            @if ($schedule->room)
                                                <br><small style="color: #ec4899; font-size: 0.75rem;">Phòng: {{ $schedule->room->name ?? 'N/A' }}</small>
                                            @endif
                                            @if ($schedule->note)
                                                <br><small style="color: #6b7280; font-size: 0.75rem;">Ghi chú: {{ $schedule->note }}</small>
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
            <div class="mt-6 text-center text-gray-500 p-6 bg-gray-50 rounded-lg">
                <p class="text-lg">Chưa có lịch học/dạy.</p>
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('schedules.create') }}" class="text-blue-600 hover:text-blue-800 underline font-medium">Thêm lịch đầu tiên</a>
                @endif
            </div>
        @endif
    </div>
@endsection