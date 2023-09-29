<?php

use App\Http\Controllers\V2\SessionController;
use App\Http\Controllers\V2\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::post('/', 'register')->name('users.create');
});

Route::post('/otp', [UserController::class, 'sendOTP'])->name('send.otp');
Route::put('/otp', [UserController::class, 'verifyAccount'])->name('verify.otp');

Route::get('/sessions/authorization', [SessionController::class, 'authorization']);
Route::get('/sessions/confirmation', [SessionController::class, 'confirmation']);
