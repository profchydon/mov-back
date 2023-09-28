<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PlanRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlanController extends Controller
{
    public function __construct(private readonly PlanRepositoryInterface $planRepository)
    {
    }

    public function index(Request $request)
    {
        $plans = $this->planRepository->getPlans();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $plans);
    }
}
