<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleRedirectController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\RoomController;

Route::get('/', function () {
    return view('welcome');
}) ->name('home');

// Route /dashboard redirect theo role
Route::get('/dashboard', [RoleRedirectController::class, 'redirect'])->middleware('auth')->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Điều hướng sau khi login (có thể giữ hoặc xóa nếu đã dùng /dashboard)
Route::get('/redirect', [RoleRedirectController::class, 'redirect'])->middleware('auth');

// Routes dashboard theo vai trò dùng middleware role mới
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Route cho admin tạo users...
});

Route::middleware(['auth', RoleMiddleware::class . ':teacher'])->group(function () {
    Route::get('/teacher/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher.dashboard');
});

Route::middleware(['auth', RoleMiddleware::class . ':student'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('schedules', ScheduleController::class);
});

Route::get('/teachers/by-subject/{subject_id}', [TeacherController::class, 'getBySubject']);

Route::get('/rooms/by-subject/{subjectId}/{classId}', [RoomController::class, 'getBySubject']);

Route::get('/subjects/by-class/{classId}', [ScheduleController::class, 'getSubjectsByClass']);
require __DIR__.'/auth.php';
