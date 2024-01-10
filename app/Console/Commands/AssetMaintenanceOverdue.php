<?php

namespace App\Console\Commands;

use App\Domains\Auth\PermissionTypes;
use App\Mail\OverdueAssetMaintenanceEmail;
use App\Models\Asset;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AssetMaintenanceOverdue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'overdue-asset-maintenance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to users for assets overdue for maintenance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->sendOverdueAssetMaintenanceNotification();

        return 0;
    }

    private function sendOverdueAssetMaintenanceNotification()
    {
        $now = Carbon::now();

        $companies = DB::table('assets')
            ->select('company_id')
            ->where('next_maintenance_date', '<', $now)
            ->groupBy('company_id')
            ->get();

        foreach ($companies as $companyId) {
            $assets = Asset::with(['company'])
                ->where('next_maintenance_date', '<', $now)
                ->where('company_id', $companyId)
                ->get();

            $company = Company::with('users')->where('id', $companyId)->first();

            $users = $company->users->filter(
                fn ($user) => $user->hasAnyPermission([PermissionTypes::ASSET_FULL_ACCESS->value])
            )->values();

            foreach ($users as $user) {
                Mail::to($user->email)->queue(new OverdueAssetMaintenanceEmail($user, $assets));
            }
        }
    }
}
