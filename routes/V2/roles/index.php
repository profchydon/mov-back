<?php

use App\Http\Controllers\V2\RoleController;
use Illuminate\Support\Facades\Route;

Route::controller(RoleController::class)->prefix('companies/{company}')->group(function () {
    Route::get('/user-roles', 'fetchUserRoles')->name('fetch.user.roles');
});
