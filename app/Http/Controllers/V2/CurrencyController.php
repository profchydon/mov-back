<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CurrencyController extends Controller
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository
    ){}

    public function index()
    {
        $currencies = $this->currencyRepository->all();

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $currencies);
    }
}
