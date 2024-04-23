<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\V2\ZohoCampaignService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUserToCampaignList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(private User $user, private string $listKey)
    {
        //
    }

    public function handle(): void
    {
        //
    }
}
