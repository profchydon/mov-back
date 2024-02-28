<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['token.decrypt', 'auth:sanctum',  'user-in-company'], 'prefix' => 'companies/{company}'], function(){
    Route::resource('documents', \App\Http\Controllers\V2\DocumentController::class);
    Route::post('/documents/{document}/change-file', [\App\Http\Controllers\V2\DocumentController::class, 'changeFile']);
});
