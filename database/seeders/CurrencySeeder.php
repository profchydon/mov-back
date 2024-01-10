<?php

namespace Database\Seeders;

use App\Domains\Constant\CurrencyConstant;
use App\Models\Currency;
use Illuminate\Database\Seeder;
use Symfony\Component\Yaml\Yaml;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = base_path('database/seeders/config/currencies.yaml');

        $currencies = Yaml::parseFile($file);

        foreach ($currencies as $currency) {
            Currency::updateOrCreate([
                CurrencyConstant::NAME => $currency['name'],
            ], [
                CurrencyConstant::NAME => $currency['name'],
                CurrencyConstant::CODE => $currency['code'],
                CurrencyConstant::SYMBOL => $currency['symbol'],
            ]);
        }
    }
}
