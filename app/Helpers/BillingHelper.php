<?php

namespace App\Helpers;

use App\Domains\DTO\CreatePaymentLinkDTO;
use App\Domains\DTO\CreateSubscriptionDTO;
use App\Domains\DTO\Invoice\InvoiceDTO;
use App\Domains\DTO\Invoice\InvoiceItemDTO;
use App\Domains\Enum\Invoice\InvoiceStatusEnum;
use App\Models\Company;
use App\Models\Feature;
use App\Models\FeaturePrice;
use App\Models\Invoice;
use App\Models\PlanPrice;
use App\Models\PlanProcessor;
use App\Models\Subscription;
use App\Services\V2\FlutterwaveService;
use App\Services\V2\StripeService;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BillingHelper
{
    public static function createSubscriptionInvoice(Subscription $subscription, string $currency, float $outstanding = 0, $oldSub = null)
    {
        $planPriceSlug = static::planPriceSlug($subscription, $currency);
        $planPrice = PlanPrice::where('slug', $planPriceSlug)->first();

        $totalAmount = $planPrice->amount ?? 0;
        $addOnAmount = 0;

        $addOnIds = $subscription->addOns()->pluck('id');

        if ($addOnIds->isNotEmpty()) {
            $addOnAmount += FeaturePrice::whereIn('feature_id', $addOnIds)
                ->where('currency_code', $currency)
                ->sum('price');

            if (Str::lower($subscription->billing_cycle) == 'yearly') {
                $addOnAmount *= 12;
            }
        }

        $totalAmount += $addOnAmount;
        $totalAmount = max(0, $totalAmount);

        $invoice = Invoice::where('company_id', $subscription->company_id)
            ->where('billable_type', $subscription::class)
            ->where('billable_id', $subscription->id)
            ->first();

        if (empty($invoice)) {
            $invoiceDTO = new InvoiceDTO();
            $invoiceDTO->setTenantId($subscription->tenant_id)
                ->setCompanyId($subscription->company_id)
                ->setCurrencyCode($currency)
                ->setBillable($subscription)
                // ->setSubTotal($totalAmount)
                ->setSubTotal((float)$totalAmount - (float)$outstanding)
                ->setCarryOver($outstanding)
                ->setDueAt(now()->addHours(24));

            $invoice = Invoice::create($invoiceDTO->toArray());

            $invoiceItemDTO = new InvoiceItemDTO();
            $invoiceItemDTO->setAmount($planPrice->amount ?? 0)
                ->setItem($subscription->plan)
                ->setQuantity(1);

            $invoice->items()->create($invoiceItemDTO->toArray());

            if ($oldSub != null && $oldSub->plan->name != 'Basic') {
                $invoiceItemDTO = new InvoiceItemDTO();
                $invoiceItemDTO->setAmount($outstanding ?? 0)
                ->setItem($oldSub->plan)
                ->setIsCarriedOver(true)
                ->setQuantity(1);

                $invoice->items()->create($invoiceItemDTO->toArray());
            }

            $features = Feature::find($addOnIds);

            $features->each(function ($feature) use ($currency, $invoice) {
                $price = $feature->currencyPrice($currency)->firstOrFail();

                $dto = new InvoiceItemDTO();
                $dto->setQuantity(1)
                    ->setAmount($price->price)
                    ->setItem($feature)
                    ->setInvoiceId($invoice->id);

                $invoice->items()->create($dto->toArray());
            });
        }

        if ($totalAmount < 1) {
            $invoice->markAsPaid();
        }

        return $invoice;
    }

    public static function createSubscriptionInvoicePayment(Subscription $subscription, Invoice $invoice, string $redirectURI)
    {

        $invoicePayment = $invoice->payment()->first();

        if ($invoicePayment) {
           return $invoicePayment;
        }

        $planPriceSlug = static::planPriceSlug($subscription, $invoice->currency_code);
        $paymentProcessorSlug = "flutterwave";
        $paymentProcessor = FlutterwaveService::class;

        if (Str::lower($invoice->currency_code) != "ngn") {
            $paymentProcessorSlug = "stripe";
            $paymentProcessor = StripeService::class;
        }

        $planProcessor = PlanProcessor::where('payment_processor_slug', $paymentProcessorSlug)
            ->where('plan_price_slug', $planPriceSlug)
            ->first();

        $paymentLinkDTO = new CreatePaymentLinkDTO();
        $paymentLinkDTO->setCurrency($invoice->currency_code)
            ->setAmount(($invoice->sub_total + $invoice->tax))
            ->setPaymentPlan($planProcessor->plan_processor_id)
            ->setRedirectUrl($redirectURI)
            ->setCustomer($subscription->company)
            ->setBillingCycle($subscription->billing_cycle)
            ->setMeta([
                'subscription_id' => $subscription->id,
                'billing_cycle' => $subscription->billing_cycle,
            ]);

        $payment = $paymentProcessor::getStandardPaymentLink($paymentLinkDTO);
        if ($paymentProcessorSlug == 'flutterwave') {
            $paymentLink = $payment['link'];
        } else {
            $paymentLink = $payment;
        }

        $invoice->payment()->create([
            'company_id' => $subscription->company_id,
            'tenant_id' => $subscription->tenant_id,
            'payment_link' => $paymentLink,
            'processor' => $paymentProcessorSlug,
            'tx_ref' => $payment?->reference ?? $paymentLinkDTO->getTxRef(),
        ]);
    }

    public static function calculateAmountLeftInSub(Subscription $sub)
    {
        if ($sub->plan->name === 'Basic') {
            return 0;
        }

        $invoice = $sub->invoice;
        $startDate = Carbon::parse($sub->start_date);
        $endDate = Carbon::parse($sub->end_date);

        $planInDays = $startDate->diffInDays($endDate);

        $planPriceSlug = static::planPriceSlug($sub, $invoice->currency_code);
        $planPrice = $sub->plan->prices()->where('slug', $planPriceSlug)->first();

        $timeElapsedInDays = $startDate->diffInDays(Carbon::now());
        $amountPerDay = round($planPrice->amount / $planInDays, 2);
        $amountExhausted = $timeElapsedInDays * $amountPerDay;

        return round($planPrice->amount - $amountExhausted, 2);
    }

    private static function planPriceSlug(Subscription $subscription, string $currency)
    {
        $planPriceSlug = "{$subscription->plan->slug} {$currency} {$subscription->billing_cycle}";
        return Str::slug($planPriceSlug);
    }
}
