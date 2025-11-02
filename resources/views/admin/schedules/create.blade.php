@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-2xl">
    <h1 class="text-3xl font-bold text-center" style="color: #1e3a8a;">Thêm lịch học mới</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('schedules.store') }}" id="create-form">
        @csrf
        <div class="bg-white p-6 rounded shadow">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Lớp học <span class="text-red-500">*</span></label>
                <select name="class_id" id="class-select" class="w-full px-3 py-2 border rounded" required>
                    <option value="">Chọn lớp</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Môn học <span class="text-red-500">*</span></label>
                <select name="subject_id" id="subject-select" class="w-full px-3 py-2 border rounded" required>
                    <option value="">Đang tải...</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Giáo viên</label>
                <input type="text" id="teacher-display" class="w-full px-3 py-2 border rounded bg-gray-100" value="Chưa chọn lớp hoặc môn" readonly>
                <input type="hidden" name="teacher_id" id="teacher-id">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Phòng học</label>
                <select name="room_id" id="room-select" class="w-full px-3 py-2 border rounded">
                    <option value="">Chưa chỉ định</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id') ? 'selected' : '' }}>{{ $room->name }}</option>
                    @endforeach
                </select>
                @error('room_conflict')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Thứ <span class="text-red-500">*</span></label>
                <select name="day_of_week" class="w-full px-3 py-2 border rounded" required>
                    <option value="">Chọn thứ</option>
                    <option value="1" {{ old('day_of_week') == 1 ? 'selected' : '' }}>Thứ 2</option>
                    <option value="2" {{ old('day_of_week') == 2 ? 'selected' : '' }}>Thứ 3</option>
                    <option value="3" {{ old('day_of_week') == 3 ? 'selected' : '' }}>Thứ 4</option>
                    <option value="4" {{ old('day_of_week') == 4 ? 'selected' : '' }}>Thứ 5</option>
                    <option value="5" {{ old('day_of_week') == 5 ? 'selected' : '' }}>Thứ 6</option>
                    <option value="6" {{ old('day_of_week') == 6 ? 'selected' : '' }}>Thứ 7</option>
                    <option value="7" {{ old('day_of_week') == 7 ? 'selected' : '' }}>Chủ Nhật</option>
                </select>
                @error('day_of_week')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Tiết <span class="text-red-500">*</span></label>
                <select name="class_period" class="w-full px-3 py-2 border rounded" required>
                    <option value="">Chọn tiết</option>
                    @for ($p = 1; $p <= 10; $p++)
                        <option value="{{ $p }}" {{ old('class_period') == $p ? 'selected' : '' }}>Tiết {{ $p }}</option>
                    @endfor
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-extrabold mb-2">Ghi chú</label>
                <textarea name="note" id="note-input" class="w-full px-3 py-2 border rounded" rows="3">{{ old('note') }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('schedules.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Hủy</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Lưu Lịch Học</button>
            </div>
        </div>
    </form>
</div>

<script>
    function loadSubjects(classId) {
        const select = document.getElementById('subject-select');
        const teacherDisplay = document.getElementById('teacher-display');
        const teacherId = document.getElementById('teacher-id');
        
        console.log('loadSubjects called with classId:', classId, 'at', new Date().toISOString());
        
        if (!classId || classId === '') {
            select.innerHTML = '<option value="">Chọn lớp trước</option>';
            teacherDisplay.value = 'Chưa chọn lớp hoặc môn';
            teacherId.value = '';
            console.log('No valid classId, setting default option');
            return;
        }

        select.innerHTML = '<option value="">Đang tải môn học...</option>';
        select.disabled = true;

        fetch(`/api/subjects/${classId}`, { 
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            cache: 'no-store' 
        })
            .then(response => {
                console.log('API response status:', response.status);
                if (!response.ok) {
                    throw new Error('API request failed: ' + response.status + ' - ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('API response data:', data);
                select.disabled = false;
                select.innerHTML = '<option value="">Chọn môn</option>';
                
                if (data.error) {
                    select.innerHTML += `<option value="" disabled>Lỗi: ${data.error}</option>`;
                    console.error('API error for class_id:', classId, 'at', new Date().toISOString(), data);
                    teacherDisplay.value = 'Lỗi khi tải môn học';
                    teacherId.value = '';
                } else if (Array.isArray(data) && data.length === 0) {
                    select.innerHTML += '<option value="" disabled>Không có môn học nào được phân công</option>';
                    console.warn('No assigned subjects for class_id:', classId, 'at', new Date().toISOString());
                    teacherDisplay.value = 'Không có môn học nào được phân công';
                    teacherId.value = '';
                } else if (Array.isArray(data)) {
                    data.forEach(s => {
                        const option = document.createElement('option');
                        option.value = s.id;
                        option.textContent = s.name;
                        select.appendChild(option);
                    });
                    console.log('Loaded', data.length, 'subjects for class_id:', classId, 'at', new Date().toISOString());
                    
                    if (data.length > 0) {
                        select.value = data[0].id;
                        loadTeacher();
                    }
                } else {
                    select.innerHTML += '<option value="" disabled>Dữ liệu không hợp lệ từ API</option>';
                    console.error('Invalid data from API for class_id:', classId, 'at', new Date().toISOString(), data);
                    teacherDisplay.value = 'Dữ liệu không hợp lệ';
                    teacherId.value = '';
                }
            })
            .catch(error => {
                console.error('Error loading subjects at', new Date().toISOString(), ':', error);
                select.disabled = false;
                select.innerHTML = `<option value="">Lỗi khi tải môn học: ${error.message}</option>`;
                teacherDisplay.value = 'Lỗi khi tải môn học: ' + error.message;
                teacherId.value = '';
            });
    }

    function loadTeacher() {
        const classId = document.getElementById('class-select').value;
        const subjectId = document.getElementById('subject-select').value;
        const teacherDisplay = document.getElementById('teacher-display');
        const teacherId = document.getElementById('teacher-id');

        console.log('loadTeacher called with classId:', classId, 'subjectId:', subjectId, 'at', new Date().toISOString());
        
        if (!classId || !subjectId || subjectId === '') {
            teacherDisplay.value = 'Chưa chọn lớp hoặc môn';
            teacherId.value = '';
            console.log('No valid classId or subjectId');
            return;
        }

        teacherDisplay.value = 'Đang tải thông tin giáo viên...';

        fetch(`/api/teacher/${classId}/${subjectId}`, { 
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            cache: 'no-store' 
        })
            .then(response => {
                console.log('Teacher API response status:', response.status);
                if (!response.ok) {
                    throw new Error('API request failed: ' + response.status + ' - ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('Teacher API response data:', data);
                if (data.id) {
                    teacherDisplay.value = `GV: ${data.name}`;
                    teacherId.value = data.id;
                } else {
                    teacherDisplay.value = data.name || 'Chưa phân công GV';
                    teacherId.value = '';
                }
            })
            .catch(error => {
                console.error('Error loading teacher at', new Date().toISOString(), ':', error);
                teacherDisplay.value = 'Lỗi khi tải thông tin GV: ' + error.message;
                teacherId.value = '';
            });
    }

    // Gắn sự kiện khi tải trang
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Content Loaded at', new Date().toISOString());
        
        const classSelect = document.getElementById('class-select');
        if (classSelect) {
            classSelect.addEventListener('change', function() {
                console.log('Class changed to:', this.value, 'at', new Date().toISOString());
                loadSubjects(this.value);
            });
            
            // Kiểm tra và gọi loadSubjects nếu có giá trị mặc định (old input)
            const initialClassId = classSelect.value;
            if (initialClassId) {
                console.log('Initial classId detected:', initialClassId, 'at', new Date().toISOString());
                loadSubjects(initialClassId);
            }
        } else {
            console.error('class-select element not found at', new Date().toISOString());
        }

        const subjectSelect = document.getElementById('subject-select');
        if (subjectSelect) {
            subjectSelect.addEventListener('change', loadTeacher);
        } else {
            console.error('subject-select element not found at', new Date().toISOString());
        }
    });
</script>
@endsection