<?php

namespace App\Domains\Enum\Company;

use App\Traits\ListsEnumValues;

enum CompanyStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
}
