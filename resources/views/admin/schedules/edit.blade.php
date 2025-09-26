@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sửa lịch học</h1>

    <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Bắt buộc dùng PUT khi update --}}
        
        <div class="mb-3">
            <label>Môn học</label>
            <input type="text" name="subject" class="form-control" value="{{ $schedule->subject }}" required>
        </div>
        <div class="mb-3">
            <label>Giảng viên</label>
            <input type="text" name="teacher" class="form-control" value="{{ $schedule->teacher }}" required>
        </div>
        <div class="mb-3">
            <label>Ngày học</label>
            <input type="date" name="date" class="form-control" value="{{ $schedule->date }}" required>
        </div>
        <div class="mb-3">
            <label>Giờ bắt đầu</label>
            <input type="time" name="start_time" class="form-control" value="{{ $schedule->start_time }}" required>
        </div>
        <div class="mb-3">
            <label>Giờ kết thúc</label>
            <input type="time" name="end_time" class="form-control" value="{{ $schedule->end_time }}" required>
        </div>
        <div class="mb-3">
            <label>Phòng học</label>
            <input type="text" name="room" class="form-control" value="{{ $schedule->room }}">
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>
@endsection
