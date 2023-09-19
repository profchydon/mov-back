<?php

namespace App\Domains\Enum\User;

use App\Traits\ListsEnumValues;

enum UserAccountStageEnum: string
{
    use ListsEnumValues;

    case VERIFICATION = 'verification';
    case COMPANY_DETAILS = 'company details';
    case SUBSCRIPTION_PLAN = 'subscription plan';
    case ADD_USERS = 'add users';
    case COMPLETED = 'completed';
}
