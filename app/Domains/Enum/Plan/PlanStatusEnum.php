<?php

namespace App\Domains\Enum\Plan;

use App\Traits\ListsEnumValues;

enum PlanStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
}
