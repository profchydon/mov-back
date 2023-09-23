<?php

namespace App\Providers;

use App\Repositories\AssetRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\Contracts\AssetRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use App\Repositories\Contracts\UserCompanyRepositoryInterface;
use App\Repositories\Contracts\UserInvitationRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\TenantRepository;
use App\Repositories\UserCompanyRepository;
use App\Repositories\UserInvitationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(AssetRepositoryInterface::class, AssetRepository::class);
        $this->app->singleton(TenantRepositoryInterface::class, TenantRepository::class);
        $this->app->singleton(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->singleton(UserCompanyRepositoryInterface::class, UserCompanyRepository::class);
        $this->app->singleton(UserInvitationRepositoryInterface::class, UserInvitationRepository::class);
    }
}
