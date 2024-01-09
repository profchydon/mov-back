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
            'Computer & Equipment',
            'Furniture & Fixtures',
            'Machinery & Equipment',
            'Vehicles',
            'Building & Real Estate',
            'Others',
        ];

        foreach ($types as $type) {
            AssetType::updateOrCreate([
                AssetTypeConstant::NAME => $type,
            ], [
                AssetTypeConstant::NAME => $type,
                AssetTypeConstant::STATUS => AssetTypeStatusEnum::ACTIVE->value,
            ]);
        }
    }
}
