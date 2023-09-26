<?php

use App\Http\Controllers\V2\CompanyController;
use Illuminate\Support\Facades\Route;

Route::controller(CompanyController::class)->prefix('companies')->group(function () {
    Route::post('/', 'create')->name('companies.create');

    Route::post('/{company}/invitees', 'inviteCompanyUsers')->name('companies.invite.users');
});
