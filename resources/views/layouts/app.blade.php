<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Hệ Thống Quản Lý Lịch Học')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --sidebar-width: 20%;
            --main-width: 80%;
        }
        
        @media (min-width: 1024px) {
            .sidebar-container {
                width: var(--sidebar-width);
                display: block;
            }
            .main-container {
                width: var(--main-width);
                padding: 1.5rem;
            }
            .mobile-menu-button {
                display: none;
            }
            .close-sidebar-btn {
                display: none;
            }
        }
        
        @media (min-width: 768px) and (max-width: 1023px) {
            .sidebar-container {
                width: 250px;
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                z-index: 40;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar-container.active {
                transform: translateX(0);
            }
            .main-container {
                width: 100%;
                margin-left: 0;
                padding: 1.5rem;
                padding-top: 4rem;
            }
            .overlay {
                display: none;
                position: fixed;
                inset: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 30;
            }
            .overlay.active {
                display: block;
            }
            .close-sidebar-btn {
                display: block;
            }
        }
        
        @media (max-width: 767px) {
            .sidebar-container {
                width: 280px;
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar-container.active {
                transform: translateX(0);
            }
            .main-container {
                width: 100%;
                padding: 1rem;
                padding-top: 4rem;
            }
            .overlay {
                display: none;
                position: fixed;
                inset: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }
            .overlay.active {
                display: block;
            }
            .close-sidebar-btn {
                display: block;
            }
        }
        
        .mobile-menu-button {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 60;
            padding: 0.5rem;
            background-color: white;
            border-radius: 0.375rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        }
        
        @media (max-width: 1023px) {
            .mobile-menu-button {
                display: block;
            }
        }
        
        .sidebar-container, .overlay {
            transition: transform 0.3s ease;
        }
        
        @media (max-width: 640px) {
            .notification-header {
                flex-direction: column;
                gap: 0.75rem;
                padding: 0.75rem 1rem;
            }
            
            .search-container {
                width: 100%;
            }
            
            #searchInput {
                width: 100%;
            }
            
            .notification-item {
                padding: 0.75rem;
            }
            
            .notification-item h3 {
                font-size: 1rem;
            }
            
            .notification-item .text-sm {
                font-size: 0.75rem;
            }
        }
        
        @media (max-width: 380px) {
            .sidebar-container {
                width: 100%;
            }
            
            .main-container {
                padding: 0.75rem;
                padding-top: 3.5rem;
            }
            
            h1 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">

    <button class="mobile-menu-button" onclick="toggleSidebar()">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
    
    <div class="overlay" onclick="closeSidebar()"></div>
    
    <div class="flex min-h-screen">
        <aside class="sidebar-container bg-white shadow-lg relative w-1/5">
            <button class="close-sidebar-btn absolute top-4 right-4 p-2 z-10" onclick="closeSidebar()" style="display: none;">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            @include('layouts.navigation')
        </aside>

        <main class="main-container w-4/5 p-6">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar-container');
            const overlay = document.querySelector('.overlay');
            const closeBtn = document.querySelector('.close-sidebar-btn');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            
            if (sidebar.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }
        
        function closeSidebar() {
            const sidebar = document.querySelector('.sidebar-container');
            const overlay = document.querySelector('.overlay');
            const closeBtn = document.querySelector('.close-sidebar-btn');
            
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            closeBtn.style.display = 'none';
            document.body.style.overflow = '';
        }
        
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar-container');
            const menuButton = document.querySelector('.mobile-menu-button');
            
            if (window.innerWidth <= 1023 && sidebar.classList.contains('active')) {
                if (!sidebar.contains(event.target) && !menuButton.contains(event.target)) {
                    closeSidebar();
                }
            }
        });
        
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth > 1023) {
                    closeSidebar();
                    document.querySelector('.close-sidebar-btn').style.display = 'none';
                }
            }, 250);
        });
        
        if (window.innerWidth <= 1023) {
            document.querySelectorAll('.sidebar-container a').forEach(link => {
                link.addEventListener('click', function() {
                    setTimeout(closeSidebar, 100);
                });
            });
        }
        
        window.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth > 1023) {
                document.querySelector('.close-sidebar-btn').style.display = 'none';
            }
        });
    </script>
</body>
</html>