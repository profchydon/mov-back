<?php

use App\Http\Controllers\V2\AssetCheckoutController;
use App\Http\Controllers\V2\AssetController;
use App\Http\Controllers\V2\AssetMaintenanceController;
use App\Http\Controllers\V2\AssetTypeController;
use Illuminate\Support\Facades\Route;

// Asset
Route::middleware(['token.decrypt', 'auth:sanctum', 'payload.decrypt', 'user-in-company'])->controller(AssetController::class)->prefix('companies')->group(function () {
    Route::post('{company}/assets', 'create')->name('create.company.asset');
    Route::post('{company}/assets/csv-upload', 'createFromCSV(')->name('create.company.csv-upload.assets');
    Route::post('{company}/assets/bulk', 'createBulk')->name('create.company.bulk.assets');
    Route::get('{company}/assets/csv-upload', 'getBulkDownloadTemplate')->name('get-template.company.bulk.assets')->withoutMiddleware(\App\Http\Middleware\NormalizeResponseForFrontEndMiddleware::class);
    Route::get('{company}/assets', 'get')->name('get.company.assets');
    Route::get('{company}/assets/{asset}/checkouts', [AssetCheckoutController::class, 'getAssetCheckouts']);
    Route::get('{company}/assets/{asset}/maintenance', [AssetMaintenanceController::class, 'getAssetMaintenance']);

    Route::get('{company}/assets/{asset}', 'getAsset')->name('get.company.asset');
    Route::delete('{company}/assets/{asset}', 'deleteAsset')->name('delete.company.asset');
    Route::patch('{company}/assets', 'updateMultipleAsset')->name('update.multiple.company.asset');
    Route::patch('{company}/assets/{asset}', 'updateAsset')->name('update.company.asset')->withoutMiddleware(['payload.decrypt']);
    Route::post('{company}/assets/{asset}/image', 'uploadAssetImage')->name('update.company.asset.image')->withoutMiddleware(['payload.decrypt']);
    Route::get('{company}/assets/{asset}/users/{user}/assign', 'assignAsset')->name('assign.company.asset');
    Route::get('{company}/assets/{asset}/users/{user}/unassign', 'unAssignAsset')->name('unassign.company.asset');
    Route::post('{company}/assets/{asset}/assign', 'reAssignAsset')->name('reassign.company.asset');

    Route::post('{company}/assets/reassign', 'reassignMultipleAsset')->name('reassign.multiple.company.asset');


    Route::get('{company}/asset-overview/{asset}', 'getAssetOverview')->name('get.asset.overview');

    Route::get('{company}/asset-makes', 'getAssetMakes')->name('get.asset.makes');

    Route::post('{company}/stolen-assets', 'markAssetAsStolen')->name('mark.stolen.asset')->withoutMiddleware(['payload.decrypt']);
    Route::get('{company}/stolen-assets', 'getStolenAssets')->name('get.stolen.asset');
    Route::post('{company}/damaged-assets', 'markAssetAsDamaged')->name('mark.damaged.asset')->withoutMiddleware(['payload.decrypt']);
    Route::get('{company}/damaged-assets', 'getDamagedAssets')->name('get.damaged.asset');
    Route::post('{company}/retired-assets', 'markAssetAsRetired')->name('mark.retired.asset');
});


// Asset Type
Route::middleware(['token.decrypt', 'auth:sanctum', 'payload.decrypt', 'user-in-company'])->controller(AssetTypeController::class)->prefix('assets/type')->group(function () {
    Route::post('/', 'create')->name('assets.type.create');
    Route::get('/', 'get')->name('assets.type.get');
});


// Asset Maintenance
Route::controller(AssetMaintenanceController::class)->prefix('assets/maintenance')->group(function () {
})->middleware(['token.decrypt', 'auth:sanctum', 'payload.decrypt', 'user-in-company']);

Route::get('companies/{company}/asset-checkouts/group/{groupId}', [AssetCheckoutController::class, 'getGroupAssetCheckout'])->middleware(['token.decrypt', 'payload.decrypt', 'auth:sanctum', 'user-in-company']);
Route::get('companies/{company}/asset-checkouts', [AssetCheckoutController::class, 'index']); //->middleware(['token.decrypt', 'payload.decrypt', 'auth:sanctum', 'user-in-company']);
Route::post('companies/{company}/asset-checkouts', [AssetCheckoutController::class, 'store'])->middleware(['token.decrypt', 'payload.decrypt', 'auth:sanctum', 'user-in-company']);
Route::post('companies/{company}/asset-checkouts/group/{groupId}/return', [AssetCheckoutController::class, 'returnAssetsInGroup'])->middleware(['token.decrypt', 'payload.decrypt', 'auth:sanctum', 'user-in-company']);
Route::post('companies/{company}/asset-maintenances', [AssetMaintenanceController::class, 'store'])->middleware(['token.decrypt', 'payload.decrypt', 'auth:sanctum', 'user-in-company']);
Route::get('companies/{company}/asset-maintenances', [AssetMaintenanceController::class, 'index'])->middleware(['token.decrypt', 'payload.decrypt', 'auth:sanctum', 'user-in-company']);
Route::middleware(['token.decrypt', 'auth:sanctum', 'payload.decrypt'])->controller(AssetMaintenanceController::class)->prefix('assets/maintenance')->group(function () {
});

//Route::middleware(['auth:sanctum'])->resource('asset-checkouts', \App\Http\Controllers\V2\AssetCheckoutController::class);
