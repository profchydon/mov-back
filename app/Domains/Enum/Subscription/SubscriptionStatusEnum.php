<?php

namespace App\Domains\Enum\Subscription;

use App\Traits\ListsEnumValues;

enum SubscriptionStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
    case EXPIRED = 'Expired';
}
