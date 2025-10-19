@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-6 text-left lg:text-left" 
        style="color: #1e3a8a;">
        Phân công giáo viên
    </h1>
    
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('teacher_assignments.create') }}" 
           class="inline-block px-6 py-3 rounded-lg text-white font-semibold
                  duration-200 transform hover:scale-105
                  text-sm sm:text-base"
           style="background-color: #1d4ed8; hover:background-color: #1e40af;">
            <span class="flex items-center">
                Phân Công Mới
            </span>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr style="background-color: #e5e7eb;">
                        <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                            style="color: #1e3a8a; background-color: #e5e7eb;">
                            GIÁO VIÊN
                        </th>
                        <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                            style="color: #1e3a8a; background-color: #e5e7eb;">
                            LỚP
                        </th>
                        <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                            style="color: #1e3a8a; background-color: #e5e7eb;">
                            MÔN HỌC
                        </th>
                        <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                            style="color: #1e3a8a; background-color: #e5e7eb;">
                            GHI CHÚ
                        </th>
                        <th class="px-6 py-4 text-left text-sm lg:text-base font-bold tracking-wider"
                            style="color: #1e3a8a; background-color: #e5e7eb;">
                            HÀNH ĐỘNG
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($assignments as $assignment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base font-medium"
                                style="color: #1e3a8a;">
                                {{ $assignment->teacher->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base font-medium"
                                style="color: #1e3a8a;">
                                {{ $assignment->class->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm lg:text-base font-medium"
                                style="color: #1e3a8a;">
                                {{ $assignment->subject->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ Str::limit($assignment->note ?? '', 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('teacher_assignments.edit', $assignment) }}" 
                                       class="px-4 py-2 rounded font-medium text-sm
                                              transition-all duration-200 hover:opacity-90"
                                       style="background-color: #84cc16; min-width: 70px; text-align: center; display: inline-block; color: #1e3a8a;">
                                        Sửa
                                    </a>
                                    
                                    <form method="POST" 
                                          action="{{ route('teacher_assignments.destroy', $assignment) }}" 
                                          class="inline" 
                                          onsubmit="return confirm('Bạn có chắc muốn xóa phân công này?')">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="text-lg mb-2">Chưa có phân công nào</p>
                                    <a href="{{ route('teacher_assignments.create') }}" 
                                       class="text-blue-600 hover:text-blue-800 underline font-medium">
                                        Tạo phân công đầu tiên
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile -->
        <div class="md:hidden">
            @forelse ($assignments as $assignment)
                <div class="border-b border-gray-200 p-4 hover:bg-gray-50">
                    <div class="space-y-3">
                        <div>
                            <span class="font-bold text-sm" style="color: #1e3a8a;">GIÁO VIÊN:</span>
                            <p class="font-medium" style="color: #1e3a8a;">
                                {{ $assignment->teacher->user->name ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <span class="font-bold text-sm" style="color: #1e3a8a;">LỚP:</span>
                            <p class="font-medium" style="color: #1e3a8a;">
                                {{ $assignment->class->name ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <span class="font-bold text-sm" style="color: #1e3a8a;">MÔN HỌC:</span>
                            <p class="font-medium" style="color: #1e3a8a;">
                                {{ $assignment->subject->name ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <span class="font-bold text-sm" style="color: #1e3a8a;">GHI CHÚ:</span>
                            <p class="text-gray-500 text-sm">
                                {{ $assignment->note ?? 'Không có ghi chú' }}
                            </p>
                        </div>
                        <div class="flex space-x-2 pt-2">
                            <a href="{{ route('teacher_assignments.edit', $assignment) }}" 
                               class="flex-1 px-4 py-2 rounded text-white font-medium text-sm text-center
                                      transition-all duration-200"
                               style="background-color: #84cc16; color: #1e3a8a;">
                                Sửa
                            </a>
                            <form method="POST" 
                                  action="{{ route('teacher_assignments.destroy', $assignment) }}" 
                                  class="flex-1" 
                                  onsubmit="return confirm('Bạn có chắc muốn xóa phân công này?')">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-500 mb-2">Chưa có phân công nào</p>
                    <a href="{{ route('teacher_assignments.create') }}" 
                       class="text-blue-600 hover:text-blue-800 underline font-medium">
                        Tạo phân công đầu tiên
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        {{ $assignments->appends(request()->query())->links() }}
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