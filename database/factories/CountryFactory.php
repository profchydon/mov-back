<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Country;
use App\Domains\Constant\CommonConstant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CountryFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $states = [
            "Lagos"
        ];

        return [
            CommonConstant::NAME => $this->faker->country(),
            CommonConstant::CODE => $this->faker->countryCode(),
            CommonConstant::STATES => json_encode($states),
        ];
    }
}
