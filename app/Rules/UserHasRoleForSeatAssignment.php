<?php

namespace App\Rules;

use App\Domains\Auth\RoleTypes;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserHasRoleForSeatAssignment implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::findOrFail($value);

        $rolesCount = $user->roles()->where('roles.name', '!=', RoleTypes::BASIC->value)->count();

        if ($rolesCount < 1) {
            $fail('The :attribute needs a role other than basic to have a seat');
        }
    }
}
