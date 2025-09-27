@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3 mt-2">Thêm lịch học</h1>

    <form action="{{ route('schedules.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Lớp học</label>
            <select name="class_id" id="class_id">
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
            </select>
        </div>
        <div id="subject-info" class="alert alert-info" style="display:block;"></div>
        <div class="mb-3">
            <label>Giáo viên</label>
            <select name="teacher_id" id="teacher_id">
                <option value="">-- Chọn giáo viên --</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Phòng học</label>
            <select name="room_id" id="room_id">
                <option value="">-- Chọn phòng học --</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Thứ</label>
            <select name="day">
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
            <select name="start_time" id="start_time">
                <option value="">-- Chọn tiết bắt đầu --</option>
                <option value="1">Tiết 1</option>
                <option value="2">Tiết 2</option>
                <option value="3">Tiết 3</option>
                <option value="4">Tiết 4</option>
                <option value="5">Tiết 5</option>
                <option value="6">Tiết 6</option>
                <option value="7">Tiết 7</option>
                <option value="8">Tiết 8</option>
                <option value="9">Tiết 9</option>
                <option value="10">Tiết 10</option>
                <option value="11">Tiết 11</option>
                <option value="12">Tiết 12</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Tiết (giờ) kết thúc</label>
            <select name="end_time" id="end_time">
                <option value="">-- Chọn tiết kết thúc --</option>
                <option value="1">Tiết 1</option>
                <option value="2">Tiết 2</option>
                <option value="3">Tiết 3</option>
                <option value="4">Tiết 4</option>
                <option value="5">Tiết 5</option>
                <option value="6">Tiết 6</option>
                <option value="7">Tiết 7</option>
                <option value="8">Tiết 8</option>
                <option value="9">Tiết 9</option>
                <option value="10">Tiết 10</option>
                <option value="11">Tiết 11</option>
                <option value="12">Tiết 12</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Ghi chú</label>
            <input type="text" name="note">
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mr-2 ml-3">Lưu</button>
    </form>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    //thay doi dropdown giao vien
    $(document).ready(function() {
        var maxPeriods = 0; // Biến toàn cục lưu số tiết còn thiếu

        var $endOptions = $('#end_time option').clone();

        //thay doi dropdown phong hoc
        function loadRooms() {
            let subjectId = $('#subject_id').val();
            let classId = $('#class_id').val();
            let $roomSelect = $('#room_id');

            $('#room_id').empty().append('<option value="">-- Chọn phòng học --</option>');

            if (subjectId && classId) {
                $.get(`/rooms/by-subject/${subjectId}/${classId}`, function(data) {
                    if (data.length === 1 && data[0].id == classId) {
                        // Trường hợp học ở lớp -> ẩn dropdown, tự set value
                        $roomSelect.append('<option value="' + data[0].id + '" selected>' + data[0].name + '</option>');
                        $roomSelect.closest('.mb-3').hide();
                    } else {
                        // Có nhiều lựa chọn (IT hoặc Lý/Hóa/Sinh) -> hiển thị dropdown
                        $.each(data, function(index, room) {
                            $roomSelect.append('<option value="' + room.id + '">' + room.name + '</option>');
                        });
                        $roomSelect.closest('.mb-3').show();
                    }
                });
            } else {
                $roomSelect.closest('.mb-3').show();
            }
        }

        // khi đổi môn học → load lại phòng
        $('#subject_id').on('change', loadRooms);

        // khi đổi lớp học → load lại phòng
        $('#class_id').on('change', loadRooms);

        //kiem tra mon hoc cua 1 lop con bao nhieu tiet + load dropdown giao vien
        $('#class_id').on('change', function() {
            let classId = $(this).val();
            let $subjectSelect = $('#subject_id');
            $subjectSelect.empty().append('<option value="">-- Chọn môn học --</option>');

            if (classId) {
                $.get(`/subjects/by-class/${classId}`, function(data) {
                    $.each(data, function(index, subject) {
                        $subjectSelect.append('<option value="' + subject.subject_id + '" ' +
                            'data-required="' + subject.required_periods + '" ' +
                            'data-scheduled="' + subject.scheduled_periods + '" ' +
                            'data-remaining="' + subject.remaining_periods + '">' +
                            subject.subject_name +
                            '</option>');
                    });
                });
            }
        });
        $('#subject_id').on('change', function() {
            let subjectId = $(this).val();

            //xu ly hien thi so tiet
            let selected = $(this).find(':selected');
            let required = selected.data('required');
            let scheduled = selected.data('scheduled');
            let remaining = selected.data('remaining');
            maxPeriods = remaining || 0;

            if (required !== undefined) {
                $('#subject-info').html(`
            <p><strong>Số tiết quy định:</strong> ${required}</p>
            <p><strong>Số tiết đã học:</strong> ${scheduled}</p>
            <p><strong>Số tiết còn thiếu:</strong> ${remaining}</p>
        `);
            } else {
                $('#subject-info').empty();
            }

            // xử lý load giáo viên
            $('#teacher_id').empty().append('<option value="">-- Chọn giáo viên --</option>');
            if (subjectId) {
                $.get('/teachers/by-subject/' + subjectId, function(data) {
                    $.each(data, function(index, teacher) {
                        $('#teacher_id').append('<option value="' + teacher.id + '">' + teacher.name + '</option>');
                    });
                });
            }

            // Reset các dropdown tiết
            $('#start_time').val('');
            $('#end_time').html($endOptions);
        });

        //khi chon tiet bat dau
        $('#start_time').on('change', function() {
            var startVal = parseInt($(this).val());
            if (!startVal) {
                $('#end_time').html($endOptions);
                return;
            }

            // Nếu maxPeriods = 1, end_time = start_time luôn
            if (maxPeriods === 1) {
                $('#end_time').html(`<option value="${startVal}" selected>Tiết ${startVal}</option>`);
                return;
            }

            // Nếu maxPeriods > 1, lọc option như bình thường
            $('#end_time').empty().append('<option value="">-- Chọn tiết kết thúc --</option>');
            $endOptions.each(function() {
                var val = parseInt($(this).val());
                if (val >= startVal && (val - startVal + 1) <= maxPeriods) {
                    $('#end_time').append($(this).clone());
                }
            });
        });
    });
</script>