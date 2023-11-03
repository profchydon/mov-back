<?php

use App\Http\Controllers\V2\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->controller(RoleController::class)->prefix('companies/{company}')->group(function () {
    Route::get('/user-roles', 'fetchUserRoles')->name('fetch.user.roles')->withoutMiddleware(['auth:sanctum']);
    Route::post('/user-roles', 'createUserRole')->name('create.user.role');
});

Route::get('/permissions', [RoleController::class, 'fetchPermissions'])->name('fetch.permissions');
