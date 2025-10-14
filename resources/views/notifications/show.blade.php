@extends('layouts.app')

@section('title', $notification->title)

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">{{ $notification->title }}</h1>

    <p class="text-sm text-gray-500 mb-2">
        Người gửi: {{ $notification->sender->name }} <br>
        Ngày gửi: {{ $notification->sent_at }}
    </p>

    <hr class="my-4">

    <div class="text-gray-800 leading-relaxed whitespace-pre-line">
        {!! nl2br(e($notification->content)) !!}
    </div>

    <div class="mt-6">
        <a href="{{ route('notifications.index') }}" class="text-blue-600 hover:underline">
            ← Quay lại danh sách thông báo
        </a>
    </div>
</div>
@endsection
