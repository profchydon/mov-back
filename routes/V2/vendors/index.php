<?php

use App\Http\Controllers\V2\VendorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['token.decrypt', 'auth:sanctum',  'payload.decrypt', 'user-in-company'])->controller(VendorController::class)->prefix('companies/{company}/vendors')->group(function () {
    Route::post('/', 'create')->name('create.vendor');
    Route::get('/', 'index')->name('list.vendors');
    Route::get('/{vendor}', 'show')->name('get.vendor');
    Route::put('/{vendor}', 'update')->name('update.vendor');
    Route::delete('/{vendor}', 'destroy')->name('delete.vendor');
});
