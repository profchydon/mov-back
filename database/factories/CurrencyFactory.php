<?php

namespace Database\Factories;

use App\Domains\Constant\CurrencyConstant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\Yaml\Yaml;

class CurrencyFactory extends Factory
{
    public function definition(): array
    {
        $file = base_path('database/seeders/config/currencies.yaml');

        $currencies = Yaml::parseFile($file);

        foreach ($currencies as $currency) {
            return [
                CurrencyConstant::NAME => $currency['name'],
                CurrencyConstant::CODE => $currency['code'],
                CurrencyConstant::SYMBOL => $currency['symbol'],
            ];
        }
    }
}
