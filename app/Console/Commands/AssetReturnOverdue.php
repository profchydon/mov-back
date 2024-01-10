<?php

namespace App\Console\Commands;

use App\Domains\Auth\PermissionTypes;
use App\Domains\Enum\Asset\AssetCheckoutStatusEnum;
use App\Mail\OverdueAssetReturnEmail;
use App\Models\AssetCheckout;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AssetReturnOverdue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset-return-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notification for assets that have not been returned';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->sendReturnAssetNotification();

        return 0;
    }

    private function sendReturnAssetNotification()
    {
        $now = Carbon::now();

        $companies = DB::table('asset_checkouts')
            ->select('company_id')
            ->where('return_date', '<', $now)
            ->where('status', '!=', AssetCheckoutStatusEnum::RETURNED->value)
            ->groupBy('company_id')
            ->get();

        foreach ($companies as $companyId) {
            $checkouts = AssetCheckout::with('asset')
                ->where('return_date', '<', $now)
                ->where('status', '!=', AssetCheckoutStatusEnum::RETURNED->value)
                ->where('company_id', $companyId)
                ->get();

            $company = Company::with('users')->where('id', $companyId)->first();

            $users = $company->users->filter(
                fn ($user) => $user->hasAnyPermission([PermissionTypes::ASSET_FULL_ACCESS->value])
            )->values();

            foreach ($users as $user) {
                Mail::to($user->email)->queue(new OverdueAssetReturnEmail($user, $checkouts));
            }
        }
    }
}
