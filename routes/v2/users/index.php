<?php

use App\Http\Controllers\v2\SessionController;
use App\Http\Controllers\v2\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->prefix('users')->group(function(){
    Route::post('/', 'register')->name('users.create');
});

Route::get('/sessions/authorization', [SessionController::class, 'authorization']);
Route::get('/sessions/confirmation', [SessionController::class, 'confirmation']);