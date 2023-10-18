<?php

use App\Http\Controllers\V2\AssetController;
use App\Http\Controllers\V2\AssetMaintenanceController;
use App\Http\Controllers\V2\AssetTypeController;
use Illuminate\Support\Facades\Route;

// Asset
Route::controller(AssetController::class)->prefix('companies')->group(function () {
    Route::post('{company}/assets', 'create')->name('create.company.asset');
    Route::post('{company}/assets/bulk', 'createBulk')->name('create.company.bulk.assets');
    Route::get('{company}/assets/bulk', 'getBulkDownloadTemplate')->name('get-template.company.bulk.assets')->withoutMiddleware(\App\Http\Middleware\NormalizeResponseForFrontEndMiddleware::class);
    Route::get('{company}/assets', 'get')->name('get.company.assets');

    Route::get('{company}/assets/{asset}', 'getAsset')->name('get.company.asset');
    Route::delete('{company}/assets/{asset}', 'deleteAsset')->name('delete.company.asset');
    Route::patch('{company}/assets/{asset}', 'updateAsset')->name('update.company.asset');

    Route::get('{company}/asset-makes', 'getAssetMakes')->name('get.asset.makes');
});


// Asset Type
Route::controller(AssetTypeController::class)->prefix('assets/type')->group(function () {
    Route::post('/', 'create')->name('assets.type.create');
    Route::get('/', 'get')->name('assets.type.get');
});


// Asset Maintenance
Route::controller(AssetMaintenanceController::class)->prefix('assets/maintenance')->group(function () {
});

Route::resource('asset-checkouts', \App\Http\Controllers\V2\AssetCheckoutController::class);
