<?php

namespace App\Http\Requests\Asset;

use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\Enum\Asset\AssetStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetMaintenanceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reason' => 'required|string|min:3',
            'receiver_id' => ['required', Rule::exists('users', 'id')],
            'scheduled_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'return_date' => ['sometimes', 'nullable', 'date_format:Y-m-d', 'after_or_equal:checkout_date'],
            'comment' => ['sometimes'],
            'assets' => ['required', 'array', 'min:1'],
            'assets.*' => ['required', Rule::exists('assets', 'id')->whereNot(AssetConstant::STATUS, AssetStatusEnum::STOLEN->value)],
        ];
    }
}
