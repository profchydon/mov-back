<?php

namespace App\Models;

use App\Domains\Constant\SubscriptionConstant;
use App\Domains\Enum\Invoice\InvoiceStatusEnum;
use App\Domains\Enum\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Events\Subscription\SubscriptionActivatedEvent;
use App\Events\Subscription\SubscriptionChangedEvent;

class InvoicePayment extends BaseModel
{
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public static function booted()
    {
        parent::booted();
        static::updated(function (self $payment) {
            if ($payment->isComplete()) {

                $oldSubscription = $payment->company->activeSubscription;
                $newSubscription = $payment->invoice?->billable;

                if (!$oldSubscription) {
                    SubscriptionActivatedEvent::dispatch($newSubscription);
                }

                if ($oldSubscription) {
                    SubscriptionChangedEvent::dispatch($oldSubscription, $newSubscription);
                }

                $payment->company->activeSubscription()?->update([
                    SubscriptionConstant::STATUS => SubscriptionStatusEnum::INACTIVE->value
                ]);

                $payment->invoice?->billable?->activate();
                $payment->invoice?->markAsPaid();
                $payment->invoice?->billable?->addOns?->each(function ($addOn) {
                    $addOn->activate();
                });
                $payment->invoice->company->pendingSubscriptionsInvoices()->update([
                    'status' => InvoiceStatusEnum::CANCELED
                ]);
            }
        });
    }

    public function isComplete()
    {
        return $this->status == PaymentStatusEnum::COMPLETED;
    }

    public function complete()
    {
        $this->status = PaymentStatusEnum::COMPLETED;
        $this->save();

        return $this->fresh();
    }
}
