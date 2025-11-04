@extends('layouts.app')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-center" style="color:#1e3a8a;">Danh sách người dùng</h1>

    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Thêm người dùng</a>

        <!-- Bộ lọc vai trò -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-4 mb-6">
            {{-- Bộ lọc role --}}
            <select name="role" id="role" class="border px-3 py-1 rounded" onchange="this.form.submit()">
                <option value="">Tất cả</option>
                <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Học sinh</option>
                <option value="teacher" {{ request('role') === 'teacher' ? 'selected' : '' }}>Giáo viên</option>
            </select>

            {{-- Nếu chọn học sinh thì hiện bộ lọc lớp --}}
            @if($selectedRole === 'student')
            <select name="class_id" class="border px-3 py-1 rounded" onchange="this.form.submit()">
                <option value="">Tất cả lớp</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
                @endforeach
            </select>
            @endif

            {{-- Nếu chọn giáo viên thì hiện bộ lọc môn --}}
            @if($selectedRole === 'teacher')
            <select name="subject_id" class="border px-3 py-1 rounded" onchange="this.form.submit()">
                <option value="">Tất cả môn</option>
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
                @endforeach
            </select>
            @endif
        </form>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 mt-4 rounded">
        {{ session('success') }}
    </div>
    @endif

    <table class="w-full mt-6 border-collapse border">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="p-2 border">Số thứ tự</th>
                <th class="p-2 border">Tên</th>
                <th class="p-2 border">Mã</th>
                <th class="p-2 border">Email</th>

                @if($selectedRole === 'student')
                <th class="p-2 border">Năm sinh</th>
                <th class="p-2 border">Giới tính</th>
                <th class="p-2 border">Lớp</th>

                @elseif($selectedRole === 'teacher')
                <th class="p-2 border">Môn dạy</th>
                <th class="p-2 border">Bằng cấp</th>
                <th class="p-2 border">Số lớp phụ trách</th>

                @else
                <th class="p-2 border">Vai trò</th>

                @endif
                <th class="p-2 border">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr class="border">
                <td class="p-2 border">{{ $users->firstItem() + $loop->index }}</td>
                <td class="p-2 border">{{ $user->name }}</td>
                <td class="p-2 border">
                    @if($user->role === 'teacher')
                    {{ $user->teacher->teacher_id ?? '-'}}
                    @elseif($user->role === 'student')
                    {{ $user->student->student_id ?? '-'}}
                    @else
                    -
                    @endif
                </td>
                <td class="p-2 border">{{ $user->email }}</td>

                @if($selectedRole === 'student')
                <td class="p-2 border">{{ $user->student->day_of_birth ?? '—' }}</td>
                <td class="p-2 border">{{ $user->student->gender ?? '—' }}</td>
                <td class="p-2 border">{{ $user->student->class->name ?? '—' }}</td>

                @elseif($selectedRole === 'teacher')
                <td class="p-2 border">{{ $user->teacher->subject->name ?? '—' }}</td>
                <td class="p-2 border">{{ $user->teacher->level ?? '—' }}</td>
                <td class="p-2 border">{{ $user->classes_count ?? '—' }}</td>

                @else
                <td class="p-2 border">{{ ucfirst($user->role) }}</td>
                @endif

                <td class="p-2 border">
                    @if($user->role !== 'admin')
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600">Sửa</a> |
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600" onclick="return confirm('Xóa người dùng này?')">Xóa</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endsection