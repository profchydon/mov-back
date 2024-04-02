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

        $offers = $plan?->offers;
        $invoice = $subscription?->invoice;
        $invoiceItems = $invoice?->items;
        $currency = $invoice?->currency;

        $data = [
            'company' => $company,
            'plan' => $plan,
            'offers' => $offers,
            'invoice' => $invoice,
            'invoiceItems' => $invoiceItems,
            'currency' => $currency,
        ];

        //Send email
        Mail::to($company?->email)->queue(new SubscriptionActivationMail($data));

        //Trigger user created event
        try {
            EventTrackerService::track($company?->email, EventTrackEnum::SUBSCRIPTION_ACTIVATED->value, (array) $subscription->load('plan'));
        } catch (\Throwable $th) {
            //throw $th;
        }

        Log::info("Info: Subscription Activated {$subscription->load('plan')}");

        return true;
    }
}
