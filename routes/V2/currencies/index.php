<?php

use App\Http\Controllers\V2\CurrencyController;
use Illuminate\Support\Facades\Route;

Route::controller(CurrencyController::class)->prefix('currencies')->group(function () {
    Route::get('/', 'index')->name('list.currencies');
});
