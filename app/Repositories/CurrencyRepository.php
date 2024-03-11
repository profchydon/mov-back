<?php

namespace App\Repositories;

use App\Domains\Constant\CurrencyConstant;
use App\Domains\Enum\Currency\CurrencyStatusEnum;
use App\Models\Currency;
use App\Repositories\Contracts\CurrencyRepositoryInterface;

class CurrencyRepository extends BaseRepository implements CurrencyRepositoryInterface
{
    public function model(): string
    {
        return Currency::class;
    }

    public function all()  {
        return $this->model->where(CurrencyConstant::STATUS, CurrencyStatusEnum::ACTIVE->value)->get();
    }
}
