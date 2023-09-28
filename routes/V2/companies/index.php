<?php

use App\Http\Controllers\V2\CompanyController;
use App\Http\Controllers\V2\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::controller(CompanyController::class)->prefix('companies')->group(function () {
    Route::post('/', 'create')->name('companies.create');

    Route::controller(CompanyController::class)->prefix('{company}')->group(function () {
        Route::put('/', 'addCompanyDetails')->name('companies.update');

        Route::post('/invitees', 'inviteCompanyUsers')->name('companies.invite.users');
    });

    Route::post('/{company}/subscriptions', [SubscriptionController::class, 'selectSubscriptionPlan']);
});
