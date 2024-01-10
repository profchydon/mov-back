<?php

namespace App\Domains\Enum;

use App\Traits\ListsEnumValues;

enum PaymentStatusEnum: string
{
    use ListsEnumValues;

    case PROCESSING = 'Processing';
    case COMPLETED = 'Completed';
    case FAILED = 'Failed';
}
