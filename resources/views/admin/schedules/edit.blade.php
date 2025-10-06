@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-2xl">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Sửa Lịch Học</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('schedules.update', $schedule) }}" id="edit-form">
        @csrf
        @method('PUT')  {{-- Cho update --}}
        <div class="bg-white p-6 rounded shadow">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Lớp học <span class="text-red-500">*</span></label>
                <input type="text" value="{{ $schedule->class->name ?? 'N/A' }}" class="w-full px-3 py-2 border rounded bg-gray-100" readonly placeholder="Lớp không thể thay đổi">
                <input type="hidden" name="class_id" value="{{ $schedule->class_id }}">
                @error('class_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Môn học <span class="text-red-500">*</span></label>
                <select name="subject_id" id="subject-select" class="w-full px-3 py-2 border rounded" required onchange="loadTeacher()">
                    <option value="">Chọn lớp trước</option>
                </select>
                @error('subject_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Giáo viên</label>
                <input type="text" id="teacher-display" class="w-full px-3 py-2 border rounded bg-gray-100" readonly value="GV: {{ $schedule->teacher->user->name ?? 'N/A' }}" placeholder="Chọn môn để xem GV">
                <input type="hidden" name="teacher_id" id="teacher-id" value="{{ $schedule->teacher_id }}">
                @error('teacher')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Phòng học</label>
                <select name="room_id" id="room-select" class="w-full px-3 py-2 border rounded">
                    <option value="">Chưa chỉ định</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id', $schedule->room_id) == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                    @endforeach
                </select>
                @error('room_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Thứ <span class="text-red-500">*</span></label>
                <select name="day_of_week" class="w-full px-3 py-2 border rounded" required>
                    <option value="">Chọn thứ</option>
                    <option value="1" {{ old('day_of_week', $schedule->day_of_week) == 1 ? 'selected' : '' }}>Thứ 2</option>
                    <option value="2" {{ old('day_of_week', $schedule->day_of_week) == 2 ? 'selected' : '' }}>Thứ 3</option>
                    <option value="3" {{ old('day_of_week', $schedule->day_of_week) == 3 ? 'selected' : '' }}>Thứ 4</option>
                    <option value="4" {{ old('day_of_week', $schedule->day_of_week) == 4 ? 'selected' : '' }}>Thứ 5</option>
                    <option value="5" {{ old('day_of_week', $schedule->day_of_week) == 5 ? 'selected' : '' }}>Thứ 6</option>
                    <option value="6" {{ old('day_of_week', $schedule->day_of_week) == 6 ? 'selected' : '' }}>Thứ 7</option>
                    <option value="7" {{ old('day_of_week', $schedule->day_of_week) == 7 ? 'selected' : '' }}>Chủ Nhật</option>
                </select>
                @error('day_of_week')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Tiết <span class="text-red-500">*</span></label>
                <select name="class_period" class="w-full px-3 py-2 border rounded" required>
                    <option value="">Chọn tiết</option>
                    @for ($p = 1; $p <= 10; $p++)
                        <option value="{{ $p }}" {{ old('class_period', $schedule->class_period) == $p ? 'selected' : '' }}>Tiết {{ $p }}</option>
                    @endfor
                </select>
                @error('class_period')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Ghi chú</label>
                <textarea name="note" id="note-input" class="w-full px-3 py-2 border rounded" rows="3">{{ old('note', $schedule->note) }}</textarea>
                @error('note')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Cập Nhật Lịch</button>
                <a href="{{ route('schedules.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Hủy</a>
            </div>
        </div>
    </form>
</div>

<script>
    // Giữ nguyên loadSubjects và loadTeacher từ create.blade.php
    function loadSubjects(classId) {
        if (!classId) {
            document.getElementById('subject-select').innerHTML = '<option value="">Chọn lớp trước</option>';
            return;
        }
        fetch(`/api/subjects/${classId}`)
            .then(r => r.json())
            .then(data => {
                const select = document.getElementById('subject-select');
                select.innerHTML = '<option value="">Chọn môn</option>';
                data.forEach(s => select.innerHTML += `<option value="${s.id}">${s.name}</option>`);
                // Pre-select nếu có old value
                const oldSubject = '{{ old('subject_id', $schedule->subject_id) }}';
                if (oldSubject) select.value = oldSubject;
                loadTeacher();  // Reload teacher sau khi select subject
            })
            .catch(e => console.error('Subjects error:', e));
    }

    function loadTeacher() {
        const classId = document.querySelector('select[name="class_id"]').value;
        const subjectId = document.getElementById('subject-select').value;
        if (!classId || !subjectId) {
            document.getElementById('teacher-display').value = 'Chọn môn để xem GV';
            document.getElementById('teacher-id').value = '';
            return;
        }
        fetch(`/api/teacher/${classId}/${subjectId}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('teacher-display').value = data.id ? `GV: ${data.name}` : data.name || 'Chưa phân công GV cho môn này';
                document.getElementById('teacher-id').value = data.id || '';
            })
            .catch(e => console.error('Teacher error:', e));
    }

    // Load initial data
    document.addEventListener('DOMContentLoaded', function() {
        const initialClassId = '{{ old('class_id', $schedule->class_id) }}';
        if (initialClassId) {
            loadSubjects(initialClassId);
        }
    });
</script>
@endsection