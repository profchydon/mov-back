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
            RoleTypes::ADMINISTRATOR,
            RoleTypes::ASSET_MANAGER,
            RoleTypes::TECHNICIAN,
            RoleTypes::FINANCE,
            RoleTypes::BASIC,
        ]);

        $roles->each(function ($role) {
            $dbRole = Role::firstOrCreate(['name' => $role->value]);

            switch ($role) {
                case RoleTypes::ADMINISTRATOR:
                    $permissions = Permission::all();
                    $dbRole->syncPermissions($permissions);
                    break;

                case RoleTypes::ASSET_MANAGER:
                    $permissions = Permission::where('name', PermissionTypes::ASSET_FULL_ACCESS)->get();
                    $dbRole->syncPermissions($permissions);
                    break;

                case RoleTypes::TECHNICIAN:
                    $permissions = Permission::where('name', PermissionTypes::ASSET_FULL_ACCESS)->get();
                    $dbRole->syncPermissions($permissions);
                    break;

                case RoleTypes::FINANCE:
                    $permissions = Permission::where('name', PermissionTypes::BILLING_FULL_ACCESS)->get();
                    $dbRole->syncPermissions($permissions);
                    break;

                case RoleTypes::BASIC:
                    $permissions = Permission::where('name', PermissionTypes::ASSET_CREATE_ACCESS)
                                    ->OrWhere('name', PermissionTypes::ASSET_READ_ACCESS)
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
