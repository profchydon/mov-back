<?php

namespace App\Domains\Enum\Tenant;

use App\Traits\ListsEnumValues;

enum TenantStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
}
