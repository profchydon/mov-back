<?php

namespace App\Providers;

use App\Repositories\AssetMakeRepository;
use App\Repositories\AssetRepository;
use App\Repositories\AssetTypeRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\Contracts\AssetCheckoutRepositoryInterface;
use App\Repositories\Contracts\AssetMakeRepositoryInterface;
use App\Repositories\Contracts\AssetRepositoryInterface;
use App\Repositories\Contracts\AssetTypeRepositoryInterface;
use App\Repositories\Contracts\CompanyOfficeRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\FeatureRepositoryInterface;
use App\Repositories\Contracts\FileRepositoryInterface;
use App\Repositories\Contracts\OTPRepositoryInterface;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\PlanRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use App\Repositories\Contracts\UserCompanyRepositoryInterface;
use App\Repositories\Contracts\UserInvitationRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\FeatureRepository;
use App\Repositories\FileRepository;
use App\Repositories\OTPRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\PlanRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SubscriptionRepository;
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
        $this->app->singleton(AssetTypeRepositoryInterface::class, AssetTypeRepository::class);
        $this->app->singleton(TenantRepositoryInterface::class, TenantRepository::class);
        $this->app->singleton(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->singleton(UserCompanyRepositoryInterface::class, UserCompanyRepository::class);
        $this->app->singleton(UserInvitationRepositoryInterface::class, UserInvitationRepository::class);
        $this->app->singleton(OTPRepositoryInterface::class, OTPRepository::class);
        $this->app->singleton(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->singleton(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);
        $this->app->singleton(AssetTypeRepositoryInterface::class, AssetTypeRepository::class);
        $this->app->singleton(CompanyOfficeRepositoryInterface::class, CompanyRepository::class);
        $this->app->singleton(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->singleton(FeatureRepositoryInterface::class, FeatureRepository::class);
        $this->app->singleton(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->singleton(AssetMakeRepositoryInterface::class, AssetMakeRepository::class);
        $this->app->singleton(FileRepositoryInterface::class, FileRepository::class);
        $this->app->singleton(AssetCheckoutRepositoryInterface::class, AssetRepository::class);
    }
}
