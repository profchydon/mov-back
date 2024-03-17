<?php

namespace App\Console\Commands;

use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ActivateDueSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:activate-due-subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Activating expired subscriptions...');

        Subscription::where('status', SubscriptionStatusEnum::INACTIVE)
            ->where('start_date', '<=', now()->format('Y-m-d'))
            ->with('payment')
            ->chunk(50, function($models){
                foreach ($models as $model){
                    if(Str::lower($model->payment->status) == 'completed'){
                        $model->activate();
                    }
                }
            });
    }
}
