<?php

namespace Database\Seeders;

use App\Domains\Constant\CommonConstant;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Symfony\Component\Yaml\Yaml;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $file = base_path('database/seeders/config/countries.yaml');

        $countries = Yaml::parseFile($file);

        foreach ($countries as $country) {
            Country::updateOrCreate([
                CommonConstant::NAME => $country['name'],
            ], [
                CommonConstant::NAME => $country['name'],
                CommonConstant::CODE => $country['code'],
                CommonConstant::STATES => $country['states'],
            ]);
        }
    }
}
