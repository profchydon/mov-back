<?php

namespace App\Domains\Enum;

use App\Traits\ListsEnumValues;

enum PaymentStatusEnum: string
{
    use ListsEnumValues;

    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}
