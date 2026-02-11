<?php

use App\Http\Controllers\V2\SessionController;
use App\Http\Controllers\V2\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(SessionController::class)->prefix('sessions')->group(function () {
    Route::get('authorization', [SessionController::class, 'authorization'])->name('login.link');
    Route::post('confirmation', [SessionController::class, 'confirmation'])->middleware(['payload.decrypt']);
});

Route::controller(SessionController::class)->group(function () {
    Route::post('sessions/auth/login', 'login')
        ->middleware(['payload.decrypt'])
        ->name('auth.login');
});
