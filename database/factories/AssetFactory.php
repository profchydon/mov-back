<?php

namespace Database\Factories;

use App\Domains\Constant\AssetConstant;
use App\Models\AssetType;
use App\Models\Company;
use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    public function definition(): array
    {
        $company = Company::inRandomOrder()->first() ?? Company::factory()->create();
        $office = Office::inRandomOrder()->first() ?? Office::factory()->create();
        $officeArea = $office->areas()->create([
            'name' => fake()->word(),
            'tenant_id' => $company->tenant_id,
        ]);

        return [
            AssetConstant::TENANT_ID => $company->tenant_id,
            AssetConstant::COMPANY_ID => $company->id,
            AssetConstant::MAKE => fake()->word(),
            AssetConstant::MODEL => fake()->word(),
//            AssetConstant::SERIAL_NUMBER => fake()->regexify('/^[A-Za-z0-9]+$/'),
            AssetConstant::TYPE_ID => AssetType::factory(),
            AssetConstant::PURCHASE_PRICE => fake()->numberBetween(10000, 99999),
            AssetConstant::PURCHASE_DATE => fake()->date('Y-m-d'),
            AssetConstant::OFFICE_ID => $office->id,
            AssetConstant::OFFICE_AREA_ID => $officeArea->id,
            AssetConstant::CURRENCY => 'NGN',
            AssetConstant::ADDED_AT => now(),
            AssetConstant::STATUS => fake()->randomElement(['AVAILABLE', 'ARCHIVED']),
        ];
    }

    public function assigned(): static
    {
        return $this->state(fn (array $attributes) => [
            AssetConstant::ASSIGNED_TO => User::factory(),
            AssetConstant::ASSIGNED_DATE => now(),
        ]);
    }
}
