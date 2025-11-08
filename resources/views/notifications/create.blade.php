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
                    
                    <!-- Tìm kiếm cá nhân (cho admin) -->
                    @if (Auth::user()->role === 'admin')
                    <div id="individual_search" style="display: none;">
                        <input type="text" 
                               id="recipient_search" 
                               class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               style="padding: 0.5rem 1rem;"
                               placeholder="Nhập email để tìm kiếm..." 
                               oninput="searchRecipient()">
                        <input type="hidden" name="recipient_id" id="recipient_id_individual">

                        <!-- Dropdown gợi ý email -->
                        <div id="suggestions" 
                             class="border border-gray-300 rounded-md mt-1 max-h-40 overflow-y-auto bg-white shadow-lg" 
                             style="display: none;"></div>

                        <!-- Hiển thị thông tin người dùng -->
                        <div id="user_info" 
                             class="mt-3 p-4 border rounded-md bg-blue-50 border-blue-200" 
                             style="display: none;">
                            <h4 class="font-bold text-blue-800 mb-2">Thông tin người nhận:</h4>
                            <div id="user_details" class="text-gray-700"></div>
                        </div>

                        <!-- Thông báo lỗi -->
                        <div id="search_error" 
                             class="mt-3 p-3 border rounded-md bg-red-50 border-red-200 text-red-700" 
                             style="display: none;">
                        </div>
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
            const search = document.getElementById('recipient_search').value.trim();
            const suggestions = document.getElementById('suggestions');
            const userInfo = document.getElementById('user_info');
            const userDetails = document.getElementById('user_details');
            const searchError = document.getElementById('search_error');
            const recipientIdInput = document.getElementById('recipient_id_individual');

            // Reset các thông báo
            userInfo.style.display = 'none';
            searchError.style.display = 'none';

            // Nếu input rỗng
            if (search.length === 0) {
                suggestions.style.display = 'none';
                recipientIdInput.value = '';
                return;
            }

            // Nếu quá ngắn, ẩn suggestions
            if (search.length < 2) {
                suggestions.style.display = 'none';
                return;
            }

            // Hiển thị loading
            suggestions.style.display = 'block';
            suggestions.innerHTML = '<div class="p-2 text-gray-500">Đang tìm...</div>';

            // Gọi API
            axios.get('/search-recipients', {
                params: { search: search }
            }).then(response => {
                const data = response.data;

                // Xử lý gợi ý (khi gõ chưa đủ email)
                if (data.type === 'suggestions') {
                    suggestions.innerHTML = '';

                    if (data.data.length === 0) {
                        suggestions.innerHTML = '<div class="p-2 text-gray-500">Không tìm thấy</div>';
                    } else {
                        data.data.forEach(item => {
                            const div = document.createElement('div');
                            div.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-100', 'border-b', 'last:border-b-0');
                            div.innerHTML = `
                                <div class="font-semibold text-gray-800">${item.email}</div>
                                <div class="text-sm text-gray-500">${item.name}</div>
                            `;
                            div.onclick = function() {
                                document.getElementById('recipient_search').value = item.email;
                                suggestions.style.display = 'none';
                                // Tự động tìm chi tiết sau khi chọn
                                setTimeout(() => searchRecipient(), 100);
                            };
                            suggestions.appendChild(div);
                        });
                    }
                } 
                // Xử lý chi tiết người dùng (khi gõ đủ email)
                else if (data.type === 'detail') {
                    suggestions.style.display = 'none';

                    if (data.found && data.user) {
                        const user = data.user;
                        recipientIdInput.value = user.id;

                        let infoHTML = '';
                        if (user.role === 'teacher') {
                            infoHTML = `
                                <p><strong>Mã GV:</strong> ${user.teacher_id}</p>
                                <p><strong>Họ tên:</strong> ${user.name}</p>
                                <p><strong>Môn:</strong> ${user.subject}</p>
                                <p><strong>Email:</strong> ${user.email}</p>
                            `;
                        } else if (user.role === 'student') {
                            infoHTML = `
                                <p><strong>Mã HS:</strong> ${user.student_id}</p>
                                <p><strong>Họ tên:</strong> ${user.name}</p>
                                <p><strong>Lớp:</strong> ${user.class}</p>
                                <p><strong>Email:</strong> ${user.email}</p>
                            `;
                        }

                        userDetails.innerHTML = infoHTML;
                        userInfo.style.display = 'block';
                    } else {
                        recipientIdInput.value = '';
                        searchError.textContent = data.message || 'Không tìm thấy người dùng';
                        searchError.style.display = 'block';
                    }
                }
            }).catch(error => {
                suggestions.style.display = 'none';
                searchError.textContent = 'Lỗi khi tìm kiếm. Vui lòng thử lại!';
                searchError.style.display = 'block';
                console.error('Search error:', error);
            });
        }

        // Đóng suggestions khi click ra ngoài
        document.addEventListener('click', function(event) {
            const searchInput = document.getElementById('recipient_search');
            const suggestions = document.getElementById('suggestions');

            if (searchInput && suggestions && 
                !searchInput.contains(event.target) && 
                !suggestions.contains(event.target)) {
                suggestions.style.display = 'none';
            }
        });

        // Khởi tạo
        toggleRecipientField();
    </script>

    <!-- Styles -->
    <style>
        #suggestions > div:hover {
            background-color: #f3f4f6;
        }
        
        #suggestions {
            position: relative;
            z-index: 10;
        }
        
        #user_info p {
            margin-bottom: 0.5rem;
            line-height: 1.5;
        }
        
        #user_info p:last-child {
            margin-bottom: 0;
        }
        
        #user_info strong {
            color: #1e40af;
            min-width: 80px;
            display: inline-block;
        }
    </style>
@endsection