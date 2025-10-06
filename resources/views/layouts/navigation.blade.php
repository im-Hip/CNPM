<!-- Header của Sidebar -->
<div class="p-4 text-center font-bold text-xl border-b bg-white">
    <a href="{{ route('dashboard') }}" class="text-gray-800 hover:text-blue-600 transition-colors">
        N9
    </a>
</div>

<!-- Menu điều hướng chính -->
<nav class="p-4">
    @if(Auth::user()->role === 'admin')
        <h3 class="font-bold text-gray-500 uppercase text-xs mb-2">Quản trị viên</h3>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.users.create') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ml-3">Quản lý Người dùng</span>
                </a>
            </li>
            <li>
                <a href="{{ route('schedules.index') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ml-3">Quản lý lịch học</span>
                </a>
            </li>
            <li>
                <a href="{{ route('teacher_assignments.index') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ml-3">Phân công Giáo viên</span>
                </a>
            </li>
            <li>
                <a href="{{ route('assignments.index') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ml-3">Quản lý Bài tập</span>
                </a>
            </li>
            <li>
                <a href="{{ route('notifications.create') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ml-3">Gửi thông báo</span>
                </a>
            </li>
        </ul>
    @endif

    
    @if(Auth::user()->role === 'teacher')
        <h3 class="font-bold text-gray-500 uppercase text-xs mb-2 mt-4">Giáo viên</h3>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('schedules.index') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ml-3">Xem Lịch Dạy</span>
                </a>
            </li>
            <li>
                <a href="{{ route('assignments.create') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ml-3">Giao Bài Tập</span>
                </a>
            </li>
            <li>
                <a href="{{ route('notifications.create') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ml-3">Gửi Thông Báo Lớp</span>
                </a>
            </li>
        </ul>
    @endif

    
    @if(Auth::user()->role === 'student')
        <h3 class="font-bold text-gray-500 uppercase text-xs mb-2 mt-4">Học sinh</h3>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('schedules.index') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ml-3">Xem Lịch Học</span>
                </a>
            </li>
            <li>
                <a href="{{ route('assignments.index') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ml-3">Xem Bài Tập</span>
                </a>
            </li>
             <li>
                <a href="{{ route('notifications.index') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ml-3">Xem Thông Báo</span>
                </a>
            </li>
        </ul>
    @endif

</nav>

<!-- Thông tin người dùng và nút Đăng xuất (luôn ở dưới cùng) -->
<div class="absolute bottom-0 left-0 w-full p-4 border-t bg-white">
    <div class="font-semibold">{{ Auth::user()->name }}</div>
    <div class="text-sm text-gray-500 capitalize">{{ Auth::user()->role }}</div>
    <!-- Logout Form -->
    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit" class="w-full text-left p-2 rounded-lg text-red-600 hover:bg-red-50 font-semibold transition-colors">
            Đăng xuất
        </button>
    </form>
</div>