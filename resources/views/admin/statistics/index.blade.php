@extends('layouts.app')

@section('title', 'Thống kê')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Thống kê hệ thống</h1>
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-8">
        <!-- Biểu đồ 1: Học sinh theo lớp -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Số lượng học sinh theo lớp</h2>
            <div class="chart-container">
                <canvas id="classChart"></canvas>
            </div>
        </div>
        
        <!-- Biểu đồ 2: Giáo viên theo môn -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Giáo viên theo môn học</h2>
            <div class="chart-container">
                <canvas id="subjectChart"></canvas>
            </div>
        </div>
        
        <!-- Biểu đồ 3: Giáo viên theo học hàm -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Giáo viên theo học hàm</h2>
            <div class="chart-container">
                <canvas id="levelChart"></canvas>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Thống kê lịch học -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Thống kê lịch học theo lớp (Số tiết mỗi môn)</h2>
        
        @if(isset($scheduleStats) && count($scheduleStats) > 0 && !empty($scheduleStats[0]['subjects']))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($scheduleStats as $index => $stat)
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-4 text-center">Lớp {{ $stat['class_name'] }}</h3>
                        <div class="chart-container">
                            <canvas id="scheduleChart_{{ $index }}"></canvas>
                        </div>
                        @php
                            $validSubjects = array_filter($stat['subjects'], fn($s) => $s['value'] > 0);
                        @endphp
                        @if(empty($validSubjects))
                            <p class="text-gray-500 text-center mt-4">Chưa có lịch học</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white p-6 rounded-lg shadow-md col-span-full">
                <p class="text-gray-500 text-center">Chưa có dữ liệu lịch học hợp lệ.</p>
                <p class="text-sm text-gray-400 mt-2 text-center">
                    Vui lòng kiểm tra <a href="{{ route('schedules.index') }}" class="text-blue-500 hover:underline">lịch học</a> hoặc thêm lịch tại <a href="{{ route('schedules.create') }}" class="text-blue-500 hover:underline">đây</a>.
                </p>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dữ liệu từ PHP với fallback
    const classStats = @json($classStats ?? []);
    const subjectStats = @json($subjectStats ?? []);
    const levelStats = @json($levelStats ?? []);
    const scheduleStats = @json($scheduleStats ?? []);

    // Màu sắc cho bar charts
    const barColors = [
        'rgba(59, 130, 246, 0.8)', 'rgba(16, 185, 129, 0.8)', 'rgba(245, 158, 11, 0.8)',
        'rgba(239, 68, 68, 0.8)', 'rgba(168, 85, 247, 0.8)', 'rgba(34, 197, 94, 0.8)'
    ];

    // Màu sắc cho pie charts
    const pieColors = [
        'rgba(59, 130, 246, 0.8)', 'rgba(16, 185, 129, 0.8)', 'rgba(245, 158, 11, 0.8)',
        'rgba(239, 68, 68, 0.8)', 'rgba(168, 85, 247, 0.8)', 'rgba(34, 197, 94, 0.8)',
        'rgba(236, 72, 153, 0.8)', 'rgba(99, 102, 241, 0.8)'
    ];

    // Helper function
    function getBorderColors(bgColors) {
        return bgColors.map(color => color.replace('0.8', '1'));
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
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                },
                plugins: { legend: { display: false } }
            }
        });
    }

    function createPieChart(canvasId, subjects) {
        const canvas = document.getElementById(canvasId);
        if (!canvas || !subjects || subjects.length === 0) return;
        
        const validSubjects = subjects.filter(s => s.value > 0);
        if (validSubjects.length === 0) return;
        
        new Chart(canvas, {
            type: 'pie',
            data: {
                labels: validSubjects.map(s => `${s.label} (${s.value} tiết)`),
                datasets: [{
                    data: validSubjects.map(s => s.value),
                    backgroundColor: pieColors.slice(0, validSubjects.length),
                    borderColor: getBorderColors(pieColors.slice(0, validSubjects.length)),
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { padding: 20, usePointStyle: true, font: { size: 11 } }
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.label}: ${ctx.raw} tiết`
                        }
                    }
                }
            }
        });
    }

    // Tạo 3 bar charts
    createBarChart('classChart', classStats, 'Số lượng học sinh');
    createBarChart('subjectChart', subjectStats, 'Số lượng giáo viên');
    createBarChart('levelChart', levelStats, 'Số lượng theo học hàm');

    // Tạo pie charts cho lịch học
    scheduleStats.forEach((stat, index) => {
        createPieChart(`scheduleChart_${index}`, stat.subjects);
    });

    console.log('Charts initialized:', {
        classStats: classStats.length,
        subjectStats: subjectStats.length,
        levelStats: levelStats.length,
        scheduleStats: scheduleStats.length
    });
});
</script>

<style>
.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
    margin-bottom: 1rem;
}

canvas {
    max-height: 100% !important;
    width: 100% !important;
}
</style>
@endsection