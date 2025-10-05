@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Phân Công Giáo Viên Mới</h1>
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('teacher_assignments.store') }}" method="POST" class="bg-white p-6 rounded shadow max-w-md mx-auto">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Giáo Viên *</label>
            <select name="teacher_id" class="w-full border rounded p-2" required>
                <option value="">Chọn GV</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->user->name ?? 'GV ' . $teacher->id }} (Chuyên môn: {{ $teacher->subject->name ?? 'N/A' }})
                    </option>
                @endforeach
            </select>
            @error('teacher_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Lớp Học *</label>
            <select name="class_id" class="w-full border rounded p-2" required>
                <option value="">Chọn lớp</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('class_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Môn Học *</label>
            <select name="subject_id" class="w-full border rounded p-2" required>
                <option value="">Chọn môn</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
            @error('subject_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Ghi Chú</label>
            <textarea name="note" class="w-full border rounded p-2" rows="2" maxlength="255">{{ old('note') }}</textarea>
        </div>
        <div class="flex justify-end space-x-2">
            <a href="{{ route('teacher_assignments.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Hủy</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Phân Công</button>
        </div>
    </form>
    <div class="mt-4 p-4 bg-gray-100 rounded max-w-md mx-auto">
        <small><strong>Lưu ý:</strong> Mỗi lớp chỉ có 1 GV cho 1 môn (hệ thống tự check trùng).</small>
    </div>
</div>
@endsection