<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\NotificationController;

    Route::middleware('auth:api')->group(function () {
        Route::get('/search-recipients', [NotificationController::class, 'searchRecipients'])->name('api.search-recipients');
        Route::get('/api/search-recipients', [NotificationController::class, 'searchRecipients'])->name('api.search-recipients');
    });