<?php

namespace App\Repositories;

use App\Domains\Constant\SubscriptionAddOnConstant;
use App\Domains\DTO\AddonDTO;
use App\Domains\DTO\CreatePaymentLinkDTO;
use App\Domains\DTO\CreateSubscriptionDTO;
use App\Domains\DTO\Invoice\InvoiceDTO;
use App\Domains\DTO\Invoice\InvoiceItemDTO;
use App\Domains\Enum\Invoice\InvoiceStatusEnum;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Helpers\BillingHelper;
use App\Models\Company;
use App\Models\Feature;
use App\Models\FeaturePrice;
use App\Models\Invoice;
use App\Models\PlanPrice;
use App\Models\Subscription;
use App\Models\Plan;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use App\Services\V2\FlutterwaveService;
use App\Services\V2\StripeService;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SubscriptionRepository extends BaseRepository implements SubscriptionRepositoryInterface
{
    public function model(): string
    {
        return Subscription::class;
    }

    public function getCompanySubscription(string|Company $company)
    {
        if (!($company instanceof Company)) {
            $company = Company::findOrFail($company);
        }

        $subscription = $company->activeSubscription()->with(['payment', 'plan.prices', 'addOns.feature.prices']);

        return $subscription->first();
    }

    public function createSubscription(CreateSubscriptionDTO $subDTO)
    {
        DB::beginTransaction();

        $subscription = Subscription::firstOrCreate(Arr::except($subDTO->toSynthensizedArray(), ['add-on-ids', 'currency', 'redirect_uri']));

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

        $invoice = BillingHelper::createSubscriptionInvoice($subscription, $subDTO->getCurrency());

        if (!$subscription->isBasic()) {
            BillingHelper::createSubscriptionInvoicePayment($subscription, $invoice, $subDTO->getRedirectURI());
        }

        DB::commit();

        return $subscription->load('invoice.payment');
    }

    public function addAddOnsToSubsciption(Subscription|string $subscription, AddonDTO $addonDTO)
    {
        if (!($subscription instanceof Subscription)) {
            $subscription = Subscription::findOrFail($subscription);
        }

        DB::beginTransaction();

        $addOns = $addonDTO->getAddOns()->each(function ($id) use ($subscription) {
            $subscription->addOns()->create([
                'feature_id' => $id,
                ...Arr::except($subscription->toArray(), ['id', 'plan_id', 'invoice_id']),
            ]);
        });

        $addonAmount = FeaturePrice::whereIn('feature_id', $addonDTO->getAddOns())
            ->where('currency_code', $addonDTO->getCurrency())
            ->sum('price');

        $planPrice = $subscription->plan->prices()
            ->where('currency_code', $addonDTO->getCurrency())
            ->where('billing_cycle', $subscription->billing_cycle)
            ->firstOrFail();

        $planProcessor = $planPrice->flutterwaveProcessor()->firstOrFail();

        $paymentLinkDTO = new CreatePaymentLinkDTO();
        $paymentLinkDTO->setCurrency($addonDTO->getCurrency())
            ->setAmount($addonAmount)
            ->setPaymentPlan($planProcessor->plan_processor_id)
            ->setRedirectUrl($addonDTO->getRedirectUri())
            ->setCustomer($subscription->company)
            ->setMeta([
                'subscription_id' => $subscription->id,
                'billing_cycle' => $subscription->billing_cycle,
            ]);

        $paymentLink = FlutterwaveService::getStandardPaymentLink($paymentLinkDTO);

        $invoiceDTO = new InvoiceDTO();
        $invoiceDTO->setTenantId($subscription->tenant_id)
            ->setCompanyId($subscription->company_id)
            ->setCurrencyCode($addonDTO->getCurrency())
            ->setBillable($subscription)
            ->setSubTotal($addonAmount)
            ->setDueAt(now()->addHours(6));

        $invoice = Invoice::create($invoiceDTO->toArray());

        $features = Feature::find($addonDTO->getAddOns());

        $features->each(function ($feature) use ($addonDTO, $invoice) {
            $price = $feature->currencyPrice($addonDTO->getCurrency())->firstOrFail();

            $dto = new InvoiceItemDTO();
            $dto->setQuantity(1)
                ->setAmount($price->price)
                ->setItem($feature)
                ->setInvoiceId($invoice);

            $invoice->items()->create($dto->toArray());
        });

        DB::commit();

        return $paymentLink;
    }

    public function changeSubscription(Subscription $oldSub, Plan $newPlan, CreateSubscriptionDTO $subDTO)
    {

        DB::beginTransaction();
        $amountLeftFromOldSub = BillingHelper::calculateAmountLeftInSub($oldSub);

        // return $amountLeftFromOldSub;

        $planPrice = $newPlan->prices()
            ->where('currency_code', $subDTO->getCurrency())
            ->where('billing_cycle', $subDTO->getBillingCycle())
            ->firstOrFail();

        $amountToPayForCurrentSub = $planPrice->amount ?? 0;

        if ($subDTO->getAddOnIds()->isNotEmpty()) {
            $addOnAmount = FeaturePrice::whereIn('feature_id', $subDTO->getAddOnIds())
                ->where('currency_code', $subDTO->getCurrency())
                ->sum('price');

            if (Str::lower($subDTO->getBillingCycle()) == 'yearly') {
                $addOnAmount *= 12;

                $amountToPayForCurrentSub += $addOnAmount;
            }
        }

        $newSubscription = $this->create(Arr::except($subDTO->toArray(), 'add-on-ids'));

        $oldSub->addOns()->update([
            SubscriptionAddOnConstant::SUBSCRIPTION_ID => $newSubscription->id
        ]);


        $amountToPay = max(0, $amountToPayForCurrentSub - $amountLeftFromOldSub);

        if (Str::upper($subDTO->getCurrency()) == 'USD') {
            $planProcessor = $planPrice->swipeProcessor()->firstOrFail();
        } else {
            $planProcessor = $planPrice->flutterwaveProcessor()->firstOrFail();
        }

        $invoiceDTO = new InvoiceDTO();
        $invoiceDTO->setTenantId($subDTO->getTenantId())
            ->setCompanyId($subDTO->getCompanyId())
            ->setCurrencyCode($subDTO->getCurrency())
            ->setBillable($newSubscription)
            ->setSubTotal($amountToPay ?? 0)
            ->setDueAt(now()->addHours(6));

        if ($amountToPay == 0) {
            $oldSub->deactivate();
            $newSubscription->activate();
            return $newSubscription->fresh();
        }

        $paymentLinkDTO = new CreatePaymentLinkDTO();
        $paymentLinkDTO->setCurrency($subDTO->getCurrency())
            ->setAmount($amountToPay)
            ->setPaymentPlan($planProcessor->plan_processor_id)
            ->setRedirectUrl($subDTO->getRedirectURI())
            ->setCustomer(Company::find($subDTO->getCompanyId()))
            ->setBillingCycle($subDTO->getBillingCycle())
            ->setMeta([
                'subscription_id' => $newSubscription->id,
                'billing_cycle' => $subDTO->getBillingCycle(),
            ]);

        $paymentObject = null;

        if (Str::upper($subDTO->getCurrency()) == 'USD' || Str::upper($subDTO->getCurrency()) == 'GBP' || Str::upper($subDTO->getCurrency()) == 'EUR') {
            $paymentLink = StripeService::getStandardPaymentLink($paymentLinkDTO);
        } else {
            $paymentObject = FlutterwaveService::getStandardPaymentLink($paymentLinkDTO);
            $paymentLink = $paymentObject->authorization_url ?? $paymentObject?->link;
        }

        $newSubscription->payment()->create([
            'company_id' => $subDTO->getCompanyId(),
            'tenant_id' => $subDTO->getTenantId(),
            'payment_link' => $paymentLink,
            'tx_ref' => $paymentObject?->reference ?? $paymentLinkDTO->getTxRef(),
        ]);

        if ($amountToPay < 1) {
            $invoiceDTO->setPaidAt(now())
                ->setStatus(InvoiceStatusEnum::PAID->value);
        }

        $invoice = Invoice::create($invoiceDTO->toArray());

        $invoiceItemDTO = new InvoiceItemDTO();
        $invoiceItemDTO->setAmount($planPrice->amount ?? 0)
            ->setItem($newSubscription->plan)
            ->setQuantity(1);

        $invoice->items()->create($invoiceItemDTO->toArray());

        $features = Feature::find($subDTO->getAddOnIds());

        $features->each(function ($feature) use ($subDTO, $invoice) {
            $price = $feature->currencyPrice($subDTO->getCurrency())->firstOrFail();

            $dto = new InvoiceItemDTO();
            $dto->setQuantity(1)
                ->setAmount($price->price)
                ->setItem($feature)
                ->setInvoiceId($invoice);

            $invoice->items()->create($dto->toArray());
        });

        DB::commit();

        return $newSubscription->load('payment');
    }

    public function downgradeSubscription(Subscription $oldSub, Plan $newPlan, CreateSubscriptionDTO $subDTO)
    {
        DB::beginTransaction();

        $newSub = Subscription::where('company_id', $oldSub->company_id)
            ->where('plan_id', $newPlan->id)
            ->where('status', SubscriptionStatusEnum::INACTIVE)
            ->where('billing_cycle', $subDTO->getBillingCycle())
            ->first();

        if (empty($newSub)) {
            $newSub = $this->create(Arr::except($subDTO->toArray(), 'add-on-ids'));
        }

        if ($subDTO->getAddOnIds()->isNotEmpty()) {
            $addons = $subDTO->getAddOnIds()->map(function ($id) use ($newSub) {
                return [
                    'feature_id' => $id,
                    ...Arr::except($newSub->toArray(), ['id', 'plan_id', 'invoice_id']),
                ];
            });

            $addons->each(function ($addOn) use ($newSub) {
                $newSub->addOns()->create($addOn);
            });
        }

        $invoice = BillingHelper::createSubscriptionInvoice($newSub, $subDTO->getCurrency());

        BillingHelper::createSubscriptionInvoicePayment($newSub, $invoice, $subDTO->getRedirectURI());

        return $newSub->load('invoice');

        DB::commit();
    }

    public function upgradeSubscription(Subscription $oldSub, Plan $newPlan, CreateSubscriptionDTO $subDTO)
    {
        $amountLeftFromOldSub = BillingHelper::calculateAmountLeftInSub($oldSub);

        $newSub = Subscription::where('company_id', $oldSub->company_id)
            ->where('plan_id', $newPlan->id)
            ->where('status', SubscriptionStatusEnum::INACTIVE)
            ->where('billing_cycle', $subDTO->getBillingCycle())
            ->first();

        if (empty($newSub)) {
            $newSub = $this->create(Arr::except($subDTO->toArray(), 'add-on-ids'));
        }

        $invoice = BillingHelper::createSubscriptionInvoice($newSub, $subDTO->getCurrency(), $amountLeftFromOldSub, $oldSub);

        BillingHelper::createSubscriptionInvoicePayment($newSub, $invoice, $subDTO->getRedirectURI());

        DB::commit();

        return $invoice->load('payment');
    }


}
