<?php

namespace App\Repositories;

use App\Http\Resources\Vendor\VendorCollection;
use App\Models\Company;
use App\Models\Vendor;
use App\Repositories\Contracts\VendorRepositoryInterface;

class VendorRepository extends BaseRepository implements VendorRepositoryInterface
{
    public function model(): string
    {
        return Vendor::class;
    }

    public function getVendors(Company|string $company, $relation = [])
    {
        if (!($company instanceof  Company)) {
            $company = Company::findOrFail($company);
        }

        $vendors = $company->vendors()->with($relation);
        $vendors = Vendor::appendToQueryFromRequestQueryParameters($vendors);
        $vendors = $vendors->paginate();

        return VendorCollection::make($vendors);
    }
}
