<?php

use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function(){
    Route::post('/', function(){
        return 'end-point to create users';
    })->name('users.create');
});
