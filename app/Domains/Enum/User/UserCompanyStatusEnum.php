<?php

namespace App\Domains\Enum\User;

use App\Traits\ListsEnumValues;

enum UserCompanyStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case DEACTIVATED = 'DEACTIVATED';
}
