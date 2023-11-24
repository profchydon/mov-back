<?php

namespace App\Console\Commands;

use App\Domains\Auth\PermissionTypes;
use App\Mail\UpcomingAssetMaintenanceEmail;
use App\Models\Asset;
use App\Models\Company;
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
        $this->sendSevenDaysToMaintenanceNotification();
    }

    private function sendSevenDaysToMaintenanceNotification()
    {
        $sevenDays = date('Y-m-d', strtotime('+7 days'));
        $eightDays = date('Y-m-d', strtotime('+8 days'));

        $companies = DB::table('assets')
            ->select('company_id')
            ->where('next_maintenance_date', '>=', $sevenDays)
            ->where('next_maintenance_date', '<', $eightDays)
            ->groupBy('company_id')
            ->get();

        foreach ($companies as $companyId) {
            $assets = Asset::with(['company'])
                ->where('next_maintenance_date', '>=', $sevenDays)
                ->where('next_maintenance_date', '<', $eightDays)
                ->where('company_id', $companyId)
                ->get();

            $company = Company::with('users')->where('id', $companyId)->first();

            $users = $company->users->filter(
                fn ($user) => $user->hasAnyPermission([PermissionTypes::ASSET_FULL_ACCESS->value])
            )->values();

            foreach ($users as $user) {
                Mail::to($user->email)->queue(new UpcomingAssetMaintenanceEmail($user, $assets, '7 days'));
            }
        }
    }
}
