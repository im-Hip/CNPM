<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { 
            font-family: 'DejaVu Sans', Arial, sans-serif;  /* Fix font tiếng Việt */
            margin: 20px; 
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .schedule-item { font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Ngày in: {{ now()->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Lớp</th>
                <th>Môn</th>
                <th>Thứ</th>
                <th>Tiết</th>
                <th>Phòng</th>
                <th>Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scheduleByDay as $day => $periods)
                @foreach ($periods as $period => $schedule)
                    @if ($schedule)
                        <tr>
                            <td>{{ $schedule->class->name ?? 'N/A' }}</td>
                            <td>{{ $schedule->subject->name ?? 'Môn học' }}</td>
                            <td>Thứ {{ $day }}</td>
                            <td>Tiết {{ $period }}</td>
                            <td>{{ $schedule->room->name ?? 'N/A' }}</td>
                            <td>{{ $schedule->note ?? '' }}</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>