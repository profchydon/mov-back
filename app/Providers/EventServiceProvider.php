<?php

namespace App\Providers;

use App\Events\Company\CompanyCreatedEvent;
use App\Events\Subscription\SubscriptionActivatedEvent;
use App\Events\Subscription\SubscriptionChangedEvent;
use App\Events\User\UserCreatedEvent;
use App\Events\User\UserDeactivatedEvent;
use App\Events\User\UserInvitationCreatedEvent;
use App\Listeners\Company\CompanyCreatedListener;
use App\Listeners\Subscription\SubscriptionActivatedListener;
use App\Listeners\Subscription\SubscriptionChangedListener;
use App\Listeners\User\UserCreatedListener;
use App\Listeners\User\UserInvitationCreatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
            UserCreatedListener::class,
        ],
        // UserDeactivatedEvent::class => [
        //     UserCreatedListener::class,
        // ],
        CompanyCreatedEvent::class => [
            CompanyCreatedListener::class,
        ],
        SubscriptionActivatedEvent::class => [
            SubscriptionActivatedListener::class,
        ],
        SubscriptionChangedEvent::class => [
            SubscriptionChangedListener::class,
        ],
        UserInvitationCreatedEvent::class => [
            UserInvitationCreatedListener::class,
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
