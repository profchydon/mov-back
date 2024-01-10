<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = Company::inRandomOrder()->first() ?? Company::factory()->create();
        $department = Department::inRandomOrder()->first() ?? Department::factory()->create();

        return [
            'tenant_id' => $company->tenant_id,
            'company_id' => $company->id,
            'name' => fake()->word(),
            'department_id' => $department->id,
        ];
    }
}
