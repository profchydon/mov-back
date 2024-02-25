<?php

namespace App\Listeners\Subscription;

use App\Domains\Enum\EventTrack\EventTrackEnum;
use App\Events\Subscription\SubscriptionActivatedEvent;
use App\Events\Subscription\SubscriptionChangedEvent;
use App\Mail\SubscriptionActivationMail;
use App\Mail\SubscriptionDowngradedMail;
use App\Mail\SubscriptionRenewedMail;
use App\Mail\SubscriptionUpgradedMail;
use App\Services\V2\EventTrackerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscriptionChangedListener
{
    /**
     * UserCreatedListener constructor.
     * @param EventTrackerService $eventService
     */
    public function __construct()
    {
        //
    }

    public function handle(SubscriptionChangedEvent $event)
    {
        $oldSubscription = $event->oldSubscription;
        $oldPlan = $event->oldSubscription->plan;

        $newSubscription = $event->newSubscription;
        $newPlan = $event->newSubscription->plan;

        $company = $oldSubscription?->company;
        $offers = $newPlan?->offers;
        $invoice = $newSubscription?->invoice;
        $invoiceItems = $invoice?->items;
        $currency = $invoice?->currency;

        $data = [
            'company' => $company,
            'oldPlan' => $oldPlan,
            'newPlan' => $newPlan,
            'offers' => $offers,
            'invoice' => $invoice,
            'invoiceItems' => $invoiceItems,
            'currency' => $currency,
        ];

        if ($newPlan?->rank > $oldPlan?->rank) {

            //Send email
             Mail::to($company?->email)->queue(new SubscriptionUpgradedMail($data));

        }

        if ($newPlan?->rank == $oldPlan?->rank) {
            Mail::to($company?->email)->queue(new SubscriptionRenewedMail($data));
        }

        if ($newPlan?->rank < $oldPlan?->rank) {
            Mail::to($company?->email)->queue(new SubscriptionDowngradedMail($data));
        }

    }
}
