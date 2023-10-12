<?php

use Illuminate\Support\Facades\Route;

Route::resource('features', \App\Http\Controllers\V2\FeatureController::class);


// Route::controller(FeatureController::class)->prefix('features')->group(function () {
//     Route::post('/', 'register')->name('create.user');
//     Route::get('/{user}', 'find')->name('find.user');
// });
