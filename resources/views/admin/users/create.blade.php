@extends('layouts.app')

@section('title', 'Quản lý người dùng')

@section('content')
    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-4 text-center px-4" style="color: #1e3a8a;">
        HỆ THỐNG QUẢN LÝ LỊCH HỌC VÀ THÔNG BÁO CHO HỌC SINH
    </h1>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="height: calc(100vh - 200px); display: flex; flex-direction: column;">
        

        <div class="bg-blue-600 px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center text-white">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
                <span class="text-base sm:text-lg font-semibold">Tạo người dùng mới</span>
            </div>
        </div>


        <div class="flex-1 overflow-y-auto p-4 sm:p-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form tạo user -->
            <form action="{{ route('admin.users.store') }}" method="POST" onsubmit="return validateForm()" class="max-w-2xl mx-auto">
                @csrf
                
                
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h2 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Thông tin cơ bản</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                            <input type="text" name="name" id="name" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   required>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   required>
                        </div>
                        
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                            <input type="password" name="password" id="password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   required minlength="8">
                            <p class="text-xs text-gray-500 mt-1">Mật khẩu tối thiểu 8 ký tự</p>
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   required>
                            <p id="confirm-hint" class="text-xs text-red-500 mt-1" style="display: none;">Mật khẩu không khớp</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Vai trò</label>
                        <select name="role" id="role" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                required>
                            <option value="">-- Chọn vai trò --</option>
                            <option value="teacher">Giáo viên</option>
                            <option value="student">Học sinh</option>
                        </select>
                    </div>
                </div>

                <!-- Thông tin GV -->
                <div id="teacher-fields" class="hidden bg-blue-50 rounded-lg p-4 mb-6">
                    <h2 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Thông tin Giáo viên</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">Mã giáo viên</label>
                            <input type="text" name="teacher_id" id="teacher_id"
                                   value="{{ $newTeacherId ?? '' }}"
                                   readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
                        </div>
                        
                        <div>
                            <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Môn học</label>
                            <select name="subject_id" id="subject_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Chọn môn học --</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Trình độ</label>
                            <select name="level" id="level" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Chọn trình độ --</option>
                                <option value="Master">Thạc sĩ</option>
                                <option value="Bachelor">Cử nhân</option>
                                <option value="PhD">Tiến sĩ</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Thông tin HS -->
                <div id="student-fields" class="hidden bg-green-50 rounded-lg p-4 mb-6">
                    <h2 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Thông tin Học sinh</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Mã học sinh</label>
                            <input type="text" name="student_id" id="student_id"
                                   value="{{ $newStudentId ?? '' }}"
                                   readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
                        </div>
                        
                        <div>
                            <label for="day_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Ngày sinh</label>
                            <input type="date" name="day_of_birth" id="day_of_birth" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Giới tính</label>
                            <select name="gender" id="gender" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Chọn giới tính --</option>
                                <option value="male">Nam</option>
                                <option value="female">Nữ</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Lớp</label>
                            <select name="class_id" id="class_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Chọn lớp --</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Nút submit -->
                <div class="flex justify-center mt-6">
                    <button type="submit" 
                    class="flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                        </svg>
                        Tạo người dùng
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script -->
    <script>
        // Ẩn/hiện input theo vai trò
        const roleSelect = document.getElementById('role');
        const teacherFields = document.getElementById('teacher-fields');
        const studentFields = document.getElementById('student-fields');

        roleSelect.addEventListener('change', function() {
            const role = this.value;

            // Ẩn/hiện các phần
            teacherFields.classList.toggle('hidden', role !== 'teacher');
            studentFields.classList.toggle('hidden', role !== 'student');

            // Lấy tất cả input/select trong mỗi nhóm
            const teacherInputs = teacherFields.querySelectorAll('input, select');
            const studentInputs = studentFields.querySelectorAll('input, select');

            // Gỡ required khỏi tất cả
            teacherInputs.forEach(el => el.removeAttribute('required'));
            studentInputs.forEach(el => el.removeAttribute('required'));

            // Gắn lại required cho đúng nhóm
            if (role === 'teacher') {
                teacherInputs.forEach(el => el.setAttribute('required', true));
            } else if (role === 'student') {
                studentInputs.forEach(el => el.setAttribute('required', true));
            }
        });

        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const confirmHint = document.getElementById('confirm-hint');

            if (password !== confirmPassword) {
                confirmHint.style.display = 'block';
                return false;
            } else {
                confirmHint.style.display = 'none';
                return true;
            }
        }

        // check realtime khi nhập
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const confirmHint = document.getElementById('confirm-hint');

            if (password !== confirmPassword && confirmPassword !== '') {
                confirmHint.style.display = 'block';
            } else {
                confirmHint.style.display = 'none';
            }
        });
    </script>

    <style>
        /* Scrollbar styling */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endsection