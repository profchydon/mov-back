<?php

namespace App\Listeners\user;

use App\Mail\UserCreatedMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\v2\EventTrackerService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Domains\Enum\EventTrack\EventTrackEnum;
use App\Events\SubscriptionActivatedEvent;

class SubscriptionActivatedListener
{

    /**
     * UserCreatedListener constructor.
     * @param EventTrackerService $eventService
     *
     */
    public function __construct()
    {
        //
    }


    public function handle(SubscriptionActivatedEvent $event)
    {

        $subscription = $event->subscription;

        //Send Welcome email
        Mail::to($user->email)->queue(new UserCreatedMail($user));

        //Trigger user created event
        EventTrackerService::track($user->email, EventTrackEnum::USER_CREATED->value, (array) $user);

        Log::info("Info: User Account Created {$user}");

        return true;
    }
}
