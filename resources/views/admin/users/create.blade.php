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
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
        </form>
    </div>

    <script>
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