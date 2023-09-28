<?php

use App\Http\Controllers\V2\SessionController;
use Illuminate\Support\Facades\Route;

Route::controller(SessionController::class)->prefix('sessions')->group(function () {
    Route::get('authorization', [SessionController::class, 'authorization']);
    Route::get('confirmation', [SessionController::class, 'confirmation']);
});
