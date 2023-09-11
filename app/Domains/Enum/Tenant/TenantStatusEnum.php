<?php

namespace App\Domains\Enum\Tenant;

use App\Traits\ListsEnumValues;

enum TenantStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
}
