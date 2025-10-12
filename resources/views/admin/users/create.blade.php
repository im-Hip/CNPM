<!DOCTYPE html>
<html>

<head>
    <title>Create User</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl mb-4">Create New User</h1>
        @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="bg-red-100 text-red-700 p-2 mb-4">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <ul class="list-disc ml-4">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" onsubmit="return validateForm()">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md" required minlength="8">
                <p id="password-hint" class="text-sm text-gray-500 mt-1">password requires at least 8 characters</p>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md" required>
                <p id="confirm-hint" class="text-sm text-red-500 mt-1" style="display: none;">password isn't right</p>
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    <option value="">-- Select Role --</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <!-- Inputs for TEACHER -->
            <div id="teacher-fields" class="hidden">
                <h2 class="text-lg font-semibold mb-2 mt-4">Teacher Information</h2>
                <div class="mb-4">
                    <label for="teacher_id" class="block text-sm font-medium text-gray-700">Teacher ID</label>
                    <input type="text" name="teacher_id" id="teacher_id"
                        value="{{ $newTeacherId ?? '' }}"
                        readonly
                        class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 cursor-not-allowed">
                </div>
                <div class="mb-4">
                    <label for="subject_id" class="block text-sm font-medium text-gray-700">Subject</label>
                    <select name="subject_id" id="subject_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        <option value="">-- Select Subject --</option>
                        @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="level" class="block text-sm font-medium text-gray-700">Level</label>
                    <select name="level" id="level" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        <option value="">-- Select Level --</option>
                        <option value="Master">Master</option>
                        <option value="Bachelor">Bachelor</option>
                        <option value="PhD">PhD</option>
                    </select>
                </div>
            </div>

            <!-- Inputs for STUDENT -->
            <div id="student-fields" class="hidden">
                <h2 class="text-lg font-semibold mb-2 mt-4">Student Information</h2>
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID</label>
                    <input type="text" name="student_id" id="student_id"
                        value="{{ $newStudentId ?? '' }}"
                        readonly
                        class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 cursor-not-allowed">
                </div>
                <div class="mb-4">
                    <label for="day_of_birth" class="block text-sm font-medium text-gray-700">Day of Birth</label>
                    <input type="date" name="day_of_birth" id="day_of_birth" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" id="gender" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        <option value="">-- Select Gender --</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="class_id" class="block text-sm font-medium text-gray-700">Class Id</label>
                    <select name="class_id" id="class_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        <option value="">-- Select Class --</option>
                        @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
        </form>
    </div>

    <script>
        // Ẩn/hiện input theo vai trò
        const roleSelect = document.getElementById('role');
        const teacherFields = document.getElementById('teacher-fields');
        const studentFields = document.getElementById('student-fields');

        roleSelect.addEventListener('change', function() {
            const role = this.value;

            //Ẩn/hiện các phần
            teacherFields.classList.toggle('hidden', role !== 'teacher');
            studentFields.classList.toggle('hidden', role !== 'student');

            // Lấy tất cả input/select trong mỗi nhóm
            const teacherInputs = teacherFields.querySelectorAll('input, select');
            const studentInputs = studentFields.querySelectorAll('input, select');

            // Gỡ required khỏi tất cả
            teacherInputs.forEach(el => el.removeAttribute('required'));
            studentInputs.forEach(el => el.removeAttribute('required'));

            // Gắn lại required cho đúng nhóm
            if (role === 'teacher') {
                teacherInputs.forEach(el => el.setAttribute('required', true));
            } else if (role === 'student') {
                studentInputs.forEach(el => el.setAttribute('required', true));
            }
        });

        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const confirmHint = document.getElementById('confirm-hint');

            if (password !== confirmPassword) {
                confirmHint.style.display = 'block';
                return false; // Ngăn form submit nếu mật khẩu không khớp
            } else {
                confirmHint.style.display = 'none';
                return true;
            }
        }

        // Kiểm tra realtime khi nhập
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const confirmHint = document.getElementById('confirm-hint');

            if (password !== confirmPassword && confirmPassword !== '') {
                confirmHint.style.display = 'block';
            } else {
                confirmHint.style.display = 'none';
            }
        });
    </script>
</body>

</html>