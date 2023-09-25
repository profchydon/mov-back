<?php

namespace App\Providers;

use App\Services\Contracts\SSOServiceInterface;
use App\Services\v2\SSOService;
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
    }
}
