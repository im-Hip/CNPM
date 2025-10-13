<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# HỆ THỐNG QUẢN LÝ LỊCH HỌC VÀ THÔNG BÁO CHO HỌC SINH

## Giới thiệu
Hệ thống quản lý lịch học và thông báo là một ứng dụng web được phát triển để hỗ trợ việc quản lý lịch học, gửi thông báo và quản lý thông tin giữa học sinh, giáo viên và quản trị viên trong môi trường giáo dục.

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

(gitbash)
git clone https://github.com/[your-username]/CNPM.git
cd CNPM

### Bước 2: Cài đặt PHP dependencies

composer install

### Bước 3: Cài đặt Node.js dependencies

npm install

### Bước 4: Cấu hình môi trường

Copy file môi trường mẫu: cp .env.example .env
Tạo application key: php artisan key:generate

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
    php artisan migrate:fresh
    php artisan db:seed
- Build assets:
    npm run dev
    npm run build
- Tạo symbolic link cho storage:
    php artisan storage:link
- Chạy ứng dụng:
    php artisan serve
    npm run dev

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

php artisan test
php artisan test --coverage

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
