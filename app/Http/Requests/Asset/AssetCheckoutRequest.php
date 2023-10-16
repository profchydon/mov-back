<?php

namespace App\Http\Requests\Asset;

use App\Domains\DTO\Asset\AssetCheckoutDTO;
use App\Domains\Enum\Asset\AssetStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetCheckoutRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'reason' => 'required|string|min:3',
            'receiver_type' => ['sometimes', Rule::in(['user', 'vendor'])],
            'receiver_id' => [
                'sometimes',
                Rule::exists($this->input('receiver_type') . "s", 'id')
            ],
            'checkout_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'return_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:checkout_date'],
            // 'comment' => ['sometimes', 'regex:/^[A-Za-z0-9]+$/'],
            'comment' => ['sometimes'],
            'assets' => ['required', 'array', 'min:1'],
            'assets.*' => ['required', Rule::exists('assets', 'id')->where('status', AssetStatusEnum::AVAILABLE)]
        ];
    }
}
