<?php

namespace App\Rules;

use App\Models\Country;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StateExistsInCountry implements ValidationRule
{
    public function __construct(private readonly ?string $countryName)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($this->countryName)) {
            return;
        }

        $country = Country::where('name', $this->countryName)->first();

        if (empty($country)) {
            $fail('The :attribute not match a valid country name');

            return;
        }

        $states = collect($country->states);

        if (!$states->contains($value)) {
            $fail('The :attribute does not exist in selected country');
        }
    }
}
