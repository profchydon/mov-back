<?php

namespace App\Jobs;

use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Mail\SendCompanyAssetWeeklyReport;
use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Fluent;
use Illuminate\Support\Number;

class CompanyWeeklyAssetSummaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(private readonly Company $company)
    {
        $this->company->refresh();
    }


    public function handle(): void
    {
        $assetObject = new Fluent();

        $assetObject->totalAsset = Number::abbreviate($this->company->assets()->count(), 2);
        $assetObject->totalAssetValue = Number::abbreviate($this->company->assets()->sum('purchase_price'), 2);

        $assetObject->totalAssetAdded = Number::abbreviate($this->company->assets()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(), 2);
        $assetObject->totalAssetAddedValue = Number::abbreviate($this->company->assets()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('purchase_price'), 2);

        $assetObject->totalCheckedOutAsset = Number::abbreviate($this->company->assets()->status([AssetStatusEnum::CHECKED_OUT])->count(), 2);
        $assetObject->totalCheckedOutAssetValue = Number::abbreviate($this->company->assets()->status([AssetStatusEnum::CHECKED_OUT])->sum('purchase_price'), 2);

        $assetObject->totalInsuredAsset = Number::abbreviate($this->company->assets()->insured()->count(), 2);
        $assetObject->totalInsuredAssetValue = Number::abbreviate($this->company->assets()->insured()->sum('purchase_price'), 2);

        $assetObject->totalUnInsuredAsset = Number::abbreviate($this->company->assets()->unInsured()->count(), 2);
        $assetObject->totalUnInsuredAssetValue = Number::abbreviate($this->company->assets()->unInsured()->sum('purchase_price'), 2);

        $assetObject->totalAssetDueMaintenance = Number::abbreviate($this->company->assets()->whereBetween('next_maintenance_date', [now()->startOfWeek(), now()->endOfWeek()])->count(), 2);
        $assetObject->totalAssetDueMaintenanceValue = Number::abbreviate($this->company->assets()->whereBetween('next_maintenance_date', [now()->startOfWeek(), now()->endOfWeek()])->sum('purchase_price'), 2);

        Mail::to($this->company->email)->queue(new SendCompanyAssetWeeklyReport($this->company, $assetObject));
    }
}
