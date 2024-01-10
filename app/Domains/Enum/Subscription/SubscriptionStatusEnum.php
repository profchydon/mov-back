<?php

namespace App\Domains\Enum\Subscription;

use App\Traits\ListsEnumValues;

enum SubscriptionStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case EXPIRED = 'EXPIRED';
}
