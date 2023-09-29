<?php

use App\Http\Controllers\V2\AssetController;
use App\Http\Controllers\V2\AssetTypeController;
use App\Http\Controllers\V2\AssetMaintenanceController;
use Illuminate\Support\Facades\Route;


// Asset
Route::controller(AssetController::class)->prefix('assets')->group(function () {
    Route::post('/', 'create')->name('assets.create');
});


// Asset Type
Route::controller(AssetTypeController::class)->prefix('assets/type')->group(function () {
    Route::post('/', 'create')->name('assets.type.create');
    Route::get('/', 'get')->name('assets.type.get');
});


// Asset Maintenance
Route::controller(AssetMaintenanceController::class)->prefix('assets/maintenance')->group(function () {

});
