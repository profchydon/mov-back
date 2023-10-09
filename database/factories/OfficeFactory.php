<?php

namespace Database\Factories;

use App\Domains\Constant\OfficeConstant;
use App\Models\Company;
use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfficeFactory extends Factory
{
    public function definition(): array
    {
        $company = Company::inRandomOrder()->first() ?? Company::factory()->create();

        return [
            OfficeConstant::TENANT_ID => $company->tenant_id,
            OfficeConstant::COMPANY_ID => $company->id,
            OfficeConstant::NAME => fake()->name(),
            OfficeConstant::ADDRESS => fake()->streetAddress(),
            OfficeConstant::CURRENCY_CODE => fake()->currencyCode(),
            OfficeConstant::COUNTRY => fake()->country(),
            OfficeConstant::STATE => fake()->city(),
            OfficeConstant::LONGITUDE => fake()->longitude(),
            OfficeConstant::LATITUDE => fake()->latitude(),
        ];
    }
}
