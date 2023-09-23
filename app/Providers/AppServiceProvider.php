<?php

namespace App\Providers;

use App\Services\Contracts\SsoServiceInterface;
use App\Services\v2\SsoService;
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
        $this->app->singleton(SsoServiceInterface::class, SsoService::class);
    }
}
