<?php

namespace App\Providers;

use App\Events\user\UserCreatedEvent;
use App\Events\user\UserDeactivatedEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Events\company\CompanyCreatedEvent;
use App\Listeners\user\UserCreatedListener;
use App\Listeners\company\CompanyCreatedListener;
use App\Events\subscription\SubscriptionActivatedEvent;
use App\Listeners\subscription\SubscriptionActivatedListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserCreatedEvent::class => [
            UserCreatedListener::class
        ],
        UserDeactivatedEvent::class => [
            UserCreatedListener::class
        ],
        CompanyCreatedEvent::class => [
            CompanyCreatedListener::class
        ],
        SubscriptionActivatedEvent::class => [
            SubscriptionActivatedListener::class
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
