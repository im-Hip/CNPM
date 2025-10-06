<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Hệ Thống Quản Lý Lịch Học')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar (Menu bên trái - 1/5) -->
        <aside class="w-1/5 bg-white shadow-lg relative">
            @include('layouts.navigation')
        </aside>

        <!-- Main Content (Nội dung chính bên phải - 4/5) -->
        <main class="w-4/5 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>