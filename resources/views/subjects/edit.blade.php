<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Môn Học</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <!-- Thanh tiêu đề -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <h1 class="text-2xl font-bold">✏️ Sửa Môn Học</h1>
    </nav>

    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc ml-4">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block font-semibold mb-2">Tên môn học</label>
                <input type="text" name="name" id="name"
                    value="{{ old('name', $subject->name) }}"
                    class="w-full border-gray-300 rounded p-2 border focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Nhập tên môn học" required>
            </div>

            <div class="mb-4">
                <label for="subject_id" class="block font-semibold mb-2">Mã môn học</label>
                <input type="text" name="subject_id" id="subject_id"
                    value="{{ old('subject_id', $subject->subject_id) }}"
                    class="w-full border-gray-300 rounded p-2 border focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Nhập mã môn học" required>
            </div>

            <div class="mb-4">
                <label for="number_of_periods" class="block font-semibold mb-2">Số tiết</label>
                <input type="number" name="number_of_periods" id="number_of_periods"
                    value="{{ old('number_of_periods', $subject->number_of_periods) }}"
                    class="w-full border-gray-300 rounded p-2 border focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Nhập số tiết (1–5)" min="1" max="5" required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('subjects.index') }}"
                    class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition">
                    ← Quay lại
                </a>

                <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                    Cập nhật
                </button>
            </div>
        </form>
    </div>

</body>

</html>
