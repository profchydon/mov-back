<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => [], 'prefix' => 'companies/{company}'], function(){
    Route::resource('documents', \App\Http\Controllers\V2\DocumentController::class);
    Route::post('/documents/{document}/change-file', [\App\Http\Controllers\V2\DocumentController::class, 'changeFile']);
});
