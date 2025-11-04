@extends('layouts.app')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold mb-6 text-center" style="color:#1e3a8a;">
        Quản lý người dùng
    </h1>

    <!-- Thanh công cụ -->
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('admin.users.create') }}" 
           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-lg shadow-md transition-all duration-300 hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Thêm người dùng
        </a>

        <!-- Bộ lọc -->
        <form method="GET" action="{{ route('admin.users.index') }}" 
              class="flex flex-wrap gap-4 items-center bg-gray-50 px-4 py-2 rounded-lg shadow-sm border">
            
            {{-- Bộ lọc vai trò --}}
            <div>
                <label for="role" class="text-sm font-medium text-gray-700 mr-2">Vai trò:</label>
                <select name="role" id="role" class="border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                    <option value="">Tất cả</option>
                    <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Học sinh</option>
                    <option value="teacher" {{ request('role') === 'teacher' ? 'selected' : '' }}>Giáo viên</option>
                </select>
            </div>

            {{-- Bộ lọc lớp nếu là học sinh --}}
            @if($selectedRole === 'student')
            <div>
                <label class="text-sm font-medium text-gray-700 mr-2">Lớp:</label>
                <select name="class_id" class="border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                    <option value="">Tất cả lớp</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- Bộ lọc môn nếu là giáo viên --}}
            @if($selectedRole === 'teacher')
            <div>
                <label class="text-sm font-medium text-gray-700 mr-2">Môn dạy:</label>
                <select name="subject_id" class="border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                    <option value="">Tất cả môn</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif
        </form>
    </div>

    <!-- Thông báo -->
    @if(session('success'))
    <div class="mb-6 p-4 text-green-800 bg-green-100 border border-green-300 rounded-lg shadow-sm">
        ✅ {{ session('success') }}
    </div>
    @endif

    <!-- Bảng danh sách -->
    <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr class="bg-blue-50 text-gray-700 text-sm uppercase tracking-wide">
                    <th class="p-3 border text-center">STT</th>
                    <th class="p-3 border">Tên</th>
                    <th class="p-3 border">Mã</th>
                    <th class="p-3 border">Email</th>

                    @if($selectedRole === 'student')
                        <th class="p-3 border">Ngày sinh</th>
                        <th class="p-3 border">Giới tính</th>
                        <th class="p-3 border">Lớp</th>
                    @elseif($selectedRole === 'teacher')
                        <th class="p-3 border">Môn dạy</th>
                        <th class="p-3 border">Bằng cấp</th>
                        <th class="p-3 border text-center">Số lớp phụ trách</th>
                    @else
                        <th class="p-3 border">Vai trò</th>
                    @endif
                    <th class="p-3 border text-center">Thao tác</th>
                </tr>
            </thead>

            <tbody class="text-gray-800">
                @forelse ($users as $user)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="p-3 border text-center font-medium">{{ $users->firstItem() + $loop->index }}</td>
                    <td class="p-3 border font-semibold">{{ $user->name }}</td>
                    <td class="p-3 border">
                        @if($user->role === 'teacher')
                            {{ $user->teacher->teacher_id ?? '-' }}
                        @elseif($user->role === 'student')
                            {{ $user->student->student_id ?? '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="p-3 border">{{ $user->email }}</td>

                    @if($selectedRole === 'student')
                    <td class="p-3 border">
                        {{ $user->student && $user->student->day_of_birth 
                            ? \Carbon\Carbon::parse($user->student->day_of_birth)->format('d-m-Y') 
                            : '—' }}
                    </td>
                    <td class="p-3 border">
                        @if($user->student && $user->student->gender)
                            {{ $user->student->gender === 'male' ? 'Nam' : ($user->student->gender === 'female' ? 'Nữ' : '—') }}
                        @else
                            —
                        @endif
                    </td>
                    <td class="p-3 border">{{ $user->student->class->name ?? '—' }}</td>

                    @elseif($selectedRole === 'teacher')
                    <td class="p-3 border">
                        @php
                            $subjectName = $user->teacher->subject->name ?? null;
                            $translatedSubjects = [
                                'math' => 'Toán học', 'physics' => 'Vật lý', 'chemistry' => 'Hóa học',
                                'biology' => 'Sinh học', 'literature' => 'Ngữ văn', 'history' => 'Lịch sử',
                                'geography' => 'Địa lý', 'english' => 'Tiếng Anh', 'it' => 'Tin học', 'exercise' => 'Thể dục'
                            ];
                        @endphp
                        {{ $subjectName ? ($translatedSubjects[strtolower($subjectName)] ?? $subjectName) : '—' }}
                    </td>
                    <td class="p-3 border">
                        @switch($user->teacher->level ?? '')
                            @case('Bachelor') Cử nhân @break
                            @case('Master') Thạc sĩ @break
                            @case('PhD') Tiến sĩ @break
                            @default —
                        @endswitch
                    </td>
                    <td class="p-3 border text-center">{{ $user->teacher->classes->count() ?? '—' }}</td>

                    @else
                    <td class="p-3 border">{{ ucfirst($user->role) }}</td>
                    @endif

                    <td class="p-3 border text-center">
                        @if($user->role !== 'admin')
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium">Sửa</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Xóa</button>
                            </form>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="p-6 text-center text-gray-500">Không có người dùng nào phù hợp.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div class="mt-6 flex justify-center">
        {{ $users->appends(request()->query())->links('pagination::tailwind') }}
    </div>
</div>
@endsection
