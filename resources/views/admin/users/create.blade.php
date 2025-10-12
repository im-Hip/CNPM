@extends('layouts.app')

@section('title', 'Quản lý người dùng')

@section('content')

    <h1 class="text-3xl font-extrabold text-center pt-8" style="color: #1e3a8a;">
        Tạo người dùng mới
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

            <!-- form tạo user -->
            <form action="{{ route('admin.users.store') }}" method="POST" onsubmit="return validateForm()">
                @csrf
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="name" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Tên <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                           style="padding: 0.5rem 1rem;"
                           placeholder="Nhập họ và tên"
                           required>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="email" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                           style="padding: 0.5rem 1rem;"
                           placeholder="Nhập email"
                           required>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="password" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Mật khẩu <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                           style="padding: 0.5rem 1rem;"
                           placeholder="Nhập mật khẩu"
                           required 
                           minlength="8">
                    <p class="text-xs text-gray-500 mt-1">Mật khẩu tối thiểu 8 ký tự</p>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="password_confirmation" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Xác nhận mật khẩu <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                           style="padding: 0.5rem 1rem;"
                           placeholder="Nhập lại mật khẩu"
                           required>
                    <p id="confirm-hint" class="text-xs text-red-500 mt-1" style="display: none;">
                        Mật khẩu không khớp
                    </p>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="role" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Vai trò <span class="text-red-500">*</span>
                    </label>
                    <select name="role" 
                            id="role" 
                            class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                            style="padding: 0.5rem 1rem;"
                            required>
                        <option value="">-- Chọn vai trò --</option>
                        <option value="teacher">Giáo viên</option>
                        <option value="student">Học sinh</option>
                    </select>
                </div>

                <!-- Thông tin GV -->
                <div id="teacher-fields" class="hidden">
                    <div class="border-t border-gray-200" style="padding-top: 1.5rem; margin-bottom: 1.5rem;">
                        <h3 class="text-lg font-bold text-gray-700" style="margin-bottom: 1rem;">Thông tin Giáo viên</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="teacher_id" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                                    Mã giáo viên <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="teacher_id" 
                                       id="teacher_id"
                                       value="{{ $newTeacherId ?? '' }}"
                                       readonly
                                       class="w-full border border-gray-300 rounded-md bg-gray-50"
                                       style="padding: 0.5rem 1rem;">
                            </div>
                            
                            <div>
                                <label for="subject_id" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                                    Môn học <span class="text-red-500">*</span>
                                </label>
                                <select name="subject_id" 
                                        id="subject_id" 
                                        class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        style="padding: 0.5rem 1rem;">
                                    <option value="">-- Chọn môn học --</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="level" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                                    Trình độ <span class="text-red-500">*</span>
                                </label>
                                <select name="level" 
                                        id="level" 
                                        class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        style="padding: 0.5rem 1rem;">
                                    <option value="">-- Chọn trình độ --</option>
                                    <option value="Master">Thạc sĩ</option>
                                    <option value="Bachelor">Cử nhân</option>
                                    <option value="PhD">Tiến sĩ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin HS -->
                <div id="student-fields" class="hidden">
                    <div class="border-t border-gray-200" style="padding-top: 1.5rem; margin-bottom: 1.5rem;">
                        <h3 class="text-lg font-bold text-gray-700" style="margin-bottom: 1rem;">Thông tin Học sinh</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="student_id" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                                    Mã học sinh <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="student_id" 
                                       id="student_id"
                                       value="{{ $newStudentId ?? '' }}"
                                       readonly
                                       class="w-full border border-gray-300 rounded-md bg-gray-50"
                                       style="padding: 0.5rem 1rem;">
                            </div>
                            
                            <div>
                                <label for="day_of_birth" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                                    Ngày sinh <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="day_of_birth" 
                                       id="day_of_birth" 
                                       class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                       style="padding: 0.5rem 1rem;">
                            </div>
                            
                            <div>
                                <label for="gender" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                                    Giới tính <span class="text-red-500">*</span>
                                </label>
                                <select name="gender" 
                                        id="gender" 
                                        class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        style="padding: 0.5rem 1rem;">
                                    <option value="">-- Chọn giới tính --</option>
                                    <option value="male">Nam</option>
                                    <option value="female">Nữ</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="class_id" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                                    Lớp <span class="text-red-500">*</span>
                                </label>
                                <select name="class_id" 
                                        id="class_id" 
                                        class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        style="padding: 0.5rem 1rem;">
                                    <option value="">-- Chọn lớp --</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button -->
                <div style="margin-top: 2rem;">
                    <button type="submit" 
                            class="text-white font-bold rounded transition-colors"
                            style="background-color: #2563eb; padding: 0.7rem; min-width: 100px; display: inline-block;">
                        Tạo
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <script>
        const roleSelect = document.getElementById('role');
        const teacherFields = document.getElementById('teacher-fields');
        const studentFields = document.getElementById('student-fields');

        roleSelect.addEventListener('change', function() {
            const role = this.value;
            teacherFields.classList.toggle('hidden', role !== 'teacher');
            studentFields.classList.toggle('hidden', role !== 'student');

            const teacherInputs = teacherFields.querySelectorAll('input:not([readonly]), select');
            const studentInputs = studentFields.querySelectorAll('input:not([readonly]), select');

            teacherInputs.forEach(el => el.removeAttribute('required'));
            studentInputs.forEach(el => el.removeAttribute('required'));

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
        button[type="submit"]:hover {
            background-color: #1d4ed8 !important;
        }
    </style>
@endsection