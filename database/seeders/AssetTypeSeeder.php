<?php

namespace Database\Seeders;

use App\Domains\Constant\Asset\AssetTypeConstant;
use App\Domains\Enum\Asset\AssetTypeStatusEnum;
use App\Models\AssetType;
use Illuminate\Database\Seeder;

class AssetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Mobile Phone',
            'Laptop',
            'Desktop',
            'Vehicle',
            'Furniture',
        ];

        foreach ($types as $type) {
            AssetType::create([
                AssetTypeConstant::NAME => $type,
                AssetTypeConstant::STATUS => AssetTypeStatusEnum::ACTIVE->value,
            ]);
        }
    }
}
