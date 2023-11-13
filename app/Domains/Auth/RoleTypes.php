<?php

namespace App\Domains\Auth;

enum RoleTypes: string
{
    case ADMINISTRATOR = 'Administrator';
    case ASSET_MANAGER = 'Asset Manager';
    case DOCUMENT_MANAGER = 'Document Manager';
    case TECHNICIAN = 'Technician';
    case AUDITOR = 'Auditor';
    case FINANCE = 'Finance';
    case BASIC = 'Basic';
}
