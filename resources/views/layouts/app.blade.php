<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Quản Lý Lịch Học')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center fixed w-full z-10 top-0">
        <div class="text-xl font-bold text-gray-800">Quản Lý Lịch Học</div>
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600">Xin chào, {{ Auth::user()->name }} ({{ Auth::user()->role }})</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Đăng xuất</button>
            </form>
        </div>
    </nav>

    <!-- Main content -->
    <div class="pt-20 min-h-screen">
        @yield('content')  {{-- Nơi view con đặt nội dung --}}
    </div>

    <!-- Footer đơn giản (bỏ nếu không cần) -->
    <footer class="bg-gray-800 text-white p-4 text-center mt-8">
        © 2025 Quản Lý Lịch Học. All rights reserved.
    </footer>
</body>
</html>