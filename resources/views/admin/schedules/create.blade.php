@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-2xl">

    <h1 class="text-3xl font-bold text-center" style="color: #1e3a8a;">Thêm lịch học mới</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('schedules.store') }}" id="create-form">
        @csrf
        <div class="bg-white p-6 rounded shadow">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Lớp học <span class="text-red-500">*</span></label>
                <select name="class_id" class="w-full px-3 py-2 border rounded" required onchange="loadSubjects(this.value)">
                    <option value="">Chọn lớp</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Môn học <span class="text-red-500">*</span></label>
                <select name="subject_id" id="subject-select" class="w-full px-3 py-2 border rounded" required onchange="loadTeacher()">
                    <option value="">Chọn lớp trước</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Giáo viên</label>
                <input type="text" id="teacher-display" class="w-full px-3 py-2 border rounded bg-gray-100" readonly>
                <input type="hidden" name="teacher_id" id="teacher-id">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Phòng học</label>
                <select name="room_id" id="room-select" class="w-full px-3 py-2 border rounded">
                    <option value="">Chưa chỉ định</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Thứ <span class="text-red-500">*</span></label>
                <select name="day_of_week" class="w-full px-3 py-2 border rounded" required>
                    <option value="">Chọn thứ</option>
                    <option value="1" {{ old('day_of_week') == 1 ? 'selected' : '' }}>Thứ 2</option>
                    <option value="2" {{ old('day_of_week') == 2 ? 'selected' : '' }}>Thứ 3</option>
                    <option value="3" {{ old('day_of_week') == 3 ? 'selected' : '' }}>Thứ 4</option>
                    <option value="4" {{ old('day_of_week') == 4 ? 'selected' : '' }}>Thứ 5</option>
                    <option value="5" {{ old('day_of_week') == 5 ? 'selected' : '' }}>Thứ 6</option>
                    <option value="6" {{ old('day_of_week') == 6 ? 'selected' : '' }}>Thứ 7</option>
                    <option value="7" {{ old('day_of_week') == 7 ? 'selected' : '' }}>Chủ Nhật</option>
                </select>
                @error('day_of_week')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Tiết <span class="text-red-500">*</span></label>
                <select name="class_period" class="w-full px-3 py-2 border rounded" required>
                    <option value="">Chọn tiết</option>
                    @for ($p = 1; $p <= 10; $p++)
                        <option value="{{ $p }}" {{ old('class_period') == $p ? 'selected' : '' }}>Tiết {{ $p }}</option>
                    @endfor
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Ghi chú</label>
                <textarea name="note" id="note-input" class="w-full px-3 py-2 border rounded" rows="3">{{ old('note') }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('schedules.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Hủy</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Lưu Lịch Học</button>
            </div>
        </div>
    </form>
</div>

<script>
    function loadSubjects(classId) {
        if (!classId) return;
        fetch(`/api/subjects/${classId}`)
            .then(r => r.json())
            .then(data => {
                const select = document.getElementById('subject-select');
                select.innerHTML = '<option value="">Chọn môn</option>';
                data.forEach(s => select.innerHTML += `<option value="${s.id}">${s.name}</option>`);
            });
    }

    function loadTeacher() {
        const classId = document.querySelector('select[name="class_id"]').value;
        const subjectId = document.getElementById('subject-select').value;
        if (!classId || !subjectId) return;
        fetch(`/api/teacher/${classId}/${subjectId}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('teacher-display').value = data.id ? `GV: ${data.name}` : data.name || 'Chưa phân công';
                document.getElementById('teacher-id').value = data.id || '';
            });
    }
</script>
@endsection