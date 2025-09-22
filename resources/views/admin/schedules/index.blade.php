@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-2">Quản lý lịch học</h1>
    <a href="{{ route('schedules.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mr-2 ml-3">Thêm lịch học</a>

    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif

    <table class="table table-bordered mt-2">
        <tr>
            <th>ID</th>
            <th>Môn học</th>
            <th>Giảng viên</th>
            <th>Ngày</th>
            <th>Giờ</th>
            <th>Phòng</th>
            <th>Thao tác</th>
        </tr>
        @foreach($schedules as $s)
        <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->subject }}</td>
            <td>{{ $s->teacher }}</td>
            <td>{{ $s->date }}</td>
            <td>{{ $s->start_time }} - {{ $s->end_time }}</td>
            <td>{{ $s->room }}</td>
            <td>
                <a href="{{ route('schedules.edit', $s->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                <form action="{{ route('schedules.destroy', $s->id) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
