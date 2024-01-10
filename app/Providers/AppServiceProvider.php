<?php

namespace App\Providers;

use App\Models\User;
use App\Services\Contracts\SSOServiceInterface;
use App\Services\V2\SSOService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(SSOServiceInterface::class, SSOService::class);

        Relation::morphMap([
            'user' => User::class,
        ]);
    }
}
