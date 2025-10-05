<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <!-- Navbar cố định -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center fixed w-full z-10 top-0">
        <div class="text-xl font-bold text-gray-800">Quản Lý Lịch Học</div>
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600">Xin chào, {{ Auth::user()->name }} ({{ Auth::user()->role }})</span>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Đăng xuất</button>
            </form>
        </div>
    </nav>

    <!-- Main content -->
    <div class="pt-20 p-6 container mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard</h1>

        <!-- Link chung (cho tất cả role) -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Chức Năng Chung</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('notifications.index') }}" class="bg-blue-500 text-white p-6 rounded-lg shadow-md hover:bg-blue-600 transition text-center">
                    📢 Xem Thông Báo
                </a>
            </div>
        </div>

        <!-- Chức năng theo role -->
        @if (Auth::user()->role === 'admin')
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Quản Lý Hệ Thống</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('admin.users.create') }}" class="bg-indigo-500 text-white p-6 rounded-lg shadow-md hover:bg-indigo-600 transition text-center">
                        👥 Quản Lý Người Dùng
                    </a>
                    <a href="{{ route('schedules.index') }}" class="bg-green-500 text-white p-6 rounded-lg shadow-md hover:bg-green-600 transition text-center">
                        📅 Quản Lý Lịch Học
                    </a>
                    <a href="{{ route('teacher_assignments.index') }}" class="bg-purple-500 text-white p-6 rounded-lg shadow-md hover:bg-purple-600 transition text-center">
                        👨‍🏫 Phân Công Giáo Viên
                    </a>
                    <a href="{{ route('assignments.index') }}" class="bg-orange-500 text-white p-6 rounded-lg shadow-md hover:bg-orange-600 transition text-center">
                        📝 Quản Lý Bài Tập
                    </a>
                    <a href="{{ route('notifications.create') }}" class="bg-blue-500 text-white p-6 rounded-lg shadow-md hover:bg-blue-600 transition text-center">
                        📢 Gửi Thông Báo
                    </a>
                </div>
            </div>
        @elseif (Auth::user()->role === 'teacher')
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Chức Năng Dành Cho Giáo Viên</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('schedules.index') }}" class="bg-green-500 text-white p-6 rounded-lg shadow-md hover:bg-green-600 transition text-center">
                        📅 Xem Lịch Dạy
                    </a>
                    <a href="{{ route('assignments.create') }}" class="bg-indigo-500 text-white p-6 rounded-lg shadow-md hover:bg-indigo-600 transition text-center">
                        📝 Giao Bài Tập
                    </a>
                    <a href="{{ route('notifications.create') }}" class="bg-blue-500 text-white p-6 rounded-lg shadow-md hover:bg-blue-600 transition text-center">
                        📢 Gửi Thông Báo Lớp
                    </a>
                </div>
            </div>
        @elseif (Auth::user()->role === 'student')
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Chức Năng Dành Cho Học Sinh</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('schedules.index') }}" class="bg-blue-500 text-white p-6 rounded-lg shadow-md hover:bg-blue-600 transition text-center">
                        📅 Xem Lịch Học
                    </a>
                    <a href="{{ route('assignments.index') }}" class="bg-indigo-500 text-white p-6 rounded-lg shadow-md hover:bg-indigo-600 transition text-center">
                        📝 Xem Bài Tập
                    </a>
                    <a href="{{ route('notifications.index') }}" class="bg-orange-500 text-white p-6 rounded-lg shadow-md hover:bg-orange-600 transition text-center">
                        📢 Xem Thông Báo
                    </a>
                </div>
            </div>
        @endif

        <!-- Footer đơn giản -->
        <div class="mt-12 text-center text-gray-500 text-sm border-t pt-4">
            © 2025 Quản Lý Lịch Học. All rights reserved.
        </div>
    </div>
</body>
</html>