<?php

namespace App\Domains\Enum\User;

use App\Traits\ListsEnumValues;

enum UserDepartmentStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
    case DEACTIVATED = 'Deactivated';
}
