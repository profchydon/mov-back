<?php

namespace App\Domains\Enum\User;

use App\Traits\ListsEnumValues;

enum UserStageEnum: string
{
    use ListsEnumValues;

    case VERIFICATION = 'Verification';
    case COMPANY_DETAILS = 'Company Details';
    case SUBSCRIPTION_PLAN = 'Subscription Plan';
    case USERS = 'Users';
    case COMPLETED = 'Completed';
}
