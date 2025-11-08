@extends('layouts.app')

@section('title', 'Sửa lịch học')

@section('content')

    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-center pt-4 sm:pt-6 lg:pt-8" 
        style="color: #1e3a8a;">
        Sửa Lịch Học
    </h1>

    <div class="max-w-xl sm:max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm mt-6 p-6 sm:p-8">
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('schedules.update', $schedule) }}" id="edit-form">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label class="block text-sm font-extrabold text-gray-800 mb-2">
                        Lớp học <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           value="{{ $schedule->class->name ?? 'N/A' }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" 
                           readonly 
                           placeholder="Lớp không thể thay đổi">
                    <input type="hidden" name="class_id" value="{{ $schedule->class_id }}">
                    <p class="text-xs text-gray-500 mt-1">Không thể thay đổi lớp học</p>
                    @error('class_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-extrabold text-gray-800 mb-2">
                        Môn học <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           value="{{ $schedule->subject->name ?? 'N/A' }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" 
                           readonly 
                           placeholder="Môn học không thể thay đổi">
                    <input type="hidden" name="subject_id" value="{{ $schedule->subject_id }}">
                    <p class="text-xs text-gray-500 mt-1">Không thể thay đổi môn học</p>
                    @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-extrabold text-gray-800 mb-2">
                        Giáo viên
                    </label>
                    <input type="text" 
                           id="teacher-display" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" 
                           readonly 
                           value="GV: {{ $schedule->teacher->user->name ?? 'N/A' }}" 
                           placeholder="Chọn môn để xem GV">
                    <input type="hidden" name="teacher_id" id="teacher-id" value="{{ $schedule->teacher_id }}">
                    <p class="text-xs text-gray-500 mt-1">Giáo viên được tự động xác định theo môn học</p>
                    @error('teacher')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-extrabold text-gray-800 mb-2">
                        Phòng học
                    </label>
                    <select name="room_id" 
                            id="room-select" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="">-- Chưa chỉ định --</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" 
                                    {{ old('room_id', $schedule->room_id) == $room->id ? 'selected' : '' }}>
                                {{ $room->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('room_conflict')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-extrabold text-gray-800 mb-2">
                            Thứ <span class="text-red-500">*</span>
                        </label>
                        <select name="day_of_week" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                required>
                            <option value="">-- Chọn thứ --</option>
                            <option value="1" {{ old('day_of_week', $schedule->day_of_week) == 1 ? 'selected' : '' }}>Thứ 2</option>
                            <option value="2" {{ old('day_of_week', $schedule->day_of_week) == 2 ? 'selected' : '' }}>Thứ 3</option>
                            <option value="3" {{ old('day_of_week', $schedule->day_of_week) == 3 ? 'selected' : '' }}>Thứ 4</option>
                            <option value="4" {{ old('day_of_week', $schedule->day_of_week) == 4 ? 'selected' : '' }}>Thứ 5</option>
                            <option value="5" {{ old('day_of_week', $schedule->day_of_week) == 5 ? 'selected' : '' }}>Thứ 6</option>
                            <option value="6" {{ old('day_of_week', $schedule->day_of_week) == 6 ? 'selected' : '' }}>Thứ 7</option>
                            <option value="7" {{ old('day_of_week', $schedule->day_of_week) == 7 ? 'selected' : '' }}>Chủ Nhật</option>
                        </select>
                        @error('day_of_week')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-extrabold text-gray-800 mb-2">
                            Tiết <span class="text-red-500">*</span>
                        </label>
                        <select name="class_period" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                required>
                            <option value="">-- Chọn tiết --</option>
                            @for ($p = 1; $p <= 10; $p++)
                                <option value="{{ $p }}" 
                                        {{ old('class_period', $schedule->class_period) == $p ? 'selected' : '' }}>
                                    Tiết {{ $p }}
                                </option>
                            @endfor
                        </select>
                        @error('class_period')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-extrabold text-gray-800 mb-2">
                        Ghi chú
                    </label>
                    <textarea name="note" 
                              id="note-input" 
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                              rows="3"
                              placeholder="Nhập ghi chú (không bắt buộc)">{{ old('note', $schedule->note) }}</textarea>
                    @error('note')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end mt-8" style="gap: 1rem;">
                    <a href="{{ route('schedules.index') }}" 
                       style="background-color: #2563eb; padding: 12px 32px; color: white; font-weight: 600; border-radius: 8px; text-decoration: none; display: inline-block; transition: all 0.2s;"
                       onmouseover="this.style.backgroundColor='#1d4ed8'"
                       onmouseout="this.style.backgroundColor='#2563eb'"
                       class="text-center">
                        Hủy
                    </a>
                    <button type="submit" 
                            style="background-color: #2563eb; padding: 12px 32px; color: white; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.backgroundColor='#1d4ed8'"
                            onmouseout="this.style.backgroundColor='#2563eb'">
                        Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function loadSubjects(classId) {
            if (!classId) {
                document.getElementById('subject-select').innerHTML = '<option value="">-- Chọn môn học --</option>';
                return;
            }
            fetch(`/api/subjects/${classId}`)
                .then(r => r.json())
                .then(data => {
                    const select = document.getElementById('subject-select');
                    select.innerHTML = '<option value="">-- Chọn môn học --</option>';
                    data.forEach(s => select.innerHTML += `<option value="${s.id}">${s.name}</option>`);
                    const oldSubject = '{{ old('subject_id', $schedule->subject_id) }}';
                    if (oldSubject) select.value = oldSubject;
                    loadTeacher();
                })
                .catch(e => console.error('Subjects error:', e));
        }

        function loadTeacher() {
            const classId = '{{ $schedule->class_id }}';
            const subjectId = document.getElementById('subject-select').value;
            if (!classId || !subjectId) {
                document.getElementById('teacher-display').value = 'Chọn môn để xem GV';
                document.getElementById('teacher-id').value = '';
                return;
            }
            fetch(`/api/teacher/${classId}/${subjectId}`)
                .then(r => r.json())
                .then(data => {
                    document.getElementById('teacher-display').value = data.id ? `GV: ${data.name}` : data.name || 'Chưa phân công GV cho môn này';
                    document.getElementById('teacher-id').value = data.id || '';
                })
                .catch(e => console.error('Teacher error:', e));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const initialClassId = '{{ old('class_id', $schedule->class_id) }}';
            if (initialClassId) {
                loadSubjects(initialClassId);
            }
        });
    </script>

    <style>
        @media (max-width: 640px) {
            .max-w-2xl {
                max-width: 100%;
            }
            
            .flex.justify-end {
                flex-direction: column-reverse;
                gap: 0.5rem;
            }
            
            .flex.justify-end > * {
                width: 100%;
                text-align: center;
            }
        }

        select:focus, textarea:focus, input:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        * {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
@endsection