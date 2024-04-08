<?php

namespace Database\Seeders;

use App\Domains\Auth\PermissionTypes;
use App\Domains\Auth\RoleTypes;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = collect([
            RoleTypes::SUPER_ADMINISTRATOR,
            RoleTypes::ADMINISTRATOR,
            RoleTypes::MANAGER,
            RoleTypes::GUEST,
            RoleTypes::BASIC,
        ]);

        $roles->each(function ($role) {
            $dbRole = Role::firstOrCreate(['name' => $role->value]);

            switch ($role) {
                case RoleTypes::SUPER_ADMINISTRATOR:
                    $permissions = Permission::all();
                    $dbRole->syncPermissions($permissions);
                    break;

                case RoleTypes::ADMINISTRATOR:
                    $permissions = Permission::where('name', PermissionTypes::ASSET_FULL_ACCESS)
                        ->orWhere('name', PermissionTypes::ACCOUNT_FULL_ACCESS)
                        ->orWhere('name', PermissionTypes::ROLE_FULL_ACCESS)
                        ->orWhere('name', PermissionTypes::OFFICE_FULL_ACCESS)
                        ->orWhere('name', PermissionTypes::AUDIT_FULL_ACCESS)
                        ->orWhere('name', PermissionTypes::VENDOR_FULL_ACCESS)
                        ->orWhere('name', PermissionTypes::DEPARTMENT_FULL_ACCESS)
                        ->orWhere('name', PermissionTypes::DOCUMENT_FULL_ACCESS)
                        ->orWhere('name', PermissionTypes::INSURANCE_FULL_ACCESS)
                        ->orWhere('name', PermissionTypes::TAG_FULL_ACCESS)
                        ->get();
                    $dbRole->syncPermissions($permissions);
                    break;

                case RoleTypes::MANAGER:
                    $permissions = Permission::Where('name', PermissionTypes::ASSET_FULL_ACCESS)
                        ->orWhere('name', PermissionTypes::ACCOUNT_CREATE_ACCESS)
                        ->orWhere('name', PermissionTypes::ACCOUNT_READ_ACCESS)
                        ->orWhere('name', PermissionTypes::DOCUMENT_FULL_ACCESS)
                        ->orWhere('name', PermissionTypes::INSURANCE_FULL_ACCESS)
                        ->get();
                    $dbRole->syncPermissions($permissions);
                    break;

                case RoleTypes::GUEST:
                    $permissions = Permission::Where('name', PermissionTypes::ASSET_READ_ACCESS)
                        ->orWhere('name', PermissionTypes::DOCUMENT_READ_ACCESS)
                        ->orWhere('name', PermissionTypes::DEPARTMENT_READ_ACCESS)
                        ->orWhere('name', PermissionTypes::INSURANCE_READ_ACCESS)
                        ->orWhere('name', PermissionTypes::VENDOR_READ_ACCESS)
                        ->get();
                    $dbRole->syncPermissions($permissions);
                    break;

                case RoleTypes::BASIC:
                    $permissions = Permission::where('name', PermissionTypes::ASSET_CREATE_ACCESS)
                        ->OrWhere('name', PermissionTypes::ASSET_READ_ACCESS)
                        ->OrWhere('name', PermissionTypes::ASSET_UPDATE_ACCESS)
                        ->OrWhere('name', PermissionTypes::ASSET_CHECKOUT_ACCESS)
                        ->get();
                    $dbRole->syncPermissions($permissions);
                    break;

                default:
                    // code...
                    break;
            }
        });
    }
}
