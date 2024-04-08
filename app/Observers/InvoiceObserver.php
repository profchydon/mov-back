<?php

namespace App\Observers;

use App\Domains\DTO\CreatePaymentLinkDTO;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Events\Subscription\SubscriptionChangedEvent;
use App\Models\Invoice;

class InvoiceObserver
{
    /**
     * Handle the Invoice "created" event.
     */
    public function created(Invoice $invoice): void
    {
        $paymentDTO = new CreatePaymentLinkDTO();
        $paymentDTO->setAmount($invoice->sub_total + $invoice->tax);

    }

    /**
     * Handle the Invoice "updated" event.
     */
    public function updated(Invoice $invoice): void
    {
        if ($invoice->isForSubscription() && $invoice->paid()) {

            $oldSubscription = $invoice->company->activeSubscription;
            $newSubscription = $invoice->billable;

            if ($oldSubscription) {
                SubscriptionChangedEvent::dispatch($oldSubscription, $newSubscription);
            }

            $oldSubscription->deactivate();
            $newSubscription->activate();
            $newSubscription->addOns->each(function ($addOn) {
                $addOn->activate();
            });
        }
    }

    /**
     * Handle the Invoice "deleted" event.
     */
    public function deleted(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     */
    public function restored(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     */
    public function forceDeleted(Invoice $invoice): void
    {
        //
    }
}
