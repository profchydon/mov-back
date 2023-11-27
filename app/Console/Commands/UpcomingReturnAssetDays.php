<?php

namespace App\Console\Commands;

use App\Domains\Auth\PermissionTypes;
use App\Domains\Enum\Asset\AssetCheckoutStatusEnum;
use App\Mail\UpcomingAssetReturnEmail;
use App\Models\AssetCheckout;
use App\Models\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UpcomingReturnAssetDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upcoming-return-asset:days';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder about asset to be returned in 48hrs';

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
        $twoDays = date('Y-m-d', strtotime('+2 days'));
        $threeDays = date('Y-m-d', strtotime('+3 days'));

        $companies = DB::table('asset_checkouts')
            ->select('company_id')
            ->where('return_date', '>=', $twoDays)
            ->where('return_date', '<', $threeDays)
            ->where('status', '!=', AssetCheckoutStatusEnum::RETURNED->value)
            ->groupBy('company_id')
            ->get();

        foreach ($companies as $companyId) {
            $checkouts = AssetCheckout::with('asset')
                ->where('return_date', '>=', $twoDays)
                ->where('return_date', '<', $threeDays)
                ->where('status', '!=', AssetCheckoutStatusEnum::RETURNED->value)
                ->where('company_id', $companyId)
                ->get();

            $company = Company::with('users')->where('id', $companyId)->first();

            $users = $company->users->filter(
                fn ($user) => $user->hasAnyPermission([PermissionTypes::ASSET_FULL_ACCESS->value])
            )->values();

            foreach ($users as $user) {
                Mail::to($user->email)->queue(new UpcomingAssetReturnEmail($user, $checkouts, '48 hours'));
            }
        }
    }
}
