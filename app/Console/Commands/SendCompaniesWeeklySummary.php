<?php

namespace App\Console\Commands;

use App\Jobs\CompanyWeeklyAssetSummaryJob;
use App\Models\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendCompaniesWeeklySummary extends Command
{

    protected $signature = 'companies:send-weekly-summary';


    protected $description = 'Command description';

    public function handle()
    {
        Company::active()->chunk(50, function($companies){
            $companies->each(fn($company) => CompanyWeeklyAssetSummaryJob::dispatch($company));
        });

        $this->info("Initiated weekly report for current week");
    }
}
