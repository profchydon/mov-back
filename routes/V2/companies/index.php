<?php

use App\Http\Controllers\TagController;
use App\Http\Controllers\V2\CompanyController;
use App\Http\Controllers\V2\CompanyOfficeController;
use App\Http\Controllers\V2\DepartmentController;
use App\Http\Controllers\V2\InvoiceController;
use App\Http\Controllers\V2\SeatController;
use App\Http\Controllers\V2\SubscriptionController;
use App\Http\Controllers\V2\TeamController;
use Illuminate\Support\Facades\Route;


// Route::post('companies/{company}/assets/{asset}/assign-tags', [\App\Http\Controllers\AssetTagController::class, 'assign'])->middleware(['token.decrypt', 'auth:sanctum', 'user-in-company']);
// Route::delete('companies/{company}/assets/{asset}/unassign-tags', [\App\Http\Controllers\AssetTagController::class, 'unassign'])->middleware(['token.decrypt', 'auth:sanctum', 'user-in-company']);


Route::controller(CompanyController::class)->prefix('companies')->group(function () {
    Route::post('/', 'create')->name('companies.create')->middleware(['payload.decrypt']);
    Route::put('{company}', 'addCompanyDetails')->name('companies.update')->middleware(['payload.decrypt']);
    Route::post('{company}/invitees', 'inviteCompanyUsers')->name('companies.invite.users')->middleware(['payload.decrypt']);
    Route::post('{company}/sole-admin', 'soleAdminUser')->name('companies.sole.admin');

    // Route::controller(CompanyController::class)->prefix('{company}')->middleware(['token.decrypt', 'payload.decrypt', 'auth:sanctum', 'user-in-company'])->group(function () {
    //     // Route::resource('tags', TagController::class);
    //     // Route::delete('tags', [TagController::class, 'destroyMany']);
    //     // Route::post('tags/{tag}/assign-assets', [TagController::class, 'assignAssets']);
    //     // Route::post('tags/{tag}/unassign-assets', [TagController::class, 'unAssignAssets']);

    //     Route::post('tags', [TagController::class, 'store']);
    //     Route::get('tags', [TagController::class, 'index']);
    //     Route::get('tags/{tag}', [TagController::class, 'show']);
    //     Route::put('tags/{tag}', [TagController::class, 'update']);
    //     Route::delete('tags', [TagController::class, 'destroyMany']);
    //     Route::post('tags/{tag}/assign-assets', [TagController::class, 'assignAssets']);
    //     Route::post('tags/{tag}/unassign-assets', [TagController::class, 'unAssignAssets']);
    // });

    Route::controller(CompanyController::class)->prefix('{company}')->middleware(['token.decrypt', 'auth:sanctum', 'payload.decrypt', 'user-in-company'])->group(function () {
        Route::resource('tags', TagController::class);
        Route::delete('tags', [TagController::class, 'destroyMany']);
        Route::post('tags/{tag}/assign-assets', [TagController::class, 'assignAssets']);
        Route::post('tags/{tag}/unassign-assets', [TagController::class, 'unAssignAssets']);
        Route::resource('departments', DepartmentController::class);
        Route::resource('insurances', \App\Http\Controllers\V2\InsuranceController::class);
        Route::post('insurances/{insurance}/assets', [\App\Http\Controllers\V2\InsuranceController::class, 'insureAssets']);

        Route::post('seats', [SeatController::class, 'store']);
        Route::get('seats', [SeatController::class, 'index']);
        Route::delete('seats', [SeatController::class, 'delete']);

        Route::get('departments/{department}/users', [DepartmentController::class, 'getDepartmentUsers'])->name('get.department.users');
        Route::post('/departments/{department}/users', [DepartmentController::class, 'addDepartmentUsers'])->name('add.department.users');

        Route::post('/departments/{department}/teams', [TeamController::class, 'createTeam'])->name('create.team');
        Route::get('/departments/{department}/teams', [TeamController::class, 'getTeams'])->name('get.teams');
        Route::post('/departments/teams/group', [TeamController::class, 'getTeamsInDepts'])->name('get.teams.in.depts');
        Route::get('/departments/{department}/teams/{team}', [TeamController::class, 'getTeam'])->name('get.team');


        Route::put('/departments/{department}/users/{user}/teams', [TeamController::class, 'updateUserTeams'])->name('change.user.team');

        Route::get('/invitation-link', 'getUserInvitationLink')->name('get.invitation.link');

        Route::get('/invoices', [InvoiceController::class, 'index']);
        Route::get('/invoices/{invoice:invoice_number}', [InvoiceController::class, 'show']);
        Route::get('/invoices/{invoice:invoice_number}/pdf', [InvoiceController::class, 'showPDF']);
    });

    Route::post('/{company}/subscriptions', [SubscriptionController::class, 'selectSubscriptionPlan'])->middleware(['payload.decrypt'])->name('create.company.subscription');
    Route::get('/{company}/subscriptions', [SubscriptionController::class, 'getSubscriptions'])->middleware(['payload.decrypt'])->name('get.company.subscriptions');
    Route::get('/{company}/active-subscription', [SubscriptionController::class, 'getActiveSubscription'])->middleware(['payload.decrypt'])->name('get.company.active-subscription');
    Route::get('/{company}/subscriptions/{subscription}', [SubscriptionController::class, 'getSubscription'])->middleware(['payload.decrypt'])->name('get.company.subscription');
    Route::post('/{company}/subscriptions/{subscription}/add-ons', [SubscriptionController::class, 'addAddonsToSubscription'])->middleware(['payload.decrypt'])->name('get.company.subscription');
    Route::post('{company}/subscriptions/change', [SubscriptionController::class, 'upgradeSubscription'])->middleware(['token.decrypt', 'auth:sanctum',  'payload.decrypt',  'user-in-company']);
    Route::post('{company}/subscriptions/upgrade', [SubscriptionController::class, 'upgradeSubscription'])->middleware(['token.decrypt', 'auth:sanctum',  'payload.decrypt',  'user-in-company']);
    Route::post('{company}/subscriptions/downgrade', [SubscriptionController::class, 'downgradeSubscription'])->middleware(['token.decrypt', 'auth:sanctum',  'payload.decrypt',  'user-in-company']);

    Route::resource('{company}/offices', CompanyOfficeController::class)->middleware(['auth:sanctum', 'user-in-company']);
    Route::middleware(['token.decrypt', 'payload.decrypt', 'auth:sanctum'])->resource('{company}/offices', CompanyOfficeController::class);
    Route::get('{company}/dashboard', [\App\Http\Controllers\V2\DashboardController::class, 'index'])->middleware(['token.decrypt', 'payload.decrypt']);
});

Route::post('invoice_payment/{payment:tx_ref}/confirm', [SubscriptionController::class, 'confirmInvoicePayment']);
Route::post('subscription_payment/{payment:tx_ref}/confirm', [SubscriptionController::class, 'confirmSubscriptionPayment']);
Route::get('confirm-usd-payment', [SubscriptionController::class, 'confirmPayment'])->name('payment-subscription.callback')->middleware(['payload.decrypt']);

Route::group(['prefix' => 'offices/{office}', 'middleware' => ['token.decrypt', 'auth:sanctum',  'payload.decrypt', 'user-in-company']], function () {
    Route::post('areas', [CompanyOfficeController::class, 'storeOfficeArea']);
    Route::get('areas', [CompanyOfficeController::class, 'getOfficeAreas']);
    Route::put('areas/{officeArea}', [CompanyOfficeController::class, 'updateOfficeArea']);
    Route::delete('areas/{officeArea}', [CompanyOfficeController::class, 'destroyOfficeArea']);
    Route::post('assignment', [CompanyOfficeController::class, 'assignUserToOffice']);
    Route::delete('assignment', [CompanyOfficeController::class, 'unassignUserFromOffice']);
});

Route::delete('companies/{company}/users/{user}', [CompanyController::class, 'deleteCompanyUser'])->middleware(['token.decrypt', 'auth:sanctum', 'user-in-company'])->name('delete.company.user');

//Routes for users
Route::group(['prefix' => 'companies/{company}', 'middleware' => ['token.decrypt', 'auth:sanctum',  'payload.decrypt', 'user-in-company']], function () {
    Route::controller(CompanyController::class)->group(function () {
        Route::post('/users', 'addCompanyUser')->name('add.company.user');
        Route::get('/users', 'getCompanyUsers')->name('get.company.users');
        Route::get('/users/{user}', 'getCompanyUserDetails')->name('get.company.user');
        Route::put('/users/{user}', 'updateCompanyUser')->name('update.company.user');
        // Route::delete('/users/{user}', 'deleteCompanyUser')->name('delete.company.user');
        Route::delete('/users', 'deleteCompanyUsers')->name('delete.company.users');
        Route::post('/users/{user}/suspend', 'suspendCompanyUser')->name('suspend.company.user');
        Route::post('/users/{user}/unsuspend', 'unSuspendCompanyUser')->name('unsuspend.company.user');
        Route::post('/users/suspend', 'suspendCompanyUsers')->name('suspend.company.users');
        Route::post('/users/unsuspend', 'unSuspendCompanyUsers')->name('unsuspend.company.users');

        // Route::put('/users/{userInvitation}', 'updateCompanyUser')->name('update.company.user');
    });
});
