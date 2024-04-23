<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Repositories\Contracts\ActivityLogRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActivityLogController extends Controller
{
    public function __construct(private ActivityLogRepositoryInterface $logController)
    {

    }

    public function index(Company $company, Request $request)
    {
        $logs = $this->logController->getActivityLogs($company);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $logs);
    }
}
