<?php

namespace App\Domains\Enum;

use App\Traits\ListsEnumValues;

enum InsuranceCoverageCycleEnum: string
{
    use ListsEnumValues;

    case MONTHLY = 'Monthly';
    case YEARLY = 'Yearly';
    case QUARTERLY = 'Quarterly';
}
