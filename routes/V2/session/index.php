<?php

use App\Http\Controllers\V2\SessionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['token.decrypt', 'payload.decrypt'])->controller(SessionController::class)->prefix('sessions')->group(function () {
    Route::get('authorization', [SessionController::class, 'authorization'])->name('login.link');
    Route::post('confirmation', [SessionController::class, 'confirmation']);
});
