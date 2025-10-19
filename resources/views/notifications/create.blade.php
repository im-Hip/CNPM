@extends('layouts.app')

@section('title', 'Gửi thông báo')

@section('content')

    <h1 class="text-3xl font-extrabold text-center pt-8" style="color: #1e3a8a;">
        Tạo thông báo
    </h1>

    <!-- Form -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm" style="padding: 2rem;">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" style="margin-bottom: 1.5rem;">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" style="margin-bottom: 1.5rem;">
                    {{ session('error') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" style="margin-bottom: 1.5rem;">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form gửi thông báo -->
            <form action="{{ route('notifications.store') }}" method="POST">
                @csrf
                
                <!-- Tiêu đề thông báo -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="title" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Tiêu đề <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('title') border-red-500 @enderror" 
                           style="padding: 0.5rem 1rem;"
                           placeholder="Nhập tiêu đề thông báo"
                           value="{{ old('title') }}"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Nội dung -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="content" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Nội dung <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" 
                              id="content" 
                              rows="4"
                              class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('content') border-red-500 @enderror" 
                              style="padding: 0.5rem 1rem;"
                              placeholder="Nhập nội dung thông báo"
                              required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Loại thông báo -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="type" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Loại thông báo <span class="text-red-500">*</span>
                    </label>
                    <select name="type" 
                            id="type" 
                            class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('type') border-red-500 @enderror" 
                            style="padding: 0.5rem 1rem;"
                            required>
                        <option value="">-- Chọn loại thông báo --</option>
                        <option value="exam" {{ old('type') == 'exam' ? 'selected' : '' }}>Kiểm tra/Thi</option>
                        <option value="assignment" {{ old('type') == 'assignment' ? 'selected' : '' }}>Bài tập</option>
                        <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Sự kiện</option>
                        <option value="warning" {{ old('type') == 'warning' ? 'selected' : '' }}>Cảnh báo</option>
                        <option value="scholarship" {{ old('type') == 'scholarship' ? 'selected' : '' }}>Học bổng</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Đối tượng nhận -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="recipient_type" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Gửi đến <span class="text-red-500">*</span>
                    </label>
                    <select name="recipient_type" 
                            id="recipient_type" 
                            class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('recipient_type') border-red-500 @enderror" 
                            style="padding: 0.5rem 1rem;"
                            required 
                            onchange="toggleRecipientField()">
                        @if (Auth::user()->role === 'admin')
                            <option value="">-- Chọn đối tượng --</option>
                            <option value="all" {{ old('recipient_type') == 'all' ? 'selected' : '' }}>Tất cả (GV & HS)</option>
                            <option value="teachers" {{ old('recipient_type') == 'teachers' ? 'selected' : '' }}>Tất cả Giáo viên</option>
                            <option value="students" {{ old('recipient_type') == 'students' ? 'selected' : '' }}>Tất cả Học sinh</option>
                            <option value="class" {{ old('recipient_type') == 'class' ? 'selected' : '' }}>Theo lớp</option>
                            <option value="individual" {{ old('recipient_type') == 'individual' ? 'selected' : '' }}>Cá nhân</option>
                        @elseif (Auth::user()->role === 'teacher')
                            <option value="">-- Chọn lớp --</option>
                            <option value="class" {{ old('recipient_type') == 'class' ? 'selected' : '' }}>Lớp học</option>
                        @endif
                    </select>
                    @error('recipient_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Chi tiết đối tượng nhận -->
                <div id="recipient_field" style="display: none; margin-bottom: 1.5rem;">
                    <label for="recipient_id" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Chọn cụ thể <span class="text-red-500">*</span>
                    </label>
                    
                    <!-- Chọn lớp -->
                    <div id="class_select" style="display: none;">
                        <select name="class_id" 
                                id="recipient_id" 
                                class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('recipient_id') border-red-500 @enderror"
                                style="padding: 0.5rem 1rem;">
                            <option value="">-- Chọn lớp --</option>
                            @foreach ($classes as $class)
                                @if ($class)
                                    <option value="{{ $class->id }}" {{ old('recipient_id') == $class->id ? 'selected' : '' }}>
                                        Lớp {{ $class->name ?? $class->id }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Tìm kiếm cá nhân (chỉ cho admin) -->
                    @if (Auth::user()->role === 'admin')
                    <div id="individual_search" style="display: none;">
                        <input type="text" 
                               id="recipient_search" 
                               class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               style="padding: 0.5rem 1rem;"
                               placeholder="Tìm kiếm theo email..." 
                               oninput="searchRecipient()">
                        <input type="hidden" name="recipient_id" id="recipient_id_individual">
                        <div id="suggestions" 
                             class="border border-gray-300 rounded-md mt-1 max-h-40 overflow-y-auto bg-white" 
                             style="display: none;"></div>
                    </div>
                    @endif
                </div>
                
                <!-- Button -->
                <div style="margin-top: 2rem;" class="flex justify-end space-x-4">
    <a href="{{ route('notifications.index') }}" 
       class="text-white font-bold rounded transition-colors"
       style="background-color: #2563eb; padding: 0.7rem; min-width: 100px; display: inline-block; text-align: center; text-decoration: none;">
        Hủy
    </a>
    <button type="submit" 
            class="text-white font-bold rounded transition-colors"
            style="background-color: #2563eb; padding: 0.7rem; min-width: 100px; display: inline-block;">
        Gửi
    </button>
</div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let previousType = '';

        function toggleRecipientField() {
            const recipientType = document.getElementById('recipient_type').value;
            const recipientField = document.getElementById('recipient_field');
            const classSelect = document.getElementById('class_select');
            const individualSearch = document.getElementById('individual_search');
            const classSelectElement = document.getElementById('recipient_id_class');
            const individualHidden = document.getElementById('recipient_id_individual');
            const individualDiv = document.getElementById('recipient_search');

            if (recipientType === 'all' || recipientType === 'teachers' || recipientType === 'students' || recipientType === '') {
                recipientField.style.display = 'none';
                classSelect.style.display = 'none';
                if (individualSearch) individualSearch.style.display = 'none';
                individualDiv.removeAttribute('required');
            } else {
                recipientField.style.display = 'block';
                if (recipientType === 'class') {
                    classSelect.style.display = 'block';
                    if (individualSearch) individualSearch.style.display = 'none';
                    if (previousType === 'individual' && individualHidden) {
                        individualHidden.value = '';
                    }
                    individualDiv.removeAttribute('required');
                } else if (recipientType === 'individual') {
                    classSelect.style.display = 'none';
                    if (individualSearch) individualSearch.style.display = 'block';
                    if (previousType === 'class' && classSelectElement) {
                        classSelectElement.value = '';
                    }
                    if (individualHidden) {
                        individualHidden.value = '';
                    }
                    document.getElementById('recipient_search').value = '';
                    document.getElementById('suggestions').style.display = 'none';
                    individualDiv.setAttribute('required', 'required');
                }
            }
            previousType = recipientType;
        }

        function searchRecipient() {
            const search = document.getElementById('recipient_search').value;
            if (search.length < 2) {
                document.getElementById('suggestions').style.display = 'none';
                return;
            }
            const suggestions = document.getElementById('suggestions');
            suggestions.style.display = 'block';
            suggestions.innerHTML = 'Đang tìm...';

            axios.get('/search-recipients', {
                params: { search: search }
            }).then(response => {
                suggestions.innerHTML = '';
                response.data.forEach(item => {
                    const div = document.createElement('div');
                    div.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-200');
                    div.textContent = item.email;
                    div.onclick = function () {
                        document.getElementById('recipient_search').value = item.email;
                        document.getElementById('recipient_id_individual').value = item.id;
                        suggestions.style.display = 'none';
                    };
                    suggestions.appendChild(div);
                });
                if (response.data.length === 0) suggestions.innerHTML = '<div class="p-2 text-gray-500">Không tìm thấy</div>';
            }).catch(error => {
                suggestions.innerHTML = '<div class="p-2 text-red-500">Lỗi khi tìm kiếm</div>';
            });
        }

        // Khởi tạo
        toggleRecipientField();
    </script>

    <!-- Styles -->
    <style>
        #suggestions > div:hover {
            background-color: #f3f4f6;
        }
    </style>
@endsection