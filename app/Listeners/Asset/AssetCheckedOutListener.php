<?php

namespace App\Listeners\Asset;

use App\Domains\Enum\EventTrack\EventTrackEnum;
use App\Events\Asset\AssetCheckedOutEvent;
use App\Mail\SubscriptionActivationMail;
use App\Repositories\Contracts\AssetMaintenanceRepositoryInterface;
use App\Services\V2\EventTrackerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AssetCheckedOutListener
{
    /**
     * AssetCheckedOutListener constructor.
     * @param EventTrackerService $eventService
     */
    public function __construct(private readonly AssetMaintenanceRepositoryInterface $maintenanceRepository)
    {
    }

    public function handle(AssetCheckedOutEvent $event)
    {
        $checkout = $event->checkout;
        $company = $checkout->company()->first();

        //Send email


        Log::info("Info: Asset Checkouted {$checkout}");

        return true;
    }


}
