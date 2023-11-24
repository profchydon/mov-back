<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendAssetMaintenanceNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-asset-maintenance-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all asset maintenance email notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
    }

    
}
