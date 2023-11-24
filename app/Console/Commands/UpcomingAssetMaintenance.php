<?php

namespace App\Console\Commands;

use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UpcomingAssetMaintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upcoming-asset-maintenance:seven-days';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send upcoming asset maintenance email notification seven days to the maintenance date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }

    private function sendSevenDaysToMaintenanceNotification() {
        $now = Carbon::now();

        $companies = DB::table('assets')
                 ->select('company_id', DB::raw('count(*) as total'))
                 ->where('next_maintenance_date', $now->addDays(7))
                 ->groupBy('company_id')
                 ->get();
    
        foreach($companies as $companyId){
            $assets = Asset::with(['company'])
                    ->where('next_maintenance_date', $now->addDays(7))
                    ->where('company_id', $companies)->get();

            Mail::to($invitation->email)->queue(new CompanyUserInvitationEmail($invitation));

        }
    }
}
