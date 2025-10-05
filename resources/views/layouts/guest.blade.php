<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'N9') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            background-image: url('{{ asset("images/bg-login.jpg") }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: white;
            font-family: sans-serif;
        }

        .bg-overlay {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            padding: 2vh 1rem;
            gap: 2rem;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 0.75rem;
            font-weight: 300;
            color: #fff;
        }

        h1.title-n9 {
            font-size: 4rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 0.2rem;
        }

        p.sub-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-top: 0;
        }

        .login-card {
            background-color: white;
            color: #333;
            border-radius: 0.5rem;
            box-shadow: -15px 0 25px rgba(0,0,0,0.5);
            max-width: 400px;
            width: 100%;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <div class="bg-overlay">
        <!-- Title -->
        <div class="text-center mb-6">
            <h1 class="title-n9">N9</h1>
            <p class="sub-title">HỆ THỐNG QUẢN LÝ</p>
            <p class="sub-title">LỊCH HỌC VÀ THÔNG BÁO CHO HỌC SINH</p>
        </div>

        <!-- Form Login -->
        <div class="login-card">
            {{ $slot }}
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© Bản quyền thuộc N9, Trường Đại học Sư phạm Thành phố Hồ Chí Minh</p>
        <p>Địa chỉ: 280 An Dương Vương, Phường Chợ Quán, Thành phố Hồ Chí Minh</p>
        <p>Điện thoại: 078xxx1230078xxx1230 | Email: abx@gmail.com</p>
    </div>
</body>
</html>