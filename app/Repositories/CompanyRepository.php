<?php

namespace App\Repositories;

use App\Domains\Constant\OfficeConstant;
use App\Domains\Constant\UserCompanyConstant;
use App\Domains\Constant\UserConstant;
use App\Domains\Constant\UserDepartmentConstant;
use App\Domains\Constant\UserInvitationConstant;
use App\Domains\Constant\UserRoleConstant;
use App\Domains\Constant\UserTeamConstant;
use App\Domains\DTO\CreateCompanyOfficeDTO;
use App\Domains\DTO\UpdateCompanyUserDTO;
use App\Domains\Enum\User\UserCompanyStatusEnum;
use App\Domains\Enum\User\UserStatusEnum;
use App\Http\Resources\Company\CompanyUserCollection;
use App\Http\Resources\Office\OfficeResource;
use App\Models\Company;
use App\Models\Office;
use App\Models\OfficeArea;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserDepartment;
use App\Models\UserInvitation;
use App\Models\UserRole;
use App\Models\UserTeam;
use App\Repositories\Contracts\CompanyOfficeRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface, CompanyOfficeRepositoryInterface
{
    public function model(): string
    {
        return Company::class;
    }

    /**
     * Create a company office.
     *
     * @param CreateCompanyOfficeDTO $companyOfficeDTO The DTO containing the office details.
     * @return Office The newly created office.
     */
    public function createCompanyOffice(CreateCompanyOfficeDTO $companyOfficeDTO): Office
    {
        return Office::firstOrCreate($companyOfficeDTO->toArray());
    }

    public function createOfficeArea(Office|string $office, string $name)
    {
        if (!($office instanceof Office)) {
            $office = Office::findOrFail($office);
        }

        return $office->areas()->create([
            'name' => $name,
            'tenant_id' => $office->tenant_id,
        ]);
    }

    public function getCompanyUsers(Company|string $company)
    {
        if (!($company instanceof  Company)) {
            $company = Company::findOrFail($company);
        }

        $users = $company->users()->with(['departments', 'teams', 'office', 'roles']);

        $users = User::appendToQueryFromRequestQueryParameters($users);
        $users = $users->paginate();

        return CompanyUserCollection::make($users);
    }

    public function getCompanyOffices(Company|string $company)
    {
        if (!($company instanceof Company)) {
            $company = Company::findOrFail($company);
        }

        $offices = $company->offices()->withCount('areas');
        $offices = Office::appendToQueryFromRequestQueryParameters($offices);

        return $offices->paginate();
    }

    public function getCompanyOffice(Office|string $office)
    {
        if (!($office instanceof Office)) {
            $office = Office::findOrFail($office);
        }

        $office->assetCount = count($office->assets);

        return new OfficeResource($office);

        // return $office->load('areas');
    }

    public function deleteCompanyOffice(Office|string $office)
    {
        if (!($office instanceof Office)) {
            $office = Office::findOrFail($office);
        }

        DB::beginTransaction();
        $office->areas()->delete();
        $office->deleteOrFail();
        DB::commit();
    }

    public function updateCompanyOffice(Office|string $office, CreateCompanyOfficeDTO $officeDTO)
    {
        if (!($office instanceof Office)) {
            $office = Office::findOrFail($office);
        }

        $office->update($officeDTO->toSynthensizedArray());

        return $office->fresh();
    }

    public function getOfficeAreas(Office|string $office)
    {
        $officeAreas = OfficeArea::where(OfficeConstant::OFFICE_ID, $office->id)->get();

        return $officeAreas;
    }

    public function updateOfficeArea(OfficeArea|string $officeArea, array $attributes)
    {
        if (!($officeArea instanceof OfficeArea)) {
            $officeArea = OfficeArea::findOrFail($officeArea);
        }

        $officeArea->update($attributes);

        return $officeArea->fresh();
    }

    public function deleteOfficeArea(OfficeArea|string $officeArea)
    {
        if (!($officeArea instanceof OfficeArea)) {
            $officeArea = OfficeArea::findOrFail($officeArea);
        }

        $officeArea->deleteOrFail();
    }

    public function getUsers(Company|string $company)
    {
        if (!($company instanceof Company)) {
            $company = Company::findOrFail($company);
        }

        $users = UserInvitation::with(['role', 'team', 'department', 'office'])->where(UserInvitationConstant::COMPANY_ID, $company->id);

        $users = UserInvitation::appendToQueryFromRequestQueryParameters($users);

        return $users;
    }

    public function updateCompanyUser(User|string $user, UpdateCompanyUserDTO $updateCompanyUserDTO)
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }

        try {
            DB::transaction(function () use ($user, $updateCompanyUserDTO) {
                $dto = $updateCompanyUserDTO->toArray();

                //Update user
                $user->update($dto);

                //Update roles
                foreach ($dto['roles'] as $role) {
                    $condition = [
                        UserRoleConstant::USER_ID => $dto['user_id'],
                        UserRoleConstant::COMPANY_ID => $dto['company_id'],
                        UserRoleConstant::ROLE_ID => $role,
                    ];

                    UserRole::firstOrCreate($condition, $condition);
                }

                //Update departments
                foreach ($dto['departments'] as $department) {
                    $condition = [
                        UserDepartmentConstant::USER_ID => $dto['user_id'],
                        UserDepartmentConstant::COMPANY_ID => $dto['company_id'],
                        UserDepartmentConstant::DEPARTMENT_ID => $department,
                    ];

                    UserDepartment::firstOrCreate($condition, $condition);
                }

                //Update teams
                foreach ($dto['teams'] as $team) {
                    $condition = [
                        UserTeamConstant::USER_ID => $dto['user_id'],
                        UserTeamConstant::COMPANY_ID => $dto['company_id'],
                        UserTeamConstant::TEAM_ID => $team,
                    ];

                    UserTeam::firstOrCreate($condition, $condition);
                }

                //Delete existing roles not in the new roles list
                UserRole::where(UserRoleConstant::USER_ID, $dto['user_id'])
                    ->where(UserRoleConstant::COMPANY_ID, $dto['company_id'])
                    ->whereNotIn(UserRoleConstant::ROLE_ID, $dto['roles'])->delete();

                //Delete existing departments not in the new departments list
                UserDepartment::where(UserDepartmentConstant::USER_ID, $dto['user_id'])
                    ->where(UserDepartmentConstant::COMPANY_ID, $dto['company_id'])
                    ->whereNotIn(UserDepartmentConstant::DEPARTMENT_ID, $dto['departments'])->delete();

                //Delete existing departments not in the new departments list
                UserTeam::where(UserTeamConstant::USER_ID, $dto['user_id'])
                    ->where(UserTeamConstant::COMPANY_ID, $dto['company_id'])
                    ->whereNotIn(UserTeamConstant::TEAM_ID, $dto['teams'])->delete();
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function suspendCompanyUser(Company|string $company, User|string $user)
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }

        if (!($company instanceof Company)) {
            $company = Company::findOrFail($company);
        }

        try {

            DB::transaction(function () use ($user, $company) {

                $user->update([UserConstant::STATUS => UserStatusEnum::INACTIVE->value]);

                UserCompany::where(UserCompanyConstant::COMPANY_ID, $company->id)->where(UserCompanyConstant::USER_ID, $user->id)->update([
                    UserCompanyConstant::STATUS => UserCompanyStatusEnum::INACTIVE->value,
                ]);
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function unSuspendCompanyUser(Company|string $company, User|string $user)
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }

        if (!($company instanceof Company)) {
            $company = Company::findOrFail($company);
        }

        try {

            DB::transaction(function () use ($user, $company) {

                $user->update([UserConstant::STATUS => UserStatusEnum::ACTIVE->value]);

                UserCompany::where(UserCompanyConstant::COMPANY_ID, $company->id)->where(UserCompanyConstant::USER_ID, $user->id)->update([
                    UserCompanyConstant::STATUS => UserCompanyStatusEnum::ACTIVE->value,
                ]);
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function deleteCompanyUser(Company|string $company, User|string $user)
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }

        if (!($company instanceof Company)) {
            $company = Company::findOrFail($company);
        }

        try {

            DB::transaction(function () use ($user, $company) {

                $user->update([
                    UserConstant::STATUS => UserStatusEnum::DEACTIVATED->value,
                    UserConstant::DELETED_AT => now()
                ]);

                UserCompany::where(UserCompanyConstant::COMPANY_ID, $company->id)->where(UserCompanyConstant::USER_ID, $user->id)->update([
                    UserCompanyConstant::STATUS => UserCompanyStatusEnum::DEACTIVATED->value,
                    UserCompanyConstant::DELETED_AT => now()
                ]);
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
