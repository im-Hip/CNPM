@extends('layouts.app')

@section('title', 'Thống kê')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-8 sm:mb-10 text-center lg:text-left" 
        style="color: #1e3a8a;">
        📊 Thống Kê Hệ Thống
    </h1>

    <!-- noti Success -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
            <p class="font-medium">✅ {{ session('success') }}</p>
        </div>
    @endif

    <!-- view thống kê tổng quan -->
    <div class="mb-12">
        <h2 class="text-xl sm:text-2xl font-semibold mb-6 flex items-center" 
            style="color: #2563eb;">
            <span class="mr-2">📈</span>
            Thống Kê Tổng Quan
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
            <!-- biểu đồ học sinh theo lớp -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h3 class="text-white font-semibold text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                        Học sinh theo lớp
                    </h3>
                </div>
                <div class="p-6">
                    <div class="chart-container">
                        <canvas id="classChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- biểu đồ giáo viên theo môn -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h3 class="text-white font-semibold text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                        </svg>
                        Giáo viên theo môn
                    </h3>
                </div>
                <div class="p-6">
                    <div class="chart-container">
                        <canvas id="subjectChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- biểu đồ giáo viên theo học hàm -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                    <h3 class="text-white font-semibold text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                        </svg>
                        Giáo viên theo học hàm
                    </h3>
                </div>
                <div class="p-6">
                    <div class="chart-container">
                        <canvas id="levelChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- thống kê lịch học -->
    <div class="mb-12">
        <h2 class="text-xl sm:text-2xl font-semibold mb-6 flex items-center" 
            style="color: #2563eb;">
            <span class="mr-2">📅</span>
            Thống Kê Lịch Học Theo Lớp
            <span class="ml-3 text-sm font-normal text-gray-600">(Số tiết mỗi môn)</span>
        </h2>
        
        @if(isset($scheduleStats) && count($scheduleStats) > 0 && !empty($scheduleStats[0]['subjects']))
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
                @foreach($scheduleStats as $index => $stat)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4 group-hover:from-indigo-600 group-hover:to-indigo-700 transition-all duration-300">
                            <h3 class="text-white font-semibold text-lg text-center">
                                Lớp {{ $stat['class_name'] }}
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="chart-container">
                                <canvas id="scheduleChart_{{ $index }}"></canvas>
                            </div>
                            @php
                                $validSubjects = array_filter($stat['subjects'], fn($s) => $s['value'] > 0);
                            @endphp
                            @if(empty($validSubjects))
                                <div class="text-center mt-4">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-gray-500">Chưa có lịch học</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500 mb-4">Chưa có dữ liệu lịch học hợp lệ</p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('schedules.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Xem lịch học
                        </a>
                        <a href="{{ route('schedules.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Thêm lịch mới
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- thống kê thông báo -->
    <div class="mb-12">
        <h2 class="text-xl sm:text-2xl font-semibold mb-6 flex items-center" 
            style="color: #2563eb;">
            <span class="mr-2">📢</span>
            Thống Kê Thông Báo Đã Gửi
        </h2>
        
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                    <h3 class="text-white font-semibold text-lg text-center">
                        Phân loại thông báo
                    </h3>
                </div>
                <div class="p-6">
                    <div class="chart-container">
                        <canvas id="notificationTypeChart"></canvas>
                    </div>
                    @if(empty($notificationTypeStats) || array_sum(array_column($notificationTypeStats, 'value')) === 0)
                        <div class="text-center mt-4">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-gray-500">Chưa có thông báo nào được gửi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const classStats = @json($classStats ?? []);
    const subjectStats = @json($subjectStats ?? []);
    const levelStats = @json($levelStats ?? []);
    const scheduleStats = @json($scheduleStats ?? []);
    const notificationTypeStats = @json($notificationTypeStats ?? []);

    const barColors = [
        'rgba(59, 130, 246, 0.85)',   // blue
        'rgba(16, 185, 129, 0.85)',   // green
        'rgba(245, 158, 11, 0.85)',   // yellow
        'rgba(239, 68, 68, 0.85)',    // red
        'rgba(168, 85, 247, 0.85)',   // purple
        'rgba(34, 197, 94, 0.85)'     // emerald
    ];

    // Màu sắc cho pie charts
    const pieColors = [
        'rgba(59, 130, 246, 0.85)',   // blue
        'rgba(16, 185, 129, 0.85)',   // green  
        'rgba(245, 158, 11, 0.85)',   // yellow
        'rgba(239, 68, 68, 0.85)',    // red
        'rgba(168, 85, 247, 0.85)',   // purple
        'rgba(34, 197, 94, 0.85)',    // emerald
        'rgba(236, 72, 153, 0.85)',   // pink
        'rgba(99, 102, 241, 0.85)'    // indigo
    ];

    //helper function
    function getBorderColors(bgColors) {
        return bgColors.map(color => color.replace('0.85', '1'));
    }

    function createBarChart(canvasId, data, label) {
        const canvas = document.getElementById(canvasId);
        if (!canvas || data.length === 0) return;
        
        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: data.map(stat => stat.label),
                datasets: [{
                    label,
                    data: data.map(stat => stat.value),
                    backgroundColor: barColors.slice(0, data.length),
                    borderColor: getBorderColors(barColors.slice(0, data.length)),
                    borderWidth: 2,
                    borderRadius: 8,
                    barThickness: 'flex',
                    maxBarThickness: 60
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { 
                            stepSize: 1,
                            font: { size: 12 }
                        },
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 11 }
                        }
                    }
                },
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 14 },
                        bodyFont: { size: 13 }
                    }
                }
            }
        });
    }

    function createPieChart(canvasId, data) {
        const canvas = document.getElementById(canvasId);
        if (!canvas || !data || data.length === 0) return;
        
        const validData = data.filter(s => s.value > 0);
        if (validData.length === 0) return;
        
        new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: validData.map(s => `${s.label}`),
                datasets: [{
                    data: validData.map(s => s.value),
                    backgroundColor: pieColors.slice(0, validData.length),
                    borderColor: getBorderColors(pieColors.slice(0, validData.length)),
                    borderWidth: 2,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { 
                            padding: 15, 
                            usePointStyle: true, 
                            font: { size: 12 },
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map((label, i) => {
                                        const dataset = data.datasets[0];
                                        const value = dataset.data[i];
                                        return {
                                            text: `${label} (${value})`,
                                            fillStyle: dataset.backgroundColor[i],
                                            hidden: false,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: ctx => {
                                const label = ctx.label || '';
                                const value = ctx.raw || 0;
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '40%'
            }
        });
    }

    //3 bar charts
    createBarChart('classChart', classStats, 'Số lượng học sinh');
    createBarChart('subjectChart', subjectStats, 'Số lượng giáo viên');
    createBarChart('levelChart', levelStats, 'Số lượng theo học hàm');

    //pie charts cho lịch học
    scheduleStats.forEach((stat, index) => {
        createPieChart(`scheduleChart_${index}`, stat.subjects);
    });

    //pie chart cho thông báo theo loại
    createPieChart('notificationTypeChart', notificationTypeStats);
});
</script>

<style>
.chart-container {
    position: relative;
    height: 280px;
    width: 100%;
    margin-bottom: 0.5rem;
}

@media (max-width: 640px) {
    .chart-container {
        height: 240px;
    }
}

canvas {
    max-height: 100% !important;
    width: 100% !important;
}

.group:hover .group-hover\:from-indigo-600 {
    --tw-gradient-from: #4f46e5;
}

.group:hover .group-hover\:to-indigo-700 {
    --tw-gradient-to: #4338ca;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.bg-white {
    animation: fadeIn 0.5s ease-out;
}
</style>
@endsection