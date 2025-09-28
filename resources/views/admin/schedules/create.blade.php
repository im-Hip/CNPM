@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3 mt-2">Thêm lịch học</h1>

    <form action="{{ route('schedules.store') }}" method="POST">
        @csrf
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