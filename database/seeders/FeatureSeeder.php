<?php

namespace Database\Seeders;

use App\Domains\Constant\FeatureConstant;
use App\Domains\Constant\FeaturePriceConstant;
use App\Models\Feature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $directoryPath = base_path('database/seeders/config/features');
        $files = File::files($directoryPath);

        foreach ($files as $file) {
            $seedFile = Yaml::parseFile($file->getPathname());

            $features = Feature::updateOrCreate([
                FeatureConstant::NAME => $seedFile['name'],
            ], [
                FeatureConstant::NAME => $seedFile['name'],
                FeatureConstant::DESCRIPTION => $seedFile['description'],
                FeatureConstant::PRICING => $seedFile['pricing'] ?? null,
            ]);

            foreach ($seedFile['prices'] as $price) {
                $features->prices()->updateOrCreate([
                    FeaturePriceConstant::CURRENCY_CODE => $price['currency_code'],
                ], [
                    FeaturePriceConstant::CURRENCY_CODE => $price['currency_code'],
                    FeaturePriceConstant::PRICE => $price['price'],
                ]);
            }
        }
    }
}
