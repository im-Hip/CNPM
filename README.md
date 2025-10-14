<div align="center">

# HỆ THỐNG QUẢN LÝ LỊCH HỌC VÀ THÔNG BÁO CHO HỌC SINH

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/TailwindCSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="TailwindCSS">
</p>


</div>

## Giới thiệu
Hệ thống quản lý lịch học và thông báo là một ứng dụng web được phát triển để hỗ trợ việc quản lý lịch học, gửi thông báo và quản lý thông tin giữa học sinh, giáo viên và quản trị viên trong môi trường giáo dục.

### Mục Tiêu
- Số hóa quy trình quản lý lịch học
- Tăng hiệu quả giao tiếp trong trường học
- Giảm thời gian xử lý công việc
- Cung cấp thông tin real-time cho người dùng

### Tính năng chính:
- **Quản lý người dùng**: Tạo và quản lý tài khoản cho admin, giáo viên, học sinh
- **Quản lý lịch học**: Xếp lịch, xem lịch học/dạy học
- **Quản lý môn học**: Thêm, xoá, sửa thông tin môn học
- **Phân công giáo viên**: Phân công giáo viên cho các lớp và môn học
- **Quản lý bài tập**: Giao và theo dõi bài tập
- **Hệ thống thông báo**: Gửi thông báo theo nhóm hoặc cá nhân

## Công nghệ sử dụng

### Backend
- **Language**: PHP
- **Framework**: Laravel
- **Database**: MySQL
- **Session Management**: Database-based sessions

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: TailwindCSS
- **Build Tool**: Vite

### Development Environment
- **Local Server**: Laragon / XAMPP / Docker
- **Code Editor**: VSCode
- **Version Control**: Git & GitHub

## Yêu cầu hệ thống

- PHP >= 8.1
- Composer >= 2.0
- Node.js >= 16.x & NPM >= 8.x
- MySQL >= 5.7
- Git

## Hướng dẫn cài đặt

### Bước 1: Clone repository

- git clone https://github.com/[your-username]/CNPM.git (gitbash)
- cd CNPM

### Bước 2: Cài đặt PHP dependencies

- composer install

### Bước 3: Cài đặt Node.js dependencies

- npm install

### Bước 4: Cấu hình môi trường

- Copy file môi trường mẫu: cp .env.example .env
- Tạo application key: php artisan key:generate

### Bước 5: Cấu hình database

- Tạo database mới trong MySQL: CREATE DATABASE quanlylichhoc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
- Cập nhật thông tin database trong file .env:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=quanlylichhoc
    DB_USERNAME=root
    DB_PASSWORD=
- Chạy migrations và seeders:
    php artisan migrate:fresh và php artisan db:seed
- Build assets:
    npm run dev và npm run build
- Tạo symbolic link cho storage:
    php artisan storage:link
- Chạy ứng dụng:
    php artisan serve và npm run dev

## Biến môi trường

APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=[http://localhost:8000](http://cnpm.test)

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quanlylichhoc
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password

## Testing

- php artisan test
- php artisan test --coverage
