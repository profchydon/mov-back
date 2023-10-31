<?php

namespace App\Domains\Enum\User;

use App\Traits\ListsEnumValues;

enum UserDepartmentStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case DEACTIVATED = 'DEACTIVATED';
}
