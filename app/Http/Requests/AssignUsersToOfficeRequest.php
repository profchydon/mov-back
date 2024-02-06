<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AssignUsersToOfficeRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => ['required',Rule::exists('users', 'id'), Rule::unique('office_users', 'user_id')]
        ];
    }
}
