@extends('layouts.app')

@section('title', 'Giao bài tập')

@section('content')

    <h1 class="text-3xl font-extrabold text-center pt-8" style="color: #1e3a8a;">
        Tạo bài tập
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

            <!-- Form giao bài tập -->
            <form action="{{ route('assignments.store') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="title" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Tiêu đề bài tập <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('title') border-red-500 @enderror" 
                           style="padding: 0.5rem 1rem;"
                           placeholder="Nhập tiêu đề bài tập (VD: Bài tập về nhà tuần 1)"
                           value="{{ old('title') }}"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="content" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Nội dung bài tập <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" 
                              id="content" 
                              rows="5"
                              class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('content') border-red-500 @enderror" 
                              style="padding: 0.5rem 1rem;"
                              placeholder="Nhập nội dung chi tiết bài tập..."
                              required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="due_date" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Ngày hết hạn <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" 
                           name="due_date" 
                           id="due_date" 
                           class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('due_date') border-red-500 @enderror" 
                           style="padding: 0.5rem 1rem;"
                           min="{{ now()->format('Y-m-d\TH:i') }}"
                           max="2030-12-31T23:59"
                           value="{{ old('due_date') }}"
                           required>
                    <p class="mt-1 text-xs text-gray-500">Chọn ngày và giờ hết hạn nộp bài</p>
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                @if (Auth::user()->role === 'admin' || Auth::user()->role === 'teacher')
                    <div style="margin-bottom: 1.5rem;">
                        <label for="class_id" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                            Lớp học <span class="text-red-500">*</span>
                        </label>
                        <select name="class_id" 
                                id="class_id" 
                                class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('class_id') border-red-500 @enderror" 
                                style="padding: 0.5rem 1rem;"
                                required>
                            <option value="">-- Chọn lớp --</option>
                            
                            @if (Auth::user()->role === 'teacher' && optional(Auth::user()->teacher)->teacherAssignments && Auth::user()->teacher->teacherAssignments->isNotEmpty())
                                @foreach (Auth::user()->teacher->teacherAssignments as $teacherAssignment)
                                    <option value="{{ $teacherAssignment->class_id }}" {{ old('class_id') == $teacherAssignment->class_id ? 'selected' : '' }}>
                                        Lớp {{ $teacherAssignment->class->name }}
                                    </option>
                                @endforeach
                            @elseif (Auth::user()->role === 'teacher')
                                <option disabled>Chưa có lớp nào được phân công</option>
                            @else
                                {{-- Admin thấy tất cả lớp --}}
                                @foreach (\App\Models\Classes::all() as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        Lớp {{ $class->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('class_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
                
                <div style="margin-top: 2rem;" class="flex space-x-4">
                    <button type="submit" 
                            class="text-white font-bold rounded transition-colors hover:opacity-90"
                            style="background-color: #2563eb; padding: 0.7rem; min-width: 120px; display: inline-block;">
                        Tạo bài tập
                    </button>
                    <a href="{{ route('assignments.index') }}" 
                       class="text-white font-bold rounded transition-colors hover:opacity-90"
                       style="background-color: #16a34a; padding: 0.7rem; min-width: 150px; display: inline-block; text-align: center; text-decoration: none;">
                        Xem bài tập đã tạo
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Responsive Styles -->
    <style>
        @media (max-width: 640px) {
            h1 {
                font-size: 1.75rem;
                padding-top: 1.5rem;
            }
            
            .max-w-2xl {
                padding: 0 1rem;
            }
            
            .bg-white {
                padding: 1.5rem !important;
            }
            
            .flex.space-x-4 {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .flex.space-x-4 a,
            .flex.space-x-4 button {
                width: 100%;
            }
        }

        input:focus, select:focus, textarea:focus {
            transition: all 0.2s ease-in-out;
        }

        button:hover, a:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            filter: brightness(0) saturate(100%) invert(27%) sepia(87%) saturate(2373%) hue-rotate(217deg) brightness(91%) contrast(92%);
        }
    </style>

@endsection