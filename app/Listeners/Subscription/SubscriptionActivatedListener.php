<?php

namespace App\Listeners\Subscription;

use App\Domains\Enum\EventTrack\EventTrackEnum;
use App\Events\Subscription\SubscriptionActivatedEvent;
use App\Mail\SubscriptionActivationMail;
use App\Services\V2\EventTrackerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscriptionActivatedListener
{
    /**
     * UserCreatedListener constructor.
     * @param EventTrackerService $eventService
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
        Mail::to('chidi.nkwocha@rayda.co')->queue(new SubscriptionActivationMail($subscription));

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
