<?php

namespace App\Listeners\User;

use App\Events\User\UserInvitationCreatedEvent;
use App\Mail\CompanyUserInvitationEmail;
use App\Services\V2\EventTrackerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserInvitationCreatedListener
{
    /**
     * UserInvitationCreatedListener constructor.
     * @param EventTrackerService $eventService
     */
    public function __construct()
    {
        //
    }

    public function handle(UserInvitationCreatedEvent $event)
    {
        $invitation = $event->userInvitation;

        //Send Invitation email
        Mail::to($invitation->email)->queue(new CompanyUserInvitationEmail($invitation));

        Log::info("User Invitation Sent to {$invitation->email} {$invitation}");

        return true;
    }
}
