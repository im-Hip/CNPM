@extends('layouts.app')

@section('title', $title ?? 'Quản lý lịch học')

@section('content')
    <style>
        .schedule-header {
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
    
        .schedule-title {
            color: #1e3a8a;
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
        }
    
        .schedule-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }
    
        .schedule-table {
            border: 1px solid #d1d5db;
            width: 100%;
            overflow-x: auto;
            display: block;
        }
    
        .schedule-table table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
    
        .schedule-table th,
        .schedule-table td {
            padding: 0.75rem;
            text-align: left;
            border-right: 1px solid #d1d5db;
            border-bottom: 1px solid #d1d5db;
        }
    
        /* Cột đầu tiên (Tiết học) hẹp hơn */
        .schedule-table th:first-child,
        .schedule-table td:first-child {
            width: 8%;
            min-width: 80px;
        }
    
        /* 7 cột còn lại chia đều */
        .schedule-table th:not(:first-child),
        .schedule-table td:not(:first-child) {
            width: 13.14%;
        }
    
        /* Loại bỏ border-right ở cột cuối */
        .schedule-table th:last-child,
        .schedule-table td:last-child {
            border-right: none;
        }
    
        .schedule-table th {
            background-color: #f9fafb;
            font-size: 0.875rem;
            font-weight: bold;
            color: #111827;
            text-transform: uppercase;
        }
    
        .schedule-table td {
            font-size: 0.875rem;
            color: #374151;
            position: relative;
        }
    
        .schedule-table tr:hover {
            background-color: #f3f4f6;
        }
    
        .schedule-item {
            padding: 0.5rem;
            border-left: 4px solid #60a5fa;
            background-color: #eff6ff;
            border-radius: 0.25rem;
        }
    
        .schedule-item.chieu {
            border-left-color: #f9a8d4;
            background-color: #fdf2f8;
        }
    
        .schedule-item strong {
            color: #1e40af;
            font-size: 0.875rem;
        }
    
        .schedule-item.chieu strong {
            color: #be185d;
        }
    
        .schedule-item small {
            color: #3b82f6;
            font-size: 0.75rem;
        }
    
        .schedule-item.chieu small {
            color: #ec4899;
        }
    
        .schedule-item .note {
            color: #6b7280;
            font-size: 0.75rem;
        }
    
        .schedule-actions .btn-primary {
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
    
        .schedule-actions .btn-primary:hover {
            background-color: #1d4ed8;
        }
    
        .schedule-actions .btn-success {
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
    
        .schedule-actions .btn-success:hover {
            background-color: #15803d;
        }
    
        .custom-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: 90%;
            max-width: 400px;
            text-align: center;
        }
    
        .custom-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    
        .custom-popup.active,
        .custom-overlay.active {
            display: block;
        }
    
        .custom-popup .close-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            border: none;
            background: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
        }
    
        .custom-popup .close-btn:hover {
            color: #5244efff;
        }
    
        @media (max-width: 768px) {
            .schedule-table {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .schedule-table table {
                min-width: 800px;
            }
        }
    
        @media (max-width: 640px) {
            .schedule-title {
                font-size: 1.5rem;
            }
            .schedule-actions {
                flex-direction: column;
                align-items: flex-start;
            }
            .schedule-actions a {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <div class="schedule-header">
            <h1 class="schedule-title">{{ $title ?? 'Quản lý lịch học' }}</h1>
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
                <a href="{{ $exportRoute }}" class="btn-success">{{ $exportText }}</a>
            </div>
        </div>

        @if (isset($classes) && auth()->user()->role === 'admin')
            <form method="GET" class="mb-6 bg-gray-50 p-4 rounded-lg">
                <div class="flex flex-wrap gap-2 items-center">
                    <select name="class_id" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                        <option value="">Chọn lớp</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ (isset($classId) && $classId == $class->id) ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        @endif

        <div class="schedule-table">
            <table>
                <thead>
                    <tr>
                        <th>Tiết học</th>
                        <th>Thứ 2</th>
                        <th>Thứ 3</th>
                        <th>Thứ 4</th>
                        <th>Thứ 5</th>
                        <th>Thứ 6</th>
                        <th>Thứ 7</th>
                        <th>Chủ Nhật</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- SÁNG -->
                    <tr style="background-color: #dbeafe;">
                        <td colspan="8" style="padding: 0.5rem 0.75rem; font-size: 0.875rem; font-weight: bold; color: #111827;">SÁNG</td>
                    </tr>
                    @for ($period = 1; $period <= 5; $period++)
                        <tr>
                            <td style="font-size: 0.875rem; font-weight: 600; color: #374151;">Tiết {{ $period }}</td>
                            @for ($day = 1; $day <= 7; $day++)
                                <td style="position: relative; border-right: {{ $day < 7 ? '1px solid #d1d5db' : 'none' }};" data-day="{{ $day }}" data-period="{{ $period }}">
                                    @php
                                        $schedule = $scheduleByDay->get($day)?->get($period);
                                        $scheduleId = $schedule?->id ?? null;
                                    @endphp
                                    @if ($scheduleId)
                                        <div class="schedule-item group" style="border-left: 4px solid #60a5fa; background-color: #eff6ff;">
                                            <strong>{{ $schedule->subject->name ?? 'Môn học' }}@if (auth()->user()->role === 'teacher') - Lớp {{ $schedule->class->name ?? 'N/A' }}@endif</strong>
                                            @if ($schedule->teacher)
                                                <br><small>GV: {{ $schedule->teacher->user->name ?? 'N/A' }}</small>
                                            @endif
                                            @if ($schedule->room)
                                                <br><small>Phòng: {{ $schedule->room->name ?? 'N/A' }}</small>
                                            @endif
                                            @if ($schedule->note)
                                                <br><small class="note">Ghi chú: {{ $schedule->note }}</small>
                                            @endif
                                            @if (auth()->user()->role === 'admin')
                                                <div class="absolute top-0 right-0 flex space-x-1 opacity-0 group-hover:opacity-100 transition duration-300">
                                                    <a href="{{ route('schedules.edit', $scheduleId) }}" class="bg-yellow-500 text-white p-1 rounded text-xs hover:bg-yellow-600 transition">
                                                        Sửa
                                                    </a>
                                                    <button class="bg-red-500 text-white p-1 rounded text-xs hover:bg-red-600 transition delete-btn"
                                                            onclick="showDeletePopup('schedule_{{ $scheduleId }}', 'lịch học ID {{ $scheduleId }}', '{{ route('schedules.destroy', $scheduleId) }}')">
                                                        Xóa
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div style="padding: 0.5rem;"></div>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endfor

                    <!-- CHIỀU -->
                    <tr style="background-color: #fce7f3;">
                        <td colspan="8" style="padding: 0.5rem 0.75rem; font-size: 0.875rem; font-weight: bold; color: #111827;">CHIỀU</td>
                    </tr>
                    @for ($period = 6; $period <= 10; $period++)
                        <tr>
                            <td style="font-size: 0.875rem; font-weight: 600; color: #374151;">Tiết {{ $period }}</td>
                            @for ($day = 1; $day <= 7; $day++)
                                <td style="position: relative; border-right: {{ $day < 7 ? '1px solid #d1d5db' : 'none' }};" data-day="{{ $day }}" data-period="{{ $period }}">
                                    @php
                                        $schedule = $scheduleByDay->get($day)?->get($period);
                                        $scheduleId = $schedule?->id ?? null;
                                    @endphp
                                    @if ($scheduleId)
                                        <div class="schedule-item chieu group" style="border-left: 4px solid #f9a8d4; background-color: #fdf2f8;">
                                            <strong>{{ $schedule->subject->name ?? 'Môn học' }}@if (auth()->user()->role === 'teacher') - Lớp {{ $schedule->class->name ?? 'N/A' }}@endif</strong>
                                            @if ($schedule->teacher)
                                                <br><small>GV: {{ $schedule->teacher->user->name ?? 'N/A' }}</small>
                                            @endif
                                            @if ($schedule->room)
                                                <br><small>Phòng: {{ $schedule->room->name ?? 'N/A' }}</small>
                                            @endif
                                            @if ($schedule->note)
                                                <br><small class="note">Ghi chú: {{ $schedule->note }}</small>
                                            @endif
                                            @if (auth()->user()->role === 'admin')
                                                <div class="absolute top-0 right-0 flex space-x-1 opacity-0 group-hover:opacity-100 transition duration-300">
                                                    <a href="{{ route('schedules.edit', $scheduleId) }}" class="bg-yellow-500 text-white p-1 rounded text-xs hover:bg-yellow-600 transition">
                                                        Sửa
                                                    </a>
                                                    <button class="bg-red-500 text-white p-1 rounded text-xs hover:bg-red-600 transition delete-btn"
                                                            onclick="showDeletePopup('schedule_{{ $scheduleId }}', 'lịch học ID {{ $scheduleId }}', '{{ route('schedules.destroy', $scheduleId) }}')">
                                                        Xóa
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div style="padding: 0.5rem;"></div>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        @if ($scheduleByDay->flatten()->isEmpty())
            <div class="mt-6 text-center text-gray-500 p-6 bg-gray-50 rounded-lg">
                <p class="text-lg">Chưa có lịch học/dạy.</p>
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('schedules.create') }}" class="text-blue-600 hover:text-blue-800 underline font-medium">Thêm lịch đầu tiên</a>
                @endif
            </div>
        @endif

        <!-- Custom Delete Popup with Overlay -->
        <div class="custom-overlay" id="deleteOverlay" onclick="hideDeletePopup()"></div>
        <div class="custom-popup" id="deletePopup">
            <button class="close-btn" onclick="hideDeletePopup()">&times;</button>
            <h3 class="text-xl font-bold text-gray-900">Xác nhận xóa</h3>
            <p class="text-gray-600 mb-4">Bạn có chắc chắn muốn xóa <span id="popupItemName" class="font-semibold text-red-600"></span>? <br><span class="text-sm text-gray-500">Hành động này không thể hoàn tác!</span></p>
            <div class="flex justify-end space-x-4">
                <button onclick="hideDeletePopup()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                    Hủy
                </button>
                <form id="deleteForm" method="POST" action="" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Xóa
                    </button>
                </form>
            </div>
        </div>

        <!-- Error Message Popup -->
        <div id="errorMessage" class="error-message hidden">
            <button class="close-btn" onclick="this.parentElement.remove()">&times;</button>
            <p id="errorText"></p>
        </div>
    </div>

    <script>
        function showDeletePopup(id, itemName, actionUrl) {
            const popup = document.getElementById('deletePopup');
            const overlay = document.getElementById('deleteOverlay');
            const itemNameSpan = document.getElementById('popupItemName');
            const form = document.getElementById('deleteForm');
            itemNameSpan.textContent = itemName;
            form.action = actionUrl;
            popup.classList.add('active');
            overlay.classList.add('active');
        }
    
        function hideDeletePopup() {
            const popup = document.getElementById('deletePopup');
            const overlay = document.getElementById('deleteOverlay');
            popup.classList.remove('active');
            overlay.classList.remove('active');
        }

        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            const errorText = document.getElementById('errorText');
            errorText.textContent = message;
            errorDiv.classList.remove('hidden');
            setTimeout(() => errorDiv.classList.add('hidden'), 5000);
        }

        // Giả sử bạn có AJAX cho storeInline
        document.querySelectorAll('.add-schedule-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = document.getElementById('scheduleForm');
                if (!form) {
                    showError('Form không tồn tại!');
                    return;
                }

                const formData = new FormData(form);
                fetch('{{ route('schedules.store-inline') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload(); // Reload để cập nhật bảng
                    } else {
                        showError(data.message || 'Lỗi khi thêm lịch học');
                    }
                })
                .catch(error => {
                    showError('Đã xảy ra lỗi: ' + error.message);
                });
            });
        });
    </script>
@endsection