<?php

namespace App\Domains\Enum\Plan;

use App\Traits\ListsEnumValues;

enum BillingCycleEnum: string
{
    use ListsEnumValues;

    case MONTHLY = 'Monthly';
    case YEARLY = 'Yearly';
}
