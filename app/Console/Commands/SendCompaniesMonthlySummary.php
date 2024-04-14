<?php

namespace App\Console\Commands;

use App\Jobs\CompanyMonthlyAssetSummaryJob;
use App\Jobs\CompanyWeeklyAssetSummaryJob;
use App\Models\Company;
use Illuminate\Console\Command;

class SendCompaniesMonthlySummary extends Command
{

    protected $signature = 'companies:send-monthly-summary';


    protected $description = 'Command description';


    public function handle()
    {
        Company::active()->chunk(50, function($companies){
            $companies->each(fn($company) => CompanyMonthlyAssetSummaryJob::dispatch($company));
        });

        $this->info("Initiated month report for current month");
    }
}
