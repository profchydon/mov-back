<?php

namespace App\Domains\Enum\Tag;

use App\Traits\ListsEnumValues;

enum TagStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
}
