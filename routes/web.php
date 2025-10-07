<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
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
    return view('welcome');         //hien thi trang chu
})->name('home');

// Auth middleware group (chung cho tất cả user: student/teacher/admin)
Route::middleware(['auth'])->group(function () {
    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::get('/notifications/history', [NotificationController::class, 'history'])->name('notifications.history');
    Route::get('/search-recipients', [NotificationController::class, 'searchRecipients'])->name('search-recipients');

    // Dashboard chung
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Assignment routes
    Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
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
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
});

// Admin Schedule management (CRUD + AJAX + API) – Giữ cũ
Route::middleware(['auth', 'isAdmin'])->group(function () {
    // New: Full page CRUD
    Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    
    // Inline AJAX (giữ nếu muốn, hoặc xóa)
    Route::post('/schedules/add', [ScheduleController::class, 'storeInline'])->name('schedules.store-inline');
    Route::post('/schedules/{schedule}/update', [ScheduleController::class, 'updateInline'])->name('schedules.update-inline');
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroyInline'])->name('schedules.destroy-inline');
    // THÊM MỚI: Edit/Update
    Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
    
    // THÊM MỚI: Delete
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
    // API for options (giữ)
    Route::get('/api/subjects/{class_id}', [ScheduleController::class, 'getSubjectsForClass'])->name('api.subjects-per-class');
    Route::get('/api/teacher/{class_id}/{subject_id}', [ScheduleController::class, 'getTeacherForClassSubject'])->name('api.teacher-per-class-subject');
    Route::get('/api/rooms', function () { 
        return response()->json(\App\Models\Room::all(['id', 'name'])); 
    })->name('api.rooms');
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

Route::resource('subjects', SubjectController::class);

// Auth routes (Breeze/Jetstream – handle login/register/logout)
require __DIR__.'/auth.php';
