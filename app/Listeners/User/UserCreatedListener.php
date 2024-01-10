<?php

namespace App\Listeners\User;

use App\Domains\Enum\EventTrack\EventTrackEnum;
use App\Events\User\UserCreatedEvent;
use App\Mail\UserCreatedMail;
use App\Services\V2\EventTrackerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserCreatedListener
{
    /**
     * UserCreatedListener constructor.
     * @param EventTrackerService $eventService
     */
    public function __construct()
    {
        //
    }

    public function handle(UserCreatedEvent $event)
    {
        $user = $event->user;

        //Send Welcome email
        Mail::to($user->email)->queue(new UserCreatedMail($user));

        //Trigger user created event
        EventTrackerService::track($user->email, EventTrackEnum::USER_CREATED->value, (array) $user);

        Log::info("Info: User Account Created {$user}");

        return true;
    }
}
