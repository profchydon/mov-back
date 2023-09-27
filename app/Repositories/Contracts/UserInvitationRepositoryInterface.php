<?php

namespace App\Repositories\Contracts;

interface UserInvitationRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param array<int, InviteCompanyUsersDTO> $data
     */
    public function inviteCompanyUsers(array $data);
}
