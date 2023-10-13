<?php

namespace App\Repositories;

use App\Domains\DTO\CreatePaymentLinkDTO;
use App\Domains\DTO\CreateSubscriptionDTO;
use App\Models\Company;
use App\Models\FeaturePrice;
use App\Models\Subscription;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use App\Services\V2\PaystackService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SubscriptionRepository extends BaseRepository implements SubscriptionRepositoryInterface
{
    public function model(): string
    {
        return Subscription::class;
    }

    public function createSubscription(CreateSubscriptionDTO $subDTO)
    {
        DB::beginTransaction();
        $subscription = $this->create(Arr::except($subDTO->toArray(), 'add-on-ids'));

        if ($subDTO->getAddOnIds()->isNotEmpty()) {
            $addons = $subDTO->getAddOnIds()->map(function ($id) use ($subscription) {
                return [
                    'feature_id' => $id,
                    ...Arr::except($subscription->toArray(), ['id', 'plan_id', 'invoice_id']),
                ];
            });

            $addons->each(function ($addOn) use ($subscription) {
                $subscription->addOns()->create($addOn);
            });
        }

        $planAmount = $subscription->plan->prices()
            ->where('currency_code', $subDTO->getCurrency())
            ->where('billing_cycle', $subDTO->getBillingCycle())
            ->first('amount')
            ?->amount;

        if($planAmount > 0){
            $addOnAmount = FeaturePrice::whereIn('feature_id', $subDTO->getAddOnIds())
                ->where('currency_code', $subDTO->getCurrency())
                ->sum('price');

            $paymentLink = new CreatePaymentLinkDTO();
            $paymentLink->setCurrency($subDTO->getCurrency())
                ->setAmount($planAmount + $addOnAmount)
                ->setRedirectUrl(config('app.frontend_url') . '/onboarding')
                ->setCustomer(Company::find($subDTO->getCompanyId()))
                ->setMeta([
                    'subscription_id' => $subscription->id,
                    'billing_cycle' => $subDTO->getBillingCycle(),
                ]);

            $paymentLink = PaystackService::getStandardPaymentLink($paymentLink);

            $subscription->payment()->create([
                'company_id' => $subDTO->getCompanyId(),
                'tenant_id' => $subDTO->getTenantId(),
                'payment_link' => $paymentLink->authorization_url,
                'tx_ref' => $paymentLink->reference,
            ]);
        }else {
            $subscription->activate();
        }

        DB::commit();

        return $subscription->load('payment');
    }
}
