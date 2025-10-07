<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Lớp Học</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<nav class="bg-blue-600 text-white p-4 shadow-md">
    <h1 class="text-2xl font-bold">🏫 Quản Lý Lớp Học</h1>
</nav>

<div class="max-w-5xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md">

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Danh sách lớp học</h2>
        <a href="{{ route('classes.create') }}" 
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
           ➕ Thêm lớp học
        </a>
    </div>

    <table class="w-full border border-gray-300">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 border text-left">#</th>
                <th class="p-3 border text-left">Mã lớp</th>
                <th class="p-3 border text-left">Tên lớp</th>
                <th class="p-3 border text-left">Khối</th>
                <th class="p-3 border text-left">Tùy chọn</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classes as $class)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border">{{ $loop->iteration }}</td>
                    <td class="p-3 border">{{ $class->class_id }}</td>
                    <td class="p-3 border">{{ $class->name }}</td>
                    <td class="p-3 border">{{ $class->grade }}</td>
                    <td class="p-3 border">
                        <a href="{{ route('classes.edit', $class->id) }}" 
                           class="text-blue-600 hover:underline mr-2">✏️ Sửa</a>
                        <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa lớp này?')"
                                    class="text-red-600 hover:underline">🗑️ Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
