<?php

namespace App\Repositories;

use App\Models\ActivityLog;
use App\Models\Company;
use App\Models\User;
use App\Repositories\Contracts\ActivityLogRepositoryInterface;
use Illuminate\Support\Facades\Log;

class ActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function getActivityLogs(Company $company)
    {
        $query = ActivityLog::query();
        $query->whereCauserType(User::class);
        $query->whereIn('causer_id', $company->users()->pluck('user_id'));
        $query = ActivityLog::appendToQueryFromRequestQueryParameters($query);

        // Add orderBy clause to sort by most recent
        $query->orderBy('created_at', 'desc');

        return $query->paginate();
    }
}
