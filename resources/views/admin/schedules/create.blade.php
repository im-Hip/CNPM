@extends('layouts.app')  <!-- Hoặc layout của bạn -->

@section('content')
<<<<<<< HEAD
<div class="container">
    <h1 class="mb-3 mt-2">Thêm lịch học</h1>
=======
<div class="container mx-auto p-4 max-w-2xl">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Thêm Lịch Học Mới</h1>
>>>>>>> origin/main

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
<<<<<<< HEAD
        <div class="mb-3">
            <label>Lớp học</label>
            <select>
                <option value="">-- Chọn lớp học --</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Môn học</label>
            <select name="subject_id" id="subject_id">
                <option value="">-- Chọn môn học --</option>
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Giáo viên</label>
            <select name="teacher_id" id="teacher_id">
                <option value="">-- Chọn giáo viên --</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Phòng học</label>
            <select>
                <option value="">-- Chọn phòng học --</option>
                @foreach($rooms as $room)
                <option value="{{ $room->id }}">{{ $room->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Thứ</label>
            <select>
                <option value="">-- Chọn thứ --</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Tiết (giờ) bắt đầu</label>
            <input type="text" name="room" class="form-control">
        </div>
        <div class="mb-3">
            <label>Tiết (giờ) kết thúc</label>
            <input type="text" name="room" class="form-control">
        </div>
        <div class="mb-3">
            <label>Ghi chú</label>
            <input type="text" name="room" class="form-control">
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mr-2 ml-3">Lưu</button>
    </form>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#subject_id').on('change', function() {
            let subjectId = $(this).val();

            // reset dropdown giáo viên
            $('#teacher_id').empty().append('<option value="">-- Chọn giáo viên --</option>');

            if (subjectId) {
                $.get('/teachers/by-subject/' + subjectId, function(data) {
                    $.each(data, function(index, teacher) {
                        $('#teacher_id').append('<option value="' + teacher.id + '">' + teacher.name + '</option>');
                    });
                });
            }
        });
    });
</script>
=======
        <div class="bg-white p-6 rounded shadow">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Lớp học <span class="text-red-500">*</span></label>
                <select name="class_id" class="w-full px-3 py-2 border rounded" required onchange="loadSubjects(this.value)">
                    <option value="">Chọn lớp</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Môn học <span class="text-red-500">*</span></label>
                <select name="subject_id" id="subject-select" class="w-full px-3 py-2 border rounded" required onchange="loadTeacher()">
                    <option value="">Chọn lớp trước</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Giáo viên</label>
                <input type="text" id="teacher-display" class="w-full px-3 py-2 border rounded bg-gray-100" readonly>
                <input type="hidden" name="teacher_id" id="teacher-id">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Phòng học</label>
                <select name="room_id" id="room-select" class="w-full px-3 py-2 border rounded">
                    <option value="">Chưa chỉ định</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Thứ <span class="text-red-500">*</span></label>
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
                <label class="block text-gray-700 text-sm font-bold mb-2">Tiết <span class="text-red-500">*</span></label>
                <select name="class_period" class="w-full px-3 py-2 border rounded" required>
                    <option value="">Chọn tiết</option>
                    @for ($p = 1; $p <= 10; $p++)
                        <option value="{{ $p }}" {{ old('class_period') == $p ? 'selected' : '' }}>Tiết {{ $p }}</option>
                    @endfor
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Ghi chú</label>
                <textarea name="note" id="note-input" class="w-full px-3 py-2 border rounded" rows="3">{{ old('note') }}</textarea>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Lưu Lịch Học</button>
                <a href="{{ route('schedules.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Hủy</a>
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
>>>>>>> origin/main
