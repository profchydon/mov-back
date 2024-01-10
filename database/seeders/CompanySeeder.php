<?php

namespace Database\Seeders;

use App\Domains\Constant\CompanyConstant;
use App\Domains\Enum\Company\CompanyStatusEnum;
use App\Models\Company;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::limit(1)->get();

        Company::create([
            CompanyConstant::NAME => 'Rayda',
            CompanyConstant::SIZE => '1 - 10',
            CompanyConstant::EMAIL => 'admin@admin.com',
            CompanyConstant::PHONE => '+234700000000',
            CompanyConstant::INDUSTRY => 'Financial technology',
            CompanyConstant::COUNTRY => 150,
            CompanyConstant::TENANT_ID => $tenant[0]->id,
            CompanyConstant::STATUS => CompanyStatusEnum::ACTIVE->value,
        ]);
    }
}
