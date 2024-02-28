<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['token.decrypt', 'auth:sanctum',  'user-in-company'], 'prefix' => 'companies/{company}'], function(){
    Route::resource('documents', \App\Http\Controllers\V2\DocumentController::class);
    Route::post('/documents/{document}/change-file', [\App\Http\Controllers\V2\DocumentController::class, 'changeFile']);
    Route::post('document-types', [\App\Http\Controllers\V2\DocumentController::class, 'createDocumentType']);
    Route::get('document-types', [\App\Http\Controllers\V2\DocumentController::class, 'getDocumentType']);
    Route::delete('document-types/{type}', [\App\Http\Controllers\V2\DocumentController::class, 'deleteDocumentType']);
});
