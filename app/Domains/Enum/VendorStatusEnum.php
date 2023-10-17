<?php

namespace App\Domains\Enum;

use App\Traits\ListsEnumValues;

enum VendorStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
