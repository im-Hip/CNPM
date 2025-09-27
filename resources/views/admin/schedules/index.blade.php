@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-2">Quản lý lịch học</h1>
    <a href="{{ route('schedules.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mr-2 ml-3 mb-4 inline-block">Thêm lịch học</a>

    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif

    <table class="border border-gray-400">
        <tr class="border border-gray-400">
            <th class="border border-gray-400 px-2 py-1">ID</th>
            <th class="border border-gray-400 px-2 py-1">Giảng viên</th>
            <th class="border border-gray-400 px-2 py-1">Lớp học</th>
            <th class="border border-gray-400 px-2 py-1">Môn học</th>
            <th class="border border-gray-400 px-2 py-1">Phòng học</th>
            <th class="border border-gray-400 px-2 py-1">Thứ</th>
            <th class="border border-gray-400 px-2 py-1">Tiết (giờ) bắt đầu</th>
            <th class="border border-gray-400 px-2 py-1">Tiết (giờ) kết thúc</th>
            <th class="border border-gray-400 px-2 py-1">Ghi chú</th>
            <th class="border border-gray-400 px-2 py-1">Thao tác</th>
        </tr>
        @foreach($schedules as $s)
        <tr class="border border-gray-400">
            <td class="border border-gray-400 px-2 py-1">{{ $s->id }}</td>
            <td class="border border-gray-400 px-2 py-1">{{ $s->teacher->user->name }}</td>
            <td class="border border-gray-400 px-2 py-1">{{ $s->classes->name }}</td>
            <td class="border border-gray-400 px-2 py-1">{{ $s->teacher->subject->name }}</td>
            <td class="border border-gray-400 px-2 py-1">{{ $s->room->name }}</td>
            <td class="border border-gray-400 px-2 py-1">{{ $s->day_of_week }}</td>
            <td class="border border-gray-400 px-2 py-1">
                {{ $s->start_time }}
                ({{ $start_periods[$s->start_time] }})
            </td>
            <td class="border border-gray-400 px-2 py-1">
                {{ $s->end_time }}
                ({{ $end_periods[$s->end_time] }})
            </td>
            <td class="border border-gray-400 px-2 py-1">{{ $s->note }}</td>
            <td class="border border-gray-400 px-2 py-1">
                <div class="flex space-x-2">
                    <a href="{{ route('schedules.edit', $s->id) }}"
                        class="bg-blue-500 text-white px-3 py-1.5 text-sm rounded">
                        Sửa
                    </a>
                    <form action="{{ route('schedules.destroy', $s->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-3 py-1.5 text-sm rounded">
                            Xóa
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection