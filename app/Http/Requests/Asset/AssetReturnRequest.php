<?php

namespace App\Http\Requests\Asset;

use App\Domains\Constant\Asset\AssetCheckoutConstant;
use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\Enum\Asset\AssetStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetReturnRequest extends FormRequest
{
    public function rules(): array
    {
        $groupId = $this->route('groupId');
        return [
            'return_note' => 'nullable|string|min:3',
            'date_returned' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'assets' => ['required', 'array', 'min:1'],
            'assets.*' => [
                'required',
                Rule::exists('assets', 'id')->where(AssetConstant::STATUS, AssetStatusEnum::CHECKED_OUT),
                Rule::exists('asset_checkouts', 'asset_id')->where(AssetCheckoutConstant::GROUP_ID, $groupId)
            ],
        ];
    }

    public function messages()
    {
        $groupId = $this->route('groupId');
        return [
            'assets.required' => 'You must provide the list of assets to return.',
            'assets.min' => 'There must be a mininum of :min asset to be returned.',
            'assets.*' => "One or more assets to be returned does not exist or does not belong to the same checkout group with id {$groupId}."
        ];
    }
}
