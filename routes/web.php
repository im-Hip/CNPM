<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StatisticsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleRedirectController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\TeacherAssignmentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome'); // Hiển thị trang chủ
})->name('home');

// Auth middleware group (chung cho tất cả user: student/teacher/admin)
Route::middleware(['auth'])->group(function () {
    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::get('/notifications/history', [NotificationController::class, 'history'])->name('notifications.history');
    Route::get('/search-recipients', [NotificationController::class, 'searchRecipients'])->name('search-recipients');
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::get('/notifications/{id}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');
    Route::put('/notifications/{id}', [NotificationController::class, 'update'])->name('notifications.update');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Dashboard chung
    Route::get('/dashboard', function () {
        return redirect()->route('notifications.index');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Assignment routes
    Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');

    // Schedule index (xem lịch cho tất cả user)
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');

    Route::get('/schedules/export/pdf/{class_id?}', [ScheduleController::class, 'exportPdf'])->name('schedules.export.pdf');
    Route::get('/schedules/teacher/export/pdf', [ScheduleController::class, 'exportTeacherPdf'])->name('schedules.teacher.export.pdf');
});

// Profile routes (auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role redirect (auth)
Route::get('/redirect', [RoleRedirectController::class, 'redirect'])->middleware('auth');

// Admin-specific routes (users)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/statistics', [StatisticsController::class, 'index'])->name('admin.statistics');
});

// Admin Schedule management (CRUD + AJAX + API)
Route::middleware(['auth', 'isAdmin'])->group(function () {
    // Full page CRUD
    Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    
    // Inline AJAX
    Route::post('/schedules/add', [ScheduleController::class, 'storeInline'])->name('schedules.store-inline');
    Route::post('/schedules/{schedule}/update', [ScheduleController::class, 'updateInline'])->name('schedules.update-inline');
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroyInline'])->name('schedules.destroy-inline');

    // Edit/Update
    Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
    
    // Delete
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

    // API for options
    Route::get('/api/subjects/{class_id}', [ScheduleController::class, 'getSubjectsForClass'])->name('api.subjects-per-class');
    Route::get('/api/teacher/{class_id}/{subject_id}', [ScheduleController::class, 'getTeacherForClassSubject'])->name('api.teacher-per-class-subject');
    Route::get('/api/rooms', [ScheduleController::class, 'getAvailableRooms'])->name('api.rooms'); // Sửa để dùng getAvailableRooms
});

// Teacher Assignment routes (admin only – resource đầy đủ)
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('teacher_assignments', TeacherAssignmentController::class);
});

// Logout (custom – không conflict với auth.php)
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'Logged out successfully.');
})->name('logout');

// CRUD subject
Route::resource('subjects', SubjectController::class);

// Học sinh upload file
Route::post('/assignments/{id}/upload', [AssignmentController::class, 'uploadFile'])->name('assignments.upload');

// Hiển thị danh sách học sinh đã nộp bài
Route::get('/assignments/{id}', [AssignmentController::class, 'show'])->name('assignments.show');

// Điều hướng khi người dùng bấm vào nút exam
Route::get('/exam-redirect', function () {
    $user = Auth::user();

    if ($user->role === 'teacher') {
        return redirect()->route('assignments.create');
    }

    if ($user->role === 'student') {
        return redirect()->route('assignments.index');
    }

    return redirect('/dashboard');
})->middleware('auth')->name('exam.redirect');

// Auth routes (Breeze/Jetstream – handle login/register/logout)
require __DIR__.'/auth.php';