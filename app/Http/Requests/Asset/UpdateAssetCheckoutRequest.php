<?php

namespace App\Http\Requests\Asset;

use App\Domains\DTO\Asset\AssetCheckoutDTO;
use App\Domains\Enum\Asset\AssetCheckoutStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class UpdateAssetCheckoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reason' => 'sometimes|string|min:3',
            'receiver_type' => ['sometimes', Rule::in(['user', 'vendor'])],
            'receiver_id' => [
                Rule::when(
                    fn ($input) => !empty($this->input('receiver_type')),
                    ['required', Rule::exists($this->input('receiver_type') . 's', 'id')]
                ),
            ],
            'checkout_date' => ['sometimes', 'date_format:Y-m-d', 'after_or_equal:today'],
            'return_date' => ['sometimes', 'date_format:Y-m-d', 'after_or_equal:checkout_date'],
            'comment' => ['sometimes', 'regex:/^[A-Za-z0-9 ]+$/'],
            'status' => ['sometimes', Rule::in(AssetCheckoutStatusEnum::values())],
        ];
    }

    public function updateAssetDTO()
    {
        $dto = new AssetCheckoutDTO();
        $dto->setReason($this->input('reason', null))
            ->setComment($this->input('comment', null))
            ->setReceiverType($this->input('receiver_type', null))
            ->setReceiverId($this->input('receiver_id', null));

        if (!empty($this->input('return_date'))) {
            $dto->setReturnDate(Carbon::createFromFormat('Y-m-d', $this->input('return_date')));
        }

        if (!empty($this->input('checkout_date'))) {
            $dto->setReturnDate(Carbon::createFromFormat('Y-m-d', $this->input('checkout_date')));
        }

        if (!empty($this->input('status'))) {
            $dto->setStatus($this->input('status'));
        }

        return $dto;
    }
}
