<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Gán Giáo Viên Cho Lịch: {{ $schedule->subject->name }} - Lớp {{ $schedule->class->name }} (Tiết {{ $schedule->class_period }}, Thứ {{ $schedule->day_of_week }})</h1>
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif
    <form action="{{ route('schedules.assign-teacher', $schedule) }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Giáo Viên Khả Dụng (Cho Lớp {{ $schedule->class->name }}) *</label>
            <select name="teacher_id" class="w-full border rounded p-2" required>
                <option value="">Chọn GV</option>
                @foreach($availableTeachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->user->name }} ({{ $teacher->subject->name }})</option>
                @endforeach
            </select>
        </div>
        <div class="flex justify-end space-x-2">
            <a href="{{ route('schedules.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Hủy</a>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Gán GV & Gửi Thông Báo</button>
        </div>
    </form>
</div>