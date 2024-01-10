<?php

namespace App\Domains\Enum\Plan;

use App\Traits\ListsEnumValues;

enum PlanProcessorNameEnum: string
{
    use ListsEnumValues;

    case PAYSTACK = 'Paystack';
    case FLUTTERWAVE = 'Flutterwave';
    case STRIPE = 'Stripe';
}
