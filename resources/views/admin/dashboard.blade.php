<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Thêm Vite để tải tài nguyên -->
</head>
<body>
    <div class="container mx-auto p-4"> <!-- Thêm container cho bố cục -->
        <h1 class="text-2xl mb-4">Welcome, Admin!</h1>
        <p>Bạn đang đăng nhập với quyền <b>Admin</b>.</p>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Create New User</a>
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="bg-red-500 text-white px-4 py-2 rounded">
           Đăng xuất
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="{{ route('schedules.index') }}" class="bg-green-500 text-white px-4 py-2 rounded mr-2 ml-3">Quản lý lịch học</a>
    </div>
</body>
</html>