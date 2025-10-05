<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Tải tài nguyên -->
</head>
<body>
    <!-- Navbar cố định -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center fixed w-full z-10">
        <div class="text-xl font-bold">Admin Panel</div>
        <div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Đăng xuất</button>
            </form>
        </div>
    </nav>

    <!-- Main content với padding-top để tránh chồng lấp navbar -->
    <div class="pt-20 p-6 container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Welcome, {{ Auth::user()->name }}!</h1>
        <p>Bạn đang đăng nhập với quyền <b>Admin</b>.</p>
        <div class="mt-6 space-x-4">
            <a href="{{ route('admin.users.create') }}" class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600">Create New User</a>
            <a href="{{ route('notifications.create') }}" class="bg-green-500 text-white px-6 py-3 rounded hover:bg-green-600">Thêm thông báo</a>
            <a href="{{ route('schedules.index') }}" class="bg-indigo-500 text-white px-6 py-3 rounded hover:bg-indigo-600">Quản lý lịch học</a>
        </div>
    </div>
</body>
</html>