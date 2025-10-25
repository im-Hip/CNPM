@extends('layouts.app')

@section('title', 'Chỉnh sửa thông báo')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold mb-4 text-blue-800">Chỉnh sửa thông báo</h2>

    <form action="{{ route('notifications.update', $notification->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề</label>
            <input type="text" name="title" value="{{ old('title', $notification->title) }}"
                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nội dung</label>
            <textarea name="content" rows="5"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('content', $notification->content) }}</textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('notifications.index') }}" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Hủy</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Lưu</button>
        </div>
    </form>
</div>
@endsection
