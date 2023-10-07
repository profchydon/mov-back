<?php

namespace Database\Factories;

use App\Domains\Constant\AssetTypeConstant;
use App\Models\AssetType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetTypeFactory extends Factory
{
    public function definition(): array
    {

        $asset_types = [ 'Computer', 'Vehicle', 'Phone', 'Machinery'];

        return [
            AssetTypeConstant::NAME => $asset_types[array_rand($asset_types)],
        ];
    }
}
