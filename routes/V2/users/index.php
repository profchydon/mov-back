<?php

use App\Http\Controllers\V2\SessionController;
use App\Http\Controllers\V2\UserController;
use App\Http\Controllers\V2\UserInvitationController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::post('/', 'register')->name('create.user');
    Route::get('/{user}', 'find')->name('find.user');
});

Route::post('/otp', [UserController::class, 'sendOTP'])->name('send.otp');
Route::put('/otp', [UserController::class, 'verifyAccount'])->name('verify.otp');

Route::get('/sessions/authorization', [SessionController::class, 'authorization']);
Route::get('/sessions/confirmation', [SessionController::class, 'confirmation']);

Route::middleware('auth:sanctum')->get('/me', [UserController::class, 'userDetails'])->name('user.details');


Route::controller(UserInvitationController::class)->prefix('users/invitation')->group(function () {
    Route::get('/{code}', 'findUserInvitation')->name('find.user.invitation');
    Route::post('/{code}', 'acceptUserInvitation')->name('accept.user.invitation');
});
