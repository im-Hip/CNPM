<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Môn Học</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <!-- Thanh tiêu đề -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <h1 class="text-2xl font-bold">📚 Quản Lý Môn Học</h1>
    </nav>

    <!-- Nội dung chính -->
    <div class="max-w-5xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md">

        <!-- Thông báo thành công -->
        @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded border border-green-300">
            {{ session('success') }}
        </div>
        @endif

        <!-- Thông báo lỗi -->
        @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            {{ session('error') }}
        </div>
        @endif

        <!-- Nút thêm môn học -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Danh sách môn học</h2>
            <a href="{{ route('subjects.create') }}"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                ➕ Thêm môn học
            </a>
        </div>

        <!-- Bảng dữ liệu -->
        <table class="w-full border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 border text-left">#</th>
                    <th class="p-3 border text-left">Tên môn học</th>
                    <th class="p-3 border text-left">Mã môn</th>
                    <th class="p-3 border text-left">Số tiết 1 tuần</th>
                    <th class="p-3 border text-left">Tùy chọn</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as $subject)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border">{{ $loop->iteration }}</td>
                    <td class="p-3 border">{{ $subject->name }}</td>
                    <td class="p-3 border">{{ $subject->subject_id }}</td>
                    <td class="p-3 border">{{ $subject->number_of_periods }}</td>
                    <td class="p-3 border">
                        <a href="{{ route('subjects.edit', $subject->id) }}"
                            class="text-blue-600 hover:underline mr-2">✏️ Sửa</a>
                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Bạn có chắc muốn xóa môn này?')"
                                class="text-red-600 hover:underline">
                                🗑️ Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>