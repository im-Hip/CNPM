<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ public_path('fonts/DejaVuSans.ttf') }}') format('truetype');
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 30px;
            background-color: #f8f9fa;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
            padding: 25px;
            border-radius: 12px;
            color: #2d3748;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .header h1, .header p {
            color: #1a202c;
        }

        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        th, td {
            border: 1px solid #e2e8f0;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }
        
        th {
            background: #4a5568;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            padding: 12px 10px;
        }
        
        td:first-child {
            font-weight: bold;
            background-color: #f7fafc;
            color: #2d3748;
        }
        
        .morning {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            font-weight: bold;
            color: #2d3748;
            font-size: 15px;
            padding: 12px;
            text-align: left;
        }
        
        .afternoon {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            font-weight: bold;
            color: #2d3748;
            font-size: 15px;
            padding: 12px;
            text-align: left;
        }
        
        .schedule-item {
            text-align: left;
            font-size: 11px;
            line-height: 1.5;
            background: #f8f9ff;
            padding: 10px;
            border-radius: 6px;
            border-left: 3px solid #667eea;
            min-height: 70px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .schedule-item strong {
            color: #667eea;
            font-size: 12px;
            margin-bottom: 4px;
            display: block;
        }
        
        .schedule-item small {
            font-size: 10px;
            color: #718096;
            font-style: italic;
            margin-top: 3px;
            display: block;
        }
        
        .empty-slot {
            color: #cbd5e0;
            font-style: italic;
        }
        
        tr:nth-child(even):not(.morning):not(.afternoon) {
            background-color: #fafbff;
        }
        
        tr:hover:not(.morning):not(.afternoon) {
            background-color: #f0f2ff;
        }
        
        @media print {
            body {
                background: white;
                margin: 10px;
            }
            .header {
                box-shadow: none;
            }
            table {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>{{ isset($className) ? 'Lớp: ' . $className . ' | ' : '' }}Ngày in: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tiết học</th>
                <th>Thứ 2</th>
                <th>Thứ 3</th>
                <th>Thứ 4</th>
                <th>Thứ 5</th>
                <th>Thứ 6</th>
                <th>Thứ 7</th>
                <th>Chủ Nhật</th>
            </tr>
        </thead>
        <tbody>
            <!-- Sáng -->
            <tr class="morning">
                <td colspan="8"><strong>SÁNG</strong></td>
            </tr>
            @for ($period = 1; $period <= 5; $period++)
                <tr>
                    <td>Tiết {{ $period }}</td>
                    @for ($day = 1; $day <= 7; $day++)
                        <td>
                            @php $schedule = $scheduleByDay->get($day)?->get($period); @endphp
                            @if ($schedule)
                                <div class="schedule-item">
                                    <strong>{{ $schedule->subject->name ?? 'Môn học' }}@if (auth()->check() && auth()->user()->role === 'teacher') - Lớp {{ $schedule->class->name ?? 'N/A' }}@endif</strong>
                                    GV: {{ $schedule->teacher->user->name ?? 'N/A' }}<br>
                                    @if ($schedule->room) Phòng: {{ $schedule->room->name ?? 'N/A' }} @endif
                                    @if ($schedule->note) <small>{{ $schedule->note }}</small> @endif
                                </div>
                            @else
                                <span class="empty-slot"></span>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endfor

            <!-- Chiều -->
            <tr class="afternoon">
                <td colspan="8"><strong>CHIỀU</strong></td>
            </tr>
            @for ($period = 6; $period <= 10; $period++)
                <tr>
                    <td>Tiết {{ $period }}</td>
                    @for ($day = 1; $day <= 7; $day++)
                        <td>
                            @php $schedule = $scheduleByDay->get($day)?->get($period); @endphp
                            @if ($schedule)
                                <div class="schedule-item">
                                    <strong>{{ $schedule->subject->name ?? 'Môn học' }}@if (auth()->check() && auth()->user()->role === 'teacher') - Lớp {{ $schedule->class->name ?? 'N/A' }}@endif</strong>
                                    GV: {{ $schedule->teacher->user->name ?? 'N/A' }}<br>
                                    @if ($schedule->room) Phòng: {{ $schedule->room->name ?? 'N/A' }} @endif
                                    @if ($schedule->note) <small>{{ $schedule->note }}</small> @endif
                                </div>
                            @else
                                <span class="empty-slot"></span>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>