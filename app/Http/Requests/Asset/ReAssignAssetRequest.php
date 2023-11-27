<?php

namespace App\Http\Requests\Asset;

use App\Domains\Constant\CompanyConstant;
use App\Domains\DTO\Asset\CreateAssetDTO;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Rules\HumanNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReAssignAssetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $company = $this->route('company');

        return [
            'from' => ['required', Rule::exists('users', 'id')],
            'to' => ['required', Rule::exists('users', 'id')],
        ];
    }
}
