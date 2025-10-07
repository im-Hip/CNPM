@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard</h1>

    <!-- Link chung (cho tất cả role) -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Chức Năng Chung</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('notifications.index') }}" class="bg-blue-500 text-white p-6 rounded-lg shadow-md hover:bg-blue-600 transition text-center flex justify-center items-center font-semibold">
                📢 Xem Thông Báo
            </a>
        </div>
    </div>

    <!-- Chức năng theo role -->
    @if (Auth::user()->role === 'admin')
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Quản Lý Hệ Thống</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.users.create') }}" class="bg-indigo-500 text-white p-6 rounded-lg shadow-md hover:bg-indigo-600 transition text-center flex justify-center items-center font-semibold">
                    👥 Quản Lý Người Dùng
                </a>
                <a href="{{ route('schedules.index') }}" class="bg-green-500 text-white p-6 rounded-lg shadow-md hover:bg-green-600 transition text-center flex justify-center items-center font-semibold">
                    📅 Quản Lý Lịch Học
                </a>
                <a href="{{ route('subjects.index') }}" class="bg-yellow-500 text-white p-6 rounded-lg shadow-md hover:bg-green-600 transition text-center flex justify-center items-center font-semibold">
                    📚 Quản Lý Môn Học
                </a>
                <a href="{{ route('schedules.index') }}" class="bg-green-500 text-white p-6 rounded-lg shadow-md hover:bg-green-600 transition text-center flex justify-center items-center font-semibold">
                    🏫 Quản Lý Lớp Học
                </a>
                <a href="{{ route('teacher_assignments.index') }}" class="bg-purple-500 text-white p-6 rounded-lg shadow-md hover:bg-purple-600 transition text-center flex justify-center items-center font-semibold">
                    👨‍🏫 Phân Công Giáo Viên
                </a>
                <a href="{{ route('assignments.index') }}" class="bg-orange-500 text-white p-6 rounded-lg shadow-md hover:bg-orange-600 transition text-center flex justify-center items-center font-semibold">
                    📝 Quản Lý Bài Tập
                </a>
                <a href="{{ route('notifications.create') }}" class="bg-cyan-500 text-white p-6 rounded-lg shadow-md hover:bg-cyan-600 transition text-center flex justify-center items-center font-semibold">
                    📢 Gửi Thông Báo
                </a>
            </div>
        </div>
    @elseif (Auth::user()->role === 'teacher')
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Chức Năng Dành Cho Giáo Viên</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('schedules.index') }}" class="bg-green-500 text-white p-6 rounded-lg shadow-md hover:bg-green-600 transition text-center flex justify-center items-center font-semibold">
                    📅 Xem Lịch Dạy
                </a>
                <a href="{{ route('assignments.create') }}" class="bg-indigo-500 text-white p-6 rounded-lg shadow-md hover:bg-indigo-600 transition text-center flex justify-center items-center font-semibold">
                    📝 Giao Bài Tập
                </a>
                <a href="{{ route('notifications.create') }}" class="bg-blue-500 text-white p-6 rounded-lg shadow-md hover:bg-blue-600 transition text-center flex justify-center items-center font-semibold">
                    📢 Gửi Thông Báo Lớp
                </a>
            </div>
        </div>
    @elseif (Auth::user()->role === 'student')
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Chức Năng Dành Cho Học Sinh</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('schedules.index') }}" class="bg-blue-500 text-white p-6 rounded-lg shadow-md hover:bg-blue-600 transition text-center flex justify-center items-center font-semibold">
                    📅 Xem Lịch Học
                </a>
                <a href="{{ route('assignments.index') }}" class="bg-indigo-500 text-white p-6 rounded-lg shadow-md hover:bg-indigo-600 transition text-center flex justify-center items-center font-semibold">
                    📝 Xem Bài Tập
                </a>
                <a href="{{ route('notifications.index') }}" class="bg-orange-500 text-white p-6 rounded-lg shadow-md hover:bg-orange-600 transition text-center flex justify-center items-center font-semibold">
                    📢 Xem Thông Báo
                </a>
            </div>
        </div>
    @endif
@endsection