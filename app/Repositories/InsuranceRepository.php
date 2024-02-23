<?php

namespace App\Repositories;

use App\Domains\Constant\InsuranceConstant;
use App\Models\Company;
use App\Models\Insurance;
use App\Repositories\Contracts\InsuranceRepositoryInterface;

class InsuranceRepository extends BaseRepository implements InsuranceRepositoryInterface
{
    public function model()
    {
        return Insurance::class;
    }

    public function getCompanyInsurance(Company $company)
    {
        $insurance = $company->insurances()->withCount('assets');
        $insurance = Insurance::appendToQueryFromRequestQueryParameters($insurance);

        return $insurance->paginate();
    }

    public function getInsurance(string|Insurance $insurance)
    {
        if (!($insurance instanceof Insurance)) {
            $insurance = Insurance::findOrFail($insurance);
        }

        return $insurance->load('assets');
    }

    public function insureAssets(Insurance $insurance, array $assets)
    {
        return collect($assets)->each(function ($asset) use ($insurance) {
            return $insurance->assets()->create([
                InsuranceConstant::ASSET_ID => $asset
            ]);
        })->toArray();

    }
}
