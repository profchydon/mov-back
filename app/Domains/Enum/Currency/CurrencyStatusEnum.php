<?php

namespace App\Domains\Enum\Currency;

use App\Traits\ListsEnumValues;

enum CurrencyStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
}
