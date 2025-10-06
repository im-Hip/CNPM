<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { 
            font-family: 'DejaVu Sans', Arial, sans-serif;  /* Thêm font hỗ trợ Việt */
            margin: 20px; 
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .morning { background-color: #fff3cd; }
        .afternoon { background-color: #d1ecf1; }
        .schedule-item { font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Lớp: {{ $className }} | Ngày in: {{ now()->format('d/m/Y') }}</p>
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
            {{-- Sáng --}}
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
                                    <strong>{{ $schedule->subject->name ?? 'Môn học' }}</strong><br>
                                    GV: {{ $schedule->teacher->user->name ?? 'N/A' }}<br>
                                    @if ($schedule->room) Phòng: {{ $schedule->room->name ?? 'N/A' }} @endif
                                    @if ($schedule->note) <br><small>{{ $schedule->note }}</small> @endif
                                </div>
                            @else
                                <span>Trống</span>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endfor

            {{-- Chiều --}}
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
                                    <strong>{{ $schedule->subject->name ?? 'Môn học' }}</strong><br>
                                    GV: {{ $schedule->teacher->user->name ?? 'N/A' }}<br>
                                    @if ($schedule->room) Phòng: {{ $schedule->room->name ?? 'N/A' }} @endif
                                    @if ($schedule->note) <br><small>{{ $schedule->note }}</small> @endif
                                </div>
                            @else
                                <span>Trống</span>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>