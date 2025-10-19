@extends('layouts.app')

@section('title', 'Phân công giáo viên')

@section('content')

    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-center pt-4 sm:pt-6 lg:pt-8" 
        style="color: #1e3a8a;">
        Phân Công Giáo Viên Mới
    </h1>

    <div class="max-w-xl sm:max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm mt-6 p-6 sm:p-8">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('teacher_assignments.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="teacher_id" 
                           class="block text-sm font-extrabold text-gray-800 mb-2">
                        Giáo viên <span class="text-red-500">*</span>
                    </label>
                    <select name="teacher_id" 
                            id="teacher_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required>
                        <option value="">-- Chọn giáo viên --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" 
                                    {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user->name ?? 'GV ' . $teacher->id }} 
                                ({{ $teacher->subject->name ?? 'Chưa phân môn' }})
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="class_id" 
                           class="block text-sm font-extrabold text-gray-800 mb-2">
                        Lớp học <span class="text-red-500">*</span>
                    </label>
                    <select name="class_id" 
                            id="class_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required>
                        <option value="">-- Chọn lớp --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" 
                                    {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="subject_id" 
                           class="block text-sm font-extrabold text-gray-800 mb-2">
                        Môn học <span class="text-red-500">*</span>
                    </label>
                    <select name="subject_id" 
                            id="subject_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required>
                        <option value="">-- Chọn môn học --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" 
                                    {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="note" 
                           class="block text-sm font-extrabold text-gray-800 mb-2">
                        Ghi chú
                    </label>
                    <textarea name="note" 
                              id="note"
                              rows="3"
                              maxlength="255"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                              placeholder="Nhập ghi chú (không bắt buộc)">{{ old('note') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Tối đa 255 ký tự</p>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Lưu ý:</strong> Mỗi lớp chỉ có thể phân công 1 giáo viên cho 1 môn học. 
                                Hệ thống sẽ tự động kiểm tra và thông báo nếu có trùng lặp.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-8" style="gap: 1rem;">
                    <a href="{{ route('teacher_assignments.index') }}" 
                        style="background-color: #2563eb; padding: 12px 26px; color: white; font-weight: 600; border-radius: 8px; text-decoration: none; display: inline-block; transition: all 0.2s;"
                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                        onmouseout="this.style.backgroundColor='#2563eb'">
                        Hủy
                    </a>
                    <button type="submit" 
                        style="background-color: #2563eb; padding: 12px 26px; color: white; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                        onmouseout="this.style.backgroundColor='#2563eb'">
                        Phân công
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('teacher_id')?.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                console.log('Giáo viên được chọn:', selectedOption.text);
            }
        });

        const form = document.querySelector('form');
        form?.addEventListener('submit', function(e) {
            const teacher = document.getElementById('teacher_id').value;
            const classId = document.getElementById('class_id').value;
            const subject = document.getElementById('subject_id').value;
            
            if (!teacher || !classId || !subject) {
                e.preventDefault();
                alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
            }
        });
    </script>

    <style>
        @media (max-width: 640px) {
            .max-w-2xl {
                max-width: 100%;
            }
            
            .flex.justify-end {
                flex-direction: column-reverse;
            }
            
            .flex.justify-end > * {
                width: 100%;
                text-align: center;
            }
        }

        select:focus, textarea:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        button:hover, a.bg-blue-600:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        * {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
@endsection