<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition()
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => fake()->company(),
            'email' => fake()->companyEmail(),
            'size' => fake()->numberBetween(10, 500),
            'phone' => fake()->phoneNumber(),
            'industry' => fake()->randomElement(['Health', 'Entertainment', 'IT']),
            'address' => fake()->address(),
            'country' => fake()->country(),
            'state' => fake()->city(),
        ];
    }
}
