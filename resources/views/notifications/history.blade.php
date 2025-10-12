@extends('layouts.app')

@section('title', 'Lịch sử thông báo')

@section('content')
    <h1 class="text-2xl lg:text-3xl font-bold mb-6 text-center" style="color: #1e3a8a;">
        HỆ THỐNG QUẢN LÝ LỊCH HỌC VÀ THÔNG BÁO CHO HỌC SINH
    </h1>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="height: calc(100vh - 180px); display: flex; flex-direction: column;">
        
        <div class="px-6 py-3 flex justify-between items-center flex-shrink-0" style="background-color: #1e40af;">
            
            <div class="flex items-center text-white">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                <span class="text-base font-semibold">Thông báo mới</span>
            </div>

            <!-- symbol Tim kiem o day-->
            <div class="relative flex items-center">
                <svg class="w-4 h-4 absolute left-4 text-gray-500 pointer-events-none" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                </svg>
                <input type="text" 
                       id="searchInput"
                       placeholder="  Tìm kiếm..." 
                       class="w-64 pl-9 pr-4 py-1.5 rounded-full text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-white/50"
                       style="border-radius: 20px;">
            </div>
        </div>

        <!-- Nội dung thông báo có scroll -->
        <div class="flex-1 overflow-y-auto p-6">
            @if ($sentNotifications->isEmpty())
                <!-- Hiển thị khi chưa có thông báo -->
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                        <p class="text-gray-500 text-lg">Chưa có thông báo nào được gửi.</p>
                    </div>
                </div>
            @else
                <!-- Danh sách thông báo -->
                <div class="space-y-4" id="notificationList">
                    @foreach ($sentNotifications as $notification)
                        <div class="notification-item border-l-4 border-blue-500 bg-gray-50 p-4 rounded-lg hover:shadow-md transition-shadow duration-200">
                            <div class="flex justify-between items-start">
                                <!-- Nội dung thông báo -->
                                <div class="flex-1 mr-4">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                        {{ $notification->title }}
                                    </h3>
                                    <p class="text-gray-600 mb-3">
                                        {{ $notification->content }}
                                    </p>
                                    <div class="flex items-center text-sm text-gray-500 space-x-4">
                                        <!-- Người gửi -->
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $notification->sender->name ?? 'Hệ thống' }}
                                        </span>
                                        <!-- Thời gian -->
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($notification->sent_at)->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Badge loại thông báo -->
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                        @if($notification->recipient_type === 'all') 
                                            bg-green-100 text-green-800
                                        @elseif($notification->recipient_type === 'class')
                                            bg-blue-100 text-blue-800
                                        @else
                                            bg-purple-100 text-purple-800
                                        @endif">
                                        @if($notification->recipient_type === 'all')
                                            Tất cả
                                        @elseif($notification->recipient_type === 'class')
                                            Lớp {{ $notification->recipient_id }}
                                        @else
                                            Cá nhân
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        @if($sentNotifications instanceof \Illuminate\Pagination\LengthAwarePaginator && $sentNotifications->hasPages())
            <div class="border-t bg-gray-50 px-6 py-4 flex-shrink-0">
                <div class="flex justify-center">
                    {{ $sentNotifications->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Script tìm kiếm -->
    <script>
        document.getElementById('searchInput')?.addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let notifications = document.querySelectorAll('.notification-item');
            
            notifications.forEach(function(item) {
                let text = item.textContent.toLowerCase();
                if (text.includes(searchValue)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>

    <!-- Custom styles -->
    <style>
        .overflow-y-auto::-webkit-scrollbar {
            width: 8px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }


        .notification-item {
            transition: all 0.2s ease;
        }

        .notification-item:hover {
            transform: translateX(4px);
        }

        
        #searchInput:focus {
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #searchInput {
                width: 200px;
            }
        }

        @media (max-width: 640px) {
            .px-6.py-2\.5 {
                flex-direction: column;
                gap: 0.75rem;
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }
            
            #searchInput {
                width: 100%;
            }
        }
    </style>
@endsection