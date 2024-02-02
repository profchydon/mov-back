<?php

use App\Http\Controllers\V2\SessionController;
use App\Http\Controllers\V2\UserController;
use App\Http\Controllers\V2\UserInvitationController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::post('/', 'register')->name('create.user');
    Route::get('/{user}', 'find')->name('find.user');
})->middleware(['token.decrypt', 'auth:sanctum', 'payload.decrypt']);

Route::post('/otp', [UserController::class, 'sendOTP'])->middleware(['payload.decrypt'])->name('send.otp');
Route::put('/otp', [UserController::class, 'verifyAccount'])->middleware(['payload.decrypt'])->name('verify.otp');

Route::get('/sessions/authorization', [SessionController::class, 'authorization']);
Route::get('/sessions/confirmation', [SessionController::class, 'confirmation'])->middleware('payload.decrypt');

Route::get('/me', [UserController::class, 'userDetails'])->name('user.details')->middleware(['token.decrypt', 'auth:sanctum']);

Route::controller(UserInvitationController::class)->prefix('users/invitation')->group(function () {
    Route::get('/{code}', 'findUserInvitation')->name('find.user.invitation');
    Route::post('/{code}', 'acceptUserInvitation')->name('accept.user.invitation')->middleware(['payload.decrypt']);
});
