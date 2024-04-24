<?php

namespace App\Jobs;

use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Mail\SendCompanyAssetMonthlyReport;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Fluent;
use Illuminate\Support\Number;

class CompanyMonthlyAssetSummaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Company $company)
    {
        $this->company->refresh();
    }

    public function handle(): void
    {
        $assetObject = new Fluent();
        $assetObject->overallScore = Number::abbreviate($this->company->assets()->average('score'));
        $assetObject->grade = Asset::getScoreGrade($assetObject->overallScore);

        $assetTypes = $this->company->assets()->groupBy('type_id')->pluck('type_id');
        $assetTypes->map(function($type){
            return [
                'name' => AssetType::find($type)->name,
                'units' => $this->company->assets()->whereTypeId($type)->count(),
                'insured' => $this->company->assets()->whereTypeId($type)->whereIsInsured(true)->count(),
                'bad' => $this->company->assets()->whereTypeId($type)->whereStatus(AssetStatusEnum::DAMAGED)->count(),
                'score' => $this->company->assets()->whereTypeId($type)->average('score')
            ];
        });

        $assetObject->types = $assetTypes;

        Mail::to($this->company->email)->queue(new SendCompanyAssetMonthlyReport($this->company, $assetObject));
    }
}
