<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    public function definition(): array
    {
        $company = Company::inRandomOrder()->first() ?? Company::factory()->create();

        return [
            'tenant_id' => $company->tenant_id,
            'company_id' => $company->id,
            'make' => fake()->word(),
//            'type' =>
        ];
    }
}
