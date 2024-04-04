<?php

namespace App\Domains\Enum\Document;

use App\Traits\ListsEnumValues;

enum DocumentStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
    case APPROVED = 'Approved';
    case REJECTED = 'Rejected';
    case UNDER_REVIEW = 'Under Review';
    case ARCHIVED = 'Archived';
}
