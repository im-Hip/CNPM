<!-- Sidebar 1/5 -->

<div class="p-6 text-center border-b bg-white">
    <a href="{{ route('dashboard') }}" class="text-4xl font-bold text-gray-800 hover:text-blue-600 transition-colors">
        N9
    </a>

    <div class="mt-3 text-2xl font-semibold" style="color: #1e3a8a;">
        @if(Auth::user()->role === 'admin')
            Quản trị viên
        @elseif(Auth::user()->role === 'teacher')
            Giáo viên
        @elseif(Auth::user()->role === 'student')
            Học sinh
        @endif
    </div>

</div>

<nav class="flex-1 px-4 py-6">
    @php
        $currentRoute = request()->route()->getName();
    @endphp

    @if(Auth::user()->role === 'admin')
        <ul class="space-y-2">
            <!-- Trang chủ - Fix highlight condition -->
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ in_array($currentRoute, ['dashboard', 'notifications.index']) ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    <span class="font-medium">ㅤTrang chủ</span>
                </a>
            </li>
            
            <!-- Các menu items khác giữ nguyên -->
            <li>
                <a href="{{ route('admin.users.create') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($currentRoute, 'admin.users') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="font-medium">👥ㅤQuản lý người dùng</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('schedules.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($currentRoute, 'schedules') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="font-medium">📅ㅤQuản lý lịch học</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('subjects.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($currentRoute, 'subjects') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="font-medium">📚ㅤQuản lý môn học</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('assignments.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($currentRoute, 'assignments') && !str_contains($currentRoute, 'teacher_assignments') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="font-medium">📝ㅤQuản lý bài tập</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('teacher_assignments.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($currentRoute, 'teacher_assignments') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="font-medium">👨‍🏫ㅤPhân công giáo viên</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('notifications.create') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($currentRoute, 'notifications.create') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="font-medium">📢ㅤGửi thông báo</span>
                </a>
            </li>
        </ul>
    @endif

    @if(Auth::user()->role === 'teacher')
        <ul class="space-y-2">
            <!-- Menu cho Teacher - Fix tương tự -->
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ in_array($currentRoute, ['dashboard', 'notifications.index']) ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    <span class="font-medium">ㅤTrang chủ</span>
                </a>
            </li>
            <!-- Các menu items khác giữ nguyên -->
            <li>
                <a href="{{ route('schedules.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($currentRoute, 'schedules') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="font-medium">📅ㅤXem Lịch Dạy</span>
                </a>
            </li>
            <li>
                <a href="{{ route('assignments.create') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($currentRoute, 'assignments.create') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="font-medium">📝ㅤGiao Bài Tập</span>
                </a>
            </li>
            <li>
                <a href="{{ route('notifications.create') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($currentRoute, 'notifications.create') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="font-medium">📢ㅤGửi Thông Báo Lớp</span>
                </a>
            </li>
        </ul>
    @endif

    @if(Auth::user()->role === 'student')
        <ul class="space-y-2">
            <!-- Menu cho Student - Fix tương tự -->
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ in_array($currentRoute, ['dashboard', 'notifications.index']) ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    <span class="font-medium">ㅤTrang chủ</span>
                </a>
            </li>
            <!-- Các menu items khác giữ nguyên -->
            <li>
                <a href="{{ route('schedules.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($currentRoute, 'schedules') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="font-medium">📅ㅤXem Lịch Học</span>
                </a>
            </li>
            <li>
                <a href="{{ route('assignments.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($currentRoute, 'assignments') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="font-medium">📝ㅤXem Bài Tập</span>
                </a>
            </li>
            <li>
                <a href="{{ route('notifications.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ $currentRoute === 'notifications.index' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="font-medium">📢ㅤXem Thông Báo</span>
                </a>
            </li>
        </ul>
    @endif
</nav>

<!-- Phần footer sidebar giữ nguyên -->
<div class="absolute bottom-0 left-0 w-full p-4 border-t bg-white">
    <div class="px-4">
        <div class="font-semibold text-lg" style="color: #1e3a8a;">
            {{ Auth::user()->name }}
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-all duration-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="font-medium">ㅤĐăng xuất</span>
            </button>
        </form>
    </div>
</div>

<style>
    nav::-webkit-scrollbar {
        width: 6px;
    }
    
    nav::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    nav::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    
    nav::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>