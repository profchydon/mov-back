<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Repositories\Contracts\DashboardRepositoryInterface;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardRepositoryInterface $dashboardRepository)
    {
    }

    public function index(Company $company)
    {
        $dashboard = $this->dashboardRepository->getCompanyDashboardData($company);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $dashboard);
    }
}
