<?php

namespace App\Domains\Enum\Plan;

use App\Traits\ListsEnumValues;

enum PlanProcessorNameEnum: string
{
    use ListsEnumValues;

    case PAYSTACK = 'paystack';
    case FLUTTERWAVE = 'flutterwave';
    case STRIPE = 'stripe';
}
