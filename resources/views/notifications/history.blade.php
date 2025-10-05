<!DOCTYPE html>
<html>
<head>
    <title>Notification History</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl mb-4">Notification History</h1>
        @if ($sentNotifications->isEmpty())
            <p>No notifications sent.</p>
        @else
            @foreach ($sentNotifications as $notification)
                <div class="bg-gray-100 p-4 mb-2 rounded-md">
                    <h3 class="text-lg font-bold">{{ $notification->title }}</h3>
                    <p class="text-gray-700">{{ $notification->content }}</p>
                    <p class="text-sm text-gray-500">Type: {{ $notification->type }}</p>
                    <p class="text-sm text-gray-500">Sent to: {{ $notification->recipient_type === 'App\Models\User' ? $notification->recipient->name : 'Class ' . $notification->recipient_id }} at {{ $notification->sent_at }}</p>
                </div>
            @endforeach
        @endif
    </div>