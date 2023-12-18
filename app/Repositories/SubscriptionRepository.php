<?php

namespace App\Repositories;

use App\Domains\DTO\AddonDTO;
use App\Domains\DTO\CreatePaymentLinkDTO;
use App\Domains\DTO\CreateSubscriptionDTO;
use App\Domains\DTO\Invoice\InvoiceDTO;
use App\Domains\DTO\Invoice\InvoiceItemDTO;
use App\Domains\Enum\Invoice\InvoiceStatusEnum;
use App\Models\Company;
use App\Models\Feature;
use App\Models\FeaturePrice;
use App\Models\Invoice;
use App\Models\Subscription;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use App\Services\V2\FlutterwaveService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        $planPrice = $subscription->plan->prices()
            ->where('currency_code', $subDTO->getCurrency())
            ->where('billing_cycle', $subDTO->getBillingCycle())
            ->firstOrFail();

        $totalAmount = $planPrice->amount ?? 0;

        if ($totalAmount > 0) {

            $addOnAmount  = 0;

            if ($subDTO->getAddOnIds()->isNotEmpty()) {

                $addOnAmount += FeaturePrice::whereIn('feature_id', $subDTO->getAddOnIds())
                ->where('currency_code', $subDTO->getCurrency())
                ->sum('price');
            }

            $planProcessor = $planPrice->flutterwaveProcessor()->firstOrFail();

            $totalAmount += $addOnAmount;

            $paymentLinkDTO = new CreatePaymentLinkDTO();
            $paymentLinkDTO->setCurrency($subDTO->getCurrency())
                ->setAmount($totalAmount)
                ->setPaymentPlan($planProcessor->plan_processor_id)
                ->setRedirectUrl($subDTO->getRedirectURI())
                ->setCustomer(Company::find($subDTO->getCompanyId()))
                ->setMeta([
                    'subscription_id' => $subscription->id,
                    'billing_cycle' => $subDTO->getBillingCycle(),
                ]);

            $paymentLink = FlutterwaveService::getStandardPaymentLink($paymentLinkDTO);

            $subscription->payment()->create([
                'company_id' => $subDTO->getCompanyId(),
                'tenant_id' => $subDTO->getTenantId(),
                'payment_link' => $paymentLink->authorization_url ?? $paymentLink->link,
                'tx_ref' => $paymentLink->reference ?? $paymentLinkDTO->getTxRef(),
            ]);
        } else {
            $subscription->activate();
        }

        $invoiceDTO = new InvoiceDTO();
        $invoiceDTO->setTenantId($subDTO->getTenantId())
            ->setCompanyId($subDTO->getCompanyId())
            ->setCurrencyCode($subDTO->getCurrency())
            ->setBillable($subscription)
            ->setSubTotal($totalAmount ?? 0)
            ->setDueAt(now()->addHours(6));

        if ($totalAmount < 1) {
            $invoiceDTO->setPaidAt(now())
                ->setStatus(InvoiceStatusEnum::PAID->value);
        }

        // Log::info("Info Details", $invoiceDTO->toArray());

        $invoice = Invoice::create($invoiceDTO->toArray());

        $invoiceItemDTO = new InvoiceItemDTO();
        $invoiceItemDTO->setAmount($planPrice->amount ?? 0)
            ->setItem($subscription->plan)
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

        return $subscription->load('payment');
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
}
