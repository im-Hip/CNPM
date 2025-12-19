<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\NotificationController;
    
    Route::get('/search-recipients', [NotificationController::class, 'searchRecipients']);

