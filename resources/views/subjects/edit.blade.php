@extends('layouts.app')

@section('title', 'Sửa môn học')

@section('content')

    <h1 class="text-3xl font-extrabold text-center pt-8" style="color: #1e3a8a;">
        Sửa môn học
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

            <!-- Form sửa môn học -->
            <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Tên môn học -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="name" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Tên môn học <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror" 
                           style="padding: 0.5rem 1rem;"
                           placeholder="Nhập tên môn học (VD: Toán, Văn, Anh...)"
                           value="{{ old('name', $subject->name) }}"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Mã môn học -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="subject_id" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Mã môn học <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="subject_id" 
                           id="subject_id" 
                           class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('subject_id') border-red-500 @enderror" 
                           style="padding: 0.5rem 1rem;"
                           placeholder="Nhập mã môn học (VD: TOAN10, VAN11...)"
                           value="{{ old('subject_id', $subject->subject_id) }}"
                           required>
                    @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Số tiết/tuần -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="number_of_periods" class="block text-sm font-extrabold text-gray-800" style="margin-bottom: 0.5rem;">
                        Số tiết/tuần <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="number_of_periods" 
                           id="number_of_periods" 
                           class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('number_of_periods') border-red-500 @enderror" 
                           style="padding: 0.5rem 1rem;"
                           placeholder="Nhập số tiết (1-5)"
                           value="{{ old('number_of_periods', $subject->number_of_periods) }}"
                           min="1" 
                           max="5" 
                           required>
                    <p class="mt-1 text-xs text-gray-500">Nhập số tiết học trong 1 tuần (từ 1 đến 5)</p>
                    @error('number_of_periods')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Buttons -->
                <div style="margin-top: 2rem;" class="flex justify-end space-x-4">
                    <a href="{{ route('subjects.index') }}" 
                       class="text-white font-bold rounded transition-colors hover:opacity-90"
                       style="background-color: #2563eb; padding: 0.7rem; min-width: 100px; display: inline-block; text-align: center; text-decoration: none;">
                        Hủy
                    </a>
                    <button type="submit" 
                            class="text-white font-bold rounded transition-colors hover:opacity-90"
                            style="background-color: #2563eb; padding: 0.7rem; min-width: 150px; display: inline-block;">
                        Sửa môn học
                    </button>
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

        /* Smooth transitions */
        input:focus, select:focus, textarea:focus {
            transition: all 0.2s ease-in-out;
        }

        button:hover, a:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>

@endsection