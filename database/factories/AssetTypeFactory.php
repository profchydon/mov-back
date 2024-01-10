<?php

namespace Database\Factories;

use App\Domains\Constant\AssetTypeConstant;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetTypeFactory extends Factory
{
    public function definition(): array
    {
        $asset_types = ['Computer', 'Vehicle', 'Phone', 'Machinery'];

        return [
            AssetTypeConstant::NAME => fake()->randomElement($asset_types),
        ];
    }
}
