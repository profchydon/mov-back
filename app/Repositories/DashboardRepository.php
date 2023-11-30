<?php

namespace App\Repositories;

use App\Models\Asset;
use App\Models\Company;
use App\Repositories\Contracts\DashboardRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;
use Spatie\Activitylog\Models\Activity;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getCompanyDashboardData(Company|string $company)
    {
        if (!($company instanceof Company)) {
            $company = Company::findOrFail($company);
        }

        $data = new Fluent();

        $query = $company->assets();
        $query = Asset::appendToQueryFromRequestQueryParameters($query);
        $data->assetCount = $query->count();

        $assetQuery = $company->assets();

        $query = $assetQuery->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count');
        $query = Asset::appendToQueryFromRequestQueryParameters($query);
        $data->assetsCountByMonth = $query->get();

        $query = $assetQuery->groupBy('status')->select('status', DB::raw('COUNT(*) as count'));
        $query = Asset::appendToQueryFromRequestQueryParameters($query);
        $data->assetConditions = $query->get();

        $query = $assetQuery->with('type')->groupBy('type_id')->select('type_id', DB::raw('COUNT(*) as count'));
        $query = Asset::appendToQueryFromRequestQueryParameters($query);
        $data->assetCategories = $query->get();

        $query = Asset::appendToQueryFromRequestQueryParameters($assetQuery);
        $data->assetSum = $query->sum('purchase_price');

        $query = Asset::appendToQueryFromRequestQueryParameters($assetQuery);
        $data->assetAverage = $query->average('purchase_price');

        $query = Activity::where('subject_type', Asset::class)->where('event', 'created');
        $query = $query->whereIn('subject_id', $company->assets()->orderBy('created_at', 'desc')->limit(20)->pluck('id'));
        $query = $query->with('causer');
        $data->assetActivity = $query->get();


        return $data;
    }
}
