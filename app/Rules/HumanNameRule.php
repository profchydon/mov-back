<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HumanNameRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^[A-Za-z\d\s\-]+$/';

        if (!preg_match($pattern, $value)) {
            $fail('The :attribute does not match a human name format');
        }
    }
}
