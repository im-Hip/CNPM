<!-- Sidebar 1/5 -->

<div class="p-6 text-center border-b bg-white">
    <a href="{{ route('dashboard') }}" class="text-4xl font-bold text-blue-600 hover:text-blue-700 hover:scale-110 transition-all duration-300 inline-block">
        N9
    </a>

    <div class="mt-3 text-2xl font-semibold" style="color: #1e3a8a;">
        @if(Auth::user()->role === 'admin')
        <span class="inline-flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
            </svg>
            Quản trị viên
        </span>
        @elseif(Auth::user()->role === 'teacher')
        <span class="inline-flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
            </svg>
            Giáo viên
        </span>
        @elseif(Auth::user()->role === 'student')
        <span class="inline-flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            Học sinh
        </span>
        @endif
    </div>
</div>

<nav class="flex-1 px-4 py-6 overflow-y-auto">
    @php
    $currentRoute = request()->route()->getName();
    @endphp

    @if(Auth::user()->role === 'admin')
    <ul class="space-y-2">
        <!-- Trang chủ -->
        <li>
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ in_array($currentRoute, ['dashboard', 'notifications.index']) ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Trang chủ.png') }}"
                    alt="Trang chủ"
                    class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤTrang chủ</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.statistics') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ str_contains($currentRoute, 'admin.statistics') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Thống kê hệ thống.png') }}"
                    alt="Thống kê hệ thống"
                    class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤThống kê</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ str_contains($currentRoute, 'admin.users') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Quản lý người dùng.png') }}"
                    alt="Quản lý người dùng"
                    class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤQuản lý người dùng</span>
            </a>
        </li>

        <li>
            <a href="{{ route('schedules.index') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ str_contains($currentRoute, 'schedules') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Quản lý lịch học.png') }}"
                    alt="Quản lý lịch học"
                    class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤQuản lý lịch học</span>
            </a>
        </li>

        <li>
            <a href="{{ route('subjects.index') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ str_contains($currentRoute, 'subjects') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Quản lý môn học.png') }}"
                    alt="Quản lý môn học"
                    class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤQuản lý môn học</span>
            </a>
        </li>

        <li>
            <a href="{{ route('teacher_assignments.index') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ str_contains($currentRoute, 'teacher_assignments') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Phân công giáo viên.png') }}"
                    alt="Phân công giáo viên"
                    class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤPhân công giáo viên</span>
            </a>
        </li>

        <li>
            <a href="{{ route('notifications.create') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ str_contains($currentRoute, 'notifications.create') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Gửi thông báo.png') }}"
                    alt="Gửi thông báo"
                    class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤGửi thông báo</span>
            </a>
        </li>
    </ul>
    @endif

    @if(Auth::user()->role === 'teacher')
    <ul class="space-y-2">
        <li>
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ in_array($currentRoute, ['dashboard', 'notifications.index']) ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Trang chủ.png') }}"
                    alt="Trang chủ"
                    class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤTrang chủ</span>
            </a>
        </li>

        <li>
            <a href="{{ route('schedules.index') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ str_contains($currentRoute, 'schedules') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Quản lý lịch học.png') }}" 
             alt="Quản lý lịch học" 
             class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤXem Lịch Dạy</span>
            </a>
        </li>

        <li>
            <a href="{{ route('assignments.create') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ str_contains($currentRoute, 'assignments.create') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Quản lý bài tập.png') }}"
                    alt="Quản lý bài tập"
                    class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤGiao Bài Tập</span>
            </a>
        </li>

        <li>
            <a href="{{ route('notifications.create') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ str_contains($currentRoute, 'notifications.create') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Gửi thông báo.png') }}" 
             alt="Gửi thông báo" 
             class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤGửi Thông Báo Lớp</span>
            </a>
        </li>
    </ul>
    @endif

    @if(Auth::user()->role === 'student')
    <ul class="space-y-2">
        <li>
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ in_array($currentRoute, ['dashboard', 'notifications.index']) ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Trang chủ.png') }}"
                    alt="Trang chủ"
                    class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤTrang chủ</span>
            </a>
        </li>

        <li>
            <a href="{{ route('schedules.index') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ str_contains($currentRoute, 'schedules') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Quản lý lịch học.png') }}"
                    alt="Quản lý lịch học"
                    class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤXem Lịch Học</span>
            </a>
        </li>

        <li>
            <a href="{{ route('assignments.index') }}"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group relative overflow-hidden
                   {{ str_contains($currentRoute, 'assignments') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="absolute inset-0 w-full h-full transition-all duration-500 transform translate-x-[-100%] group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                <img src="{{ asset('images/Quản lý bài tập.png') }}"
                    alt="Quản lý bài tập"
                    class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium relative z-10">ㅤXem Bài Tập</span>
            </a>
        </li>
    </ul>
    @endif
</nav>

<!-- Phần footer sidebar -->
<div class="absolute bottom-0 left-0 w-full p-4 border-t bg-white">
    <div class="px-4">
        <div class="font-semibold text-lg flex items-center" style="color: #1e3a8a;">
            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            {{ Auth::user()->name }}
        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-2 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-lg transition-all duration-300 group">
                <img src="{{ asset('images/Đăng xuất.png') }}"
                    alt="Đăng xuất"
                    class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110 relative z-10">
                <span class="font-medium">ㅤĐăng xuất</span>
            </button>
        </form>
    </div>
</div>

<style>
    /* Scrollbar styling */
    nav::-webkit-scrollbar {
        width: 6px;
    }

    nav::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    nav::-webkit-scrollbar-thumb {
        background: #3b82f6;
        border-radius: 10px;
        transition: background 0.3s;
    }

    nav::-webkit-scrollbar-thumb:hover {
        background: #2563eb;
    }
</style>