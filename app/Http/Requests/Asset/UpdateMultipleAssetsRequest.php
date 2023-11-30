<?php

namespace App\Http\Requests\Asset;

use App\Domains\Constant\CompanyConstant;
use App\Domains\DTO\Asset\CreateAssetDTO;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Rules\HumanNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMultipleAssetsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'assets' => ['required', 'array', Rule::exists('assets', 'id')],
        ];
    }
}
