<?php


use App\Http\Controllers\V2\CompanyController;
use App\Http\Controllers\V2\CompanyOfficeController;
use App\Http\Controllers\V2\DepartmentController;
use App\Http\Controllers\V2\SubscriptionController;
use App\Http\Controllers\V2\TeamController;
use Illuminate\Support\Facades\Route;

Route::controller(CompanyController::class)->prefix('companies')->group(function () {
    Route::post('/', 'create')->name('companies.create');

    Route::controller(CompanyController::class)->prefix('{company}')->group(function () {
        Route::put('/', 'addCompanyDetails')->name('companies.update');

        Route::post('/invitees', 'inviteCompanyUsers')->name('companies.invite.users');
        Route::post('/sole-admin', 'soleAdminUser')->name('companies.sole.admin');

        Route::resource('tags', \App\Http\Controllers\TagController::class);
        Route::resource('departments', DepartmentController::class);

        Route::get('departments/{department}/users', [DepartmentController::class, 'getDepartmentUsers'])->name('get.department.users');
        Route::post('/departments/{department}/users', [DepartmentController::class, 'addDepartmentUsers'])->name('add.department.users');

        Route::post('/departments/{department}/teams', [TeamController::class, 'createTeam'])->name('create.team');
        Route::get('/departments/{department}/teams', [TeamController::class, 'getTeams'])->name('get.teams');
        Route::get('/departments/{department}/teams/{team}', [TeamController::class, 'getTeam'])->name('get.team');

        Route::put('/departments/{department}/users/{user}/teams', [TeamController::class, 'updateUserTeams'])->name('change.user.team');

        Route::get('/invitation-link', 'getUserInvitationLink')->name('get.invitation.link');
    })->middleware(['auth:sanctum', 'user-in-company']);





    Route::post('/{company}/subscriptions', [SubscriptionController::class, 'selectSubscriptionPlan'])->name('create.company.subscription');
    Route::get('/{company}/subscriptions', [SubscriptionController::class, 'getSubscriptions'])->name('get.company.subscriptions');
    Route::get('/{company}/subscriptions/{subscription}', [SubscriptionController::class, 'getSubscription'])->name('get.company.subscription');
    Route::resource('{company}/offices', CompanyOfficeController::class)->middleware(['auth:sanctum', 'user-in-company']);
});

Route::post('subscription_payment/{payment:tx_ref}/confirm', [SubscriptionController::class, 'confirmSubscriptionPayment']);
Route::post('confirm-payment', [SubscriptionController::class, 'confirmPayment'])->name('payment-subscription.callback');

// Route for office areas
Route::group(['prefix' => 'offices/{office}', 'middleware' => ['auth:sanctum', 'user-in-company']], function () {
    Route::post('areas', [CompanyOfficeController::class, 'storeOfficeArea']);
    Route::get('areas', [CompanyOfficeController::class, 'getOfficeAreas']);
    Route::put('areas/{officeArea}', [CompanyOfficeController::class, 'updateOfficeArea']);
    Route::delete('areas/{officeArea}', [CompanyOfficeController::class, 'destroyOfficeArea']);
});

//Routes for users
Route::group(['prefix' => 'companies/{company}'], function (){
    Route::controller(CompanyController::class)->group(function (){
        Route::post('/users', 'addCompanyUser')->name('add.company.user');
        Route::get('/users', 'getCompanyUsers')->name('get.company.users');
        Route::delete('/users/{userInvitation}', 'deleteCompanyUser')->name('delete.company.user');
        Route::put('/users/{userInvitation}', 'updateCompanyUser')->name('update.company.user');
    });
});
