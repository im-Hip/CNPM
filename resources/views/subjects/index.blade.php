@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-6 text-left lg:text-left" 
        style="color: #1e3a8a;">
        Danh sách môn học
    </h1>
    
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('subjects.create') }}" 
           class="inline-block px-6 py-3 rounded-lg text-white font-semibold
                  duration-200 transform hover:scale-105
                  text-sm sm:text-base"
           style="background-color: #1d4ed8; hover:background-color: #1e40af;">
            <span class="flex items-center">
                Thêm môn học
            </span>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Desktop View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr style="background-color: #e5e7eb;">
                        <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                            style="color: #1e3a8a; background-color: #e5e7eb;">
                            STT
                        </th>
                        <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                            style="color: #1e3a8a; background-color: #e5e7eb;">
                            TÊN MÔN HỌC
                        </th>
                        <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                            style="color: #1e3a8a; background-color: #e5e7eb;">
                            MÃ MÔN
                        </th>
                        <th class="px-6 py-4 text-center text-sm lg:text-base font-bold tracking-wider"
                            style="color: #1e3a8a; background-color: #e5e7eb;">
                            SỐ TIẾT/TUẦN
                        </th>
                        <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                            style="color: #1e3a8a; background-color: #e5e7eb;">
                            TUỲ CHỈNH
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($subjects as $subject)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base font-medium"
                                style="color: #1e3a8a;">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base font-medium"
                                style="color: #1e3a8a;">
                                {{ $subject->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base font-medium"
                                style="color: #1e3a8a;">
                                {{ $subject->subject_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm lg:text-base font-medium"
                                style="color: #1e3a8a;">
                                {{ $subject->number_of_periods }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('subjects.edit', $subject->id) }}" 
                                       class="px-4 py-2 rounded font-medium text-sm
                                              transition-all duration-200 hover:opacity-90"
                                       style="background-color: #84cc16; min-width: 70px; text-align: center; display: inline-block; color: #1e3a8a;">
                                        Sửa
                                    </a>
                                    
                                    <form method="POST" 
                                          action="{{ route('subjects.destroy', $subject->id) }}" 
                                          class="inline" 
                                          onsubmit="return confirm('Bạn có chắc muốn xóa môn học này?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-4 py-2 rounded text-white font-medium text-sm
                                                       transition-all duration-200 hover:opacity-90"
                                                style="background-color: #ef4444; min-width: 70px;">
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <p class="text-lg mb-2">Chưa có môn học nào</p>
                                    <a href="{{ route('subjects.create') }}" 
                                       class="text-blue-600 hover:text-blue-800 underline font-medium">
                                        Thêm môn học đầu tiên
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="md:hidden">
            @forelse ($subjects as $subject)
                <div class="border-b border-gray-200 p-4 hover:bg-gray-50">
                    <div class="space-y-3">
                        <div>
                            <span class="font-bold text-sm" style="color: #1e3a8a;">STT:</span>
                            <p class="font-medium" style="color: #1e3a8a;">
                                {{ $loop->iteration }}
                            </p>
                        </div>
                        <div>
                            <span class="font-bold text-sm" style="color: #1e3a8a;">TÊN MÔN HỌC:</span>
                            <p class="font-medium" style="color: #1e3a8a;">
                                {{ $subject->name }}
                            </p>
                        </div>
                        <div>
                            <span class="font-bold text-sm" style="color: #1e3a8a;">MÃ MÔN:</span>
                            <p class="font-medium" style="color: #1e3a8a;">
                                {{ $subject->subject_id }}
                            </p>
                        </div>
                        <div>
                            <span class="font-bold text-sm" style="color: #1e3a8a;">SỐ TIẾT/TUẦN:</span>
                            <p class="font-medium" style="color: #1e3a8a;">
                                {{ $subject->number_of_periods }}
                            </p>
                        </div>
                        <div class="flex space-x-2 pt-2">
                            <a href="{{ route('subjects.edit', $subject->id) }}" 
                               class="flex-1 px-4 py-2 rounded text-white font-medium text-sm text-center
                                      transition-all duration-200"
                               style="background-color: #84cc16; color: #1e3a8a;">
                                Sửa
                            </a>
                            <form method="POST" 
                                  action="{{ route('subjects.destroy', $subject->id) }}" 
                                  class="flex-1" 
                                  onsubmit="return confirm('Bạn có chắc muốn xóa môn học này?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full px-4 py-2 rounded text-white font-medium text-sm
                                               transition-all duration-200"
                                        style="background-color: #ef4444;">
                                    Xóa
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <p class="text-gray-500 mb-2">Chưa có môn học nào</p>
                    <a href="{{ route('subjects.create') }}" 
                       class="text-blue-600 hover:text-blue-800 underline font-medium">
                        Thêm môn học đầu tiên
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .container {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
    }

    button:hover, a:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    * {
        transition-property: background-color, border-color, color, fill, stroke;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
</style>
@endsection