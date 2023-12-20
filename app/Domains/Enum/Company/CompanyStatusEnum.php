<?php

namespace App\Domains\Enum\Company;

use App\Traits\ListsEnumValues;

enum CompanyStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
}
