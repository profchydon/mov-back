<?php

namespace App\Models;

use App\Domains\Constant\SubscriptionPaymentConstant;
use App\Domains\Enum\PaymentStatusEnum;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Events\Subscription\SubscriptionChangedEvent;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionPayment extends Model
{
    use HasFactory, UsesUUID;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'status' => PaymentStatusEnum::class,
    ];

    public static function booted()
    {
        parent::booted();
        static::updated(function (self $payment) {
            if ($payment->isComplete()) {

                $oldSubscription = $payment->company->activeSubscription;
                $newSubscription = $payment->subscription;

                SubscriptionChangedEvent::dispatch($oldSubscription, $newSubscription);

                $payment->company->activeSubscription()->update([
                    'status' => SubscriptionStatusEnum::INACTIVE
                ]);
                $payment->subscription->activate();
                $payment->subscription->invoice->markAsPaid();
                $payment->subscription->addOns->each(function ($addOn) {
                    $addOn->activate();
                });
            }
        });
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, SubscriptionPaymentConstant::SUBSCRIPTION_ID);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
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
