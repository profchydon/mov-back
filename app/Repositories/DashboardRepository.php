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

        $assetQuery = $company->assets();
        $query = Asset::appendToQueryFromRequestQueryParameters($assetQuery);
        $data->assetCount = $query->count();

        $assetQuery = $company->assets();
        $query = $assetQuery->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count');
        $query = Asset::appendToQueryFromRequestQueryParameters($query);
        $data->assetsCountByMonth = $query->get();

        $assetQuery = $company->assets();
        $query = $assetQuery->groupBy('status')->select('status', DB::raw('COUNT(*) as count'));
        $query = Asset::appendToQueryFromRequestQueryParameters($query);
        $data->assetConditions = $query->get();

        $assetQuery = $company->assets();
        $query = $assetQuery->with('type')->groupBy('type_id')->select('type_id', DB::raw('COUNT(*) as count'));
        $query = Asset::appendToQueryFromRequestQueryParameters($query);
        $data->assetCategories = $query->get();

        $assetQuery = $company->assets();
        $query = Asset::appendToQueryFromRequestQueryParameters($assetQuery);
        $data->assetSum = $query->sum('purchase_price');

        $assetQuery = $company->assets();
        $query = Asset::appendToQueryFromRequestQueryParameters($assetQuery);
        $data->assetAverage = $query->average('purchase_price');

//        $assetQuery = $company->assets();
//
//        $assets = $assetQuery->with('office')->groupBy('offices.country');
////        $assets
////        $assets = $assets->join('companies', 'companies.id', '=', 'assets.company_id',);
////        $assets = $assets->groupBy('companies.country', 'companies.id');
//////        $assets->get();
////        $assets = $assetQuery->groupBy('companies.country');
//        $data->assetCountries = $assets->get();

        $query = Activity::where('subject_type', Asset::class)->where('event', 'created');
        $query = $query->whereIn('subject_id', $company->assets()->orderBy('created_at', 'desc')->limit(20)->pluck('id'));
        $query = $query->with('causer');
        $data->assetActivity = $query->get();


        return $data;
    }
}
