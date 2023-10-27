<?php

use App\Http\Controllers\V2\VendorController;
use Illuminate\Support\Facades\Route;

Route::controller(VendorController::class)->prefix('companies/{company}/vendors')->group(function () {
    Route::post('/', 'create')->name('create.vendor');
    Route::get('/', 'index')->name('list.vendors');
    Route::get('/{vendor}', 'show')->name('get.vendor');
    Route::put('/{vendor}', 'update')->name('update.vendor');
    Route::delete('/{vendor}', 'destroy')->name('delete.vendor');
});
