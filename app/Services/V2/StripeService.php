<?php

namespace App\Services\V2;

use App\Domains\DTO\CreatePaymentLinkDTO;
use App\Services\Contracts\PaymentServiceInterface;
use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Price;
use Stripe\Stripe;

class StripeService implements PaymentServiceInterface
{
    public static function getStandardPaymentLink(CreatePaymentLinkDTO $linkDTO)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $price = Price::create([
            'currency' => Str::lower($linkDTO->getCurrency()),
            'unit_amount' => $linkDTO->getAmountInKobo(),
            'recurring' => ['interval' => Str::lower(Str::substr($linkDTO->getBillingCycle(), 0, -2))], //remove 'ly', from billing cycle.
            'product_data' => ['name' => $linkDTO->getPaymentPlan()],
        ]);

        // Create a new Checkout Session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price' => $price->id,
                    'quantity' => 1,
                ],
            ],
            'mode' => 'subscription',
            'success_url' => $linkDTO->getRedirectUrl(),
            'cancel_url' => $linkDTO->getRedirectUrl(),
        ]);

        return $session->url;
    }
}
