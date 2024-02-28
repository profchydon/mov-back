<?php

namespace App\Console\Commands;

use App\Domains\Constant\SubscriptionConstant;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Models\Subscription;
use Illuminate\Console\Command;

class DeactivateExpiredSubscription extends Command
{

    protected $signature = 'app:deactivate-expired-subscription';


    protected $description = 'Update the statuses of all expired subscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $updatedRecords = Subscription::where('end_date', now()->format('Y-m-d'))->update([
            SubscriptionConstant::STATUS => SubscriptionStatusEnum::EXPIRED
        ]);

        // $updatedRecords = Subscription::where('end_date', '<=', now()->format('Y-m-d'))->update([
        //     SubscriptionConstant::STATUS => SubscriptionStatusEnum::EXPIRED
        // ]);

        $this->info("Updated {$updatedRecords} subscription(s) to expired");
    }
}
