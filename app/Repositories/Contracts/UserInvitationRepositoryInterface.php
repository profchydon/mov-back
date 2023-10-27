<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\InviteCompanyUsersDTO;

interface UserInvitationRepositoryInterface extends BaseRepositoryInterface
{
    public function inviteCompanyUser(InviteCompanyUsersDTO $data);
}
