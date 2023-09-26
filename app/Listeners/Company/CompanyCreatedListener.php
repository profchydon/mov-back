<?php

namespace App\Listeners\Company;


use App\Mail\CompanyCreatedMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\V2\EventTrackerService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Domains\Enum\EventTrack\EventTrackEnum;
use App\Events\Company\CompanyCreatedEvent;

class CompanyCreatedListener
{

    /**
     * CompanyCreatedListener constructor.
     * @param EventTrackerService $eventService
     *
     */
    public function __construct()
    {
        //
    }


    public function handle(CompanyCreatedEvent $event)
    {

        $company = $event->company;

        //Send Welcome email
        // Mail::to($company->email)->queue(new CompanyCreatedMail($company));

        //Trigger Company created event
        // EventTrackerService::track('chidi.nkwocha@rayda.co', EventTrackEnum::COMPANY_CREATED->value, (array) $company);

        Log::info("Info: Company Account Created {$company}");

        return true;
    }
}
