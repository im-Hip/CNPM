@extends('layouts.app')

@section('title', 'Thống kê')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-8 sm:mb-10 text-center" 
        style="color: #1e40af;">
        Thống kê hệ thống
    </h1>

    <!-- noti Success -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
            <p class="font-medium">✅ {{ session('success') }}</p>
        </div>
    @endif

    <!-- view thống kê tổng quan -->
    <div class="mb-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            <!-- biểu đồ giáo viên theo môn -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden p-6">
                <h3 class="text-lg font-bold mb-6 text-center" style="color: #1e40af;">
                    Giáo viên theo môn học
                </h3>
                <div class="chart-container">
                    <canvas id="subjectChart"></canvas>
                </div>
            </div>

            <!-- biểu đồ học sinh theo lớp -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden p-6">
                <h3 class="text-lg font-bold mb-6 text-center" style="color: #1e40af;">
                    Số lượng học sinh theo lớp
                </h3>
                <div class="chart-container">
                    <canvas id="classChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- thống kê lịch học -->
    <div class="mb-12">
        @if(isset($scheduleStats) && count($scheduleStats) > 0 && !empty($scheduleStats[0]['subjects']))
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold mb-6 text-center" style="color: #1e40af;">
                    Thống kê lịch học theo lớp (Số tiết mỗi môn)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($scheduleStats as $index => $stat)
                        <div class="text-center">
                            <h4 class="font-semibold mb-4" style="color: #1e40af;">Lớp {{ $stat['class_name'] }}</h4>
                            <div class="chart-container-small mx-auto">
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
                                    <p class="text-gray-500 text-sm">Chưa có lịch học</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg p-8">
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
        <div class="bg-white rounded-2xl shadow-lg p-6 max-w-xl mx-auto">
            <h3 class="text-lg font-bold mb-6 text-center" style="color: #1e40af;">
                Thống kê thông báo theo loại
            </h3>
            <div class="chart-container-small mx-auto">
                <canvas id="notificationTypeChart"></canvas>
            </div>
            @if(empty($notificationTypeStats) || array_sum(array_column($notificationTypeStats, 'value')) === 0)
                <div class="text-center mt-4">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-500 text-sm">Chưa có thông báo nào được gửi</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const classStats = @json($classStats ?? []);
    const subjectStats = @json($subjectStats ?? []);
    const scheduleStats = @json($scheduleStats ?? []);
    const notificationTypeStats = @json($notificationTypeStats ?? []);

    // Màu sắc theo hình mẫu - xanh dương và đỏ/hồng
    const barColors = {
        blue: 'rgba(79, 70, 229, 0.8)',      // Xanh dương đậm
        lightBlue: 'rgba(139, 92, 246, 0.8)', // Xanh tím
        red: 'rgba(248, 113, 113, 0.8)',      // Đỏ/hồng
        coral: 'rgba(252, 165, 165, 0.8)'     // Hồng san hô
    };

    // Màu cho pie charts - 4 màu chính giống hình
    const pieColors = [
        'rgba(59, 130, 246, 0.9)',    // Xanh dương
        'rgba(251, 191, 36, 0.9)',    // Vàng
        'rgba(34, 197, 94, 0.9)',     // Xanh lá
        'rgba(239, 68, 68, 0.9)'      // Đỏ
    ];

    function getBorderColors(bgColors) {
        if (Array.isArray(bgColors)) {
            return bgColors.map(color => color.replace('0.8', '1').replace('0.9', '1'));
        }
        return bgColors.replace('0.8', '1').replace('0.9', '1');
    }

    // Bar chart với 2 màu xen kẽ
    function createBarChart(canvasId, data, label) {
        const canvas = document.getElementById(canvasId);
        if (!canvas || data.length === 0) return;
        
        // Xen kẽ màu xanh và đỏ
        const backgroundColors = data.map((_, index) => {
            if (index % 4 === 0) return barColors.blue;
            if (index % 4 === 1) return barColors.red;
            if (index % 4 === 2) return barColors.lightBlue;
            return barColors.coral;
        });
        
        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: data.map(stat => stat.label),
                datasets: [{
                    label,
                    data: data.map(stat => stat.value),
                    backgroundColor: backgroundColors,
                    borderColor: getBorderColors(backgroundColors),
                    borderWidth: 0,
                    borderRadius: 6,
                    barThickness: 'flex',
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1500,
                    easing: 'easeInOutQuart',
                    delay: (context) => {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default') {
                            delay = context.dataIndex * 100;
                        }
                        return delay;
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: { 
                            stepSize: 1,
                            font: { size: 11 },
                            color: '#6b7280',
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            }
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
                            font: { size: 10 },
                            color: '#6b7280'
                        }
                    }
                },
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 13 },
                        bodyFont: { size: 12 }
                    }
                }
            }
        });
    }

    // Doughnut chart với 4 màu chính
    function createPieChart(canvasId, data) {
        const canvas = document.getElementById(canvasId);
        if (!canvas || !data || data.length === 0) return;
        
        const validData = data.filter(s => s.value > 0);
        if (validData.length === 0) return;
        
        new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: validData.map(s => s.label),
                datasets: [{
                    data: validData.map(s => s.value),
                    backgroundColor: pieColors.slice(0, validData.length),
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1200,
                    easing: 'easeInOutQuart',
                    animateRotate: true,
                    animateScale: true
                },
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { 
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 11 },
                            color: '#374151',
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map((label, i) => {
                                        const dataset = data.datasets[0];
                                        const value = dataset.data[i];
                                        return {
                                            text: ` ${label}`,
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
                        padding: 10,
                        cornerRadius: 6,
                        bodyFont: { size: 12 },
                        callbacks: {
                            label: ctx => {
                                const label = ctx.label || '';
                                const value = ctx.raw || 0;
                                return ` ${label}: ${value}`;
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });
    }

    // Tạo các biểu đồ
    createBarChart('subjectChart', subjectStats, 'Số lượng giáo viên');
    createBarChart('classChart', classStats, 'Số lượng học sinh');

    // Pie charts cho lịch học
    scheduleStats.forEach((stat, index) => {
        createPieChart(`scheduleChart_${index}`, stat.subjects);
    });

    // Pie chart cho thông báo
    createPieChart('notificationTypeChart', notificationTypeStats);
});
</script>

<style>
/* Animations */
@keyframes fadeInUp {
    from { 
        opacity: 0; 
        transform: translateY(30px);
    }
    to { 
        opacity: 1; 
        transform: translateY(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.bg-white {
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
}

.bg-white:nth-child(1) {
    animation-delay: 0.1s;
}

.bg-white:nth-child(2) {
    animation-delay: 0.2s;
}

.bg-white:nth-child(3) {
    animation-delay: 0.3s;
}

h1 {
    animation: slideInRight 0.8s ease-out;
}

h3 {
    animation: scaleIn 0.5s ease-out;
}

/* Chart containers */
.chart-container {
    position: relative;
    height: 320px;
    width: 100%;
}

.chart-container-small {
    position: relative;
    height: 220px;
    width: 100%;
    max-width: 280px;
}

/* Hover effects */
.bg-white {
    transition: all 0.3s ease;
}

.bg-white:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Pulse animation cho tiêu đề */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

h1 {
    animation: slideInRight 0.8s ease-out, pulse 3s ease-in-out infinite;
}

/* Loading animation cho charts */
@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

.chart-container::before,
.chart-container-small::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    background-size: 1000px 100%;
    animation: shimmer 2s infinite;
    pointer-events: none;
    opacity: 0;
}

canvas {
    max-height: 100% !important;
    width: 100% !important;
}

/* Responsive */
@media (max-width: 640px) {
    .chart-container {
        height: 260px;
    }
    .chart-container-small {
        height: 200px;
    }
}
</style>
@endsection