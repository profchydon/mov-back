<?php

namespace App\Domains\Enum\Currency;

use App\Traits\ListsEnumValues;

enum CurrencyStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
}
