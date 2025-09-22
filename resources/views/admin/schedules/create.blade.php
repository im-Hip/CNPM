@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Thêm lịch học</h1>

    <form action="{{ route('schedules.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Môn học</label>
            <input type="text" name="subject" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Giảng viên</label>
            <input type="text" name="teacher" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Ngày học</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Giờ bắt đầu</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Giờ kết thúc</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phòng học</label>
            <input type="text" name="room" class="form-control">
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mr-2 ml-3">Lưu</button>
    </form>
</div>
@endsection
