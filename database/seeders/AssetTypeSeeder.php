<?php

namespace Database\Seeders;

use App\Domains\Constant\Asset\AssetTypeConstant;
use App\Domains\Enum\Asset\AssetTypeStatusEnum;
use App\Models\AssetType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $count = AssetType::count();

        if ($count == 0) {

            $types = [
                'Computer & Equipment',
                'Furniture & Fixtures',
                'Machinery & Equipment',
                'Vehicles',
                'Building & Real Estate',
                'Others',
            ];

            foreach ($types as $type) {
                AssetType::create([
                    AssetTypeConstant::NAME => $type,
                    AssetTypeConstant::STATUS => AssetTypeStatusEnum::ACTIVE->value,
                ]);
            }
        }
    }
}
