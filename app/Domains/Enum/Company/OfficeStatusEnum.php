<?php

namespace App\Domains\Enum\Company;

use App\Traits\ListsEnumValues;

enum OfficeStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
}
