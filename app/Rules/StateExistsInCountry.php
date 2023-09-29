<?php

namespace App\Rules;

use App\Models\Country;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class StateExistsInCountry implements ValidationRule
{
    public function __construct(private readonly string $countryName)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $country = Country::where('name', $this->countryName)->first();

        if (empty($country)) {
            $fail('The :attribute not match a valid country name');
        }

        $states = collect($country->states);

        Log::info($states);

        if (!$states->contains($value)) {
            $fail('The :attribute does not exist in selected country');
        }
    }
}
