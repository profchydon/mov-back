<?php

use App\Http\Controllers\V2\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['token.decrypt','auth:sanctum', 'user-in-company'])->controller(RoleController::class)->prefix('companies/{company}')->group(function () {
    Route::get('/user-roles', 'fetchUserRoles')->name('fetch.user.roles')->withoutMiddleware(['auth:sanctum', 'user-in-company']);
    Route::post('/user-roles', 'createUserRole')->name('create.user.role');
    Route::get('/user-roles/{role}', 'fetchRoleDetails')->name('fetch.user.role');
    Route::put('/user-roles/{role}', 'updateRole')->name('update.user.role');
});

Route::get('/permissions', [RoleController::class, 'fetchPermissions'])->name('fetch.permissions')->middleware(['token.decrypt','auth:sanctum']);
