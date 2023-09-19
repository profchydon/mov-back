<?php

namespace App\Listeners\Subscription;

use App\Mail\UserCreatedMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\v2\EventTrackerService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Domains\Enum\EventTrack\EventTrackEnum;
use App\Events\Subscription\SubscriptionActivatedEvent;
use App\Mail\SubscriptionActivationMail;

class SubscriptionActivatedListener
{

    /**
     * UserCreatedListener constructor.
     * @param EventTrackerService $eventService
     *
     */
    public function __construct()
    {
        //
    }


    public function handle(SubscriptionActivatedEvent $event)
    {

        $subscription = $event->subscription;
        $company = $subscription->company()->first();
        $plan = $subscription->plan()->first();
        // $add_ons = $subscription->addOns()->get();

        //Send email
        // Mail::to('chidi.nkwocha@rayda.co')->queue(new SubscriptionActivationMail($subscription));

        $data = [
            'company' => $company,
            'plan' => $plan,
            // 'add_ons' => $add_ons
        ];

        //Trigger user created event
        EventTrackerService::track('chidi.nkwocha@rayda.co', EventTrackEnum::SUBSCRIPTION_ACTIVATED->value, (array) $data);

        Log::info("Info: Subscription Activated {$subscription}");

        return true;
    }
}
