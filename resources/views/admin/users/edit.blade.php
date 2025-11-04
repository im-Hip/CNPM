@extends('layouts.app')

@section('title', 'Chỉnh sửa người dùng')

@section('content')

<h1 class="text-3xl font-extrabold text-center pt-8" style="color: #1e3a8a;">
    Chỉnh sửa người dùng
</h1>

<div class="max-w-2xl mx-auto">
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-8">
        {{-- Hiển thị thông báo lỗi hoặc thành công --}}
        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif
        
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Tên --}}
            <div class="mb-4">
                <label for="name" class="block font-bold mb-1">Tên</label>
                <input type="text" name="name" id="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full border px-3 py-2 rounded" required>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block font-bold mb-1">Email</label>
                <input type="email" name="email" id="email"
                    value="{{ old('email', $user->email) }}"
                    class="w-full border px-3 py-2 rounded" required>
            </div>

            {{-- Nếu là giáo viên --}}
            @if($user->role === 'teacher')
            <div class="border-t mt-4 pt-4">
                <h3 class="font-bold text-lg mb-2 text-gray-700">Thông tin giáo viên</h3>
                <div class="mb-4">
                    <label for="subject_id" class="block font-bold mb-1">Môn học</label>
                    <select name="subject_id" id="subject_id" class="w-full border px-3 py-2 rounded">
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $teacherInfo && $teacherInfo->subject_id == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="level" class="block font-bold mb-1">Trình độ</label>
                    <select name="level" id="level" class="w-full border px-3 py-2 rounded">
                        <option value="Bachelor" {{ $teacherInfo && $teacherInfo->level == 'Bachelor' ? 'selected' : '' }}>Cử nhân</option>
                        <option value="Master" {{ $teacherInfo && $teacherInfo->level == 'Master' ? 'selected' : '' }}>Thạc sĩ</option>
                        <option value="PhD" {{ $teacherInfo && $teacherInfo->level == 'PhD' ? 'selected' : '' }}>Tiến sĩ</option>
                    </select>
                </div>
            </div>
            @endif

            {{-- Nếu là học sinh --}}
            @if($user->role === 'student')
            <div class="border-t mt-4 pt-4">
                <h3 class="font-bold text-lg mb-2 text-gray-700">Thông tin học sinh</h3>
                <div class="mb-4">
                    <label for="class_id" class="block font-bold mb-1">Lớp</label>
                    <select name="class_id" id="class_id" class="w-full border px-3 py-2 rounded">
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $studentInfo && $studentInfo->class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="gender" class="block font-bold mb-1">Giới tính</label>
                    <select name="gender" id="gender" class="w-full border px-3 py-2 rounded">
                        <option value="male" {{ $studentInfo && $studentInfo->gender == 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ $studentInfo && $studentInfo->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="day_of_birth" class="block font-bold mb-1">Ngày sinh</label>
                    <input type="date" name="day_of_birth" id="day_of_birth"
                        value="{{ $studentInfo->day_of_birth ?? '' }}"
                        class="w-full border px-3 py-2 rounded">
                </div>
            </div>
            @endif

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>

@endsection