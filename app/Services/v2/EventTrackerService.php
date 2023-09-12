<?php

namespace App\Services\v2;

use Segment\Segment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Domains\Enum\EventTrack\EventTrackEnum;

class EventTrackerService
{

    public function __construct()
    {
        // class_alias('Segment', 'Analytics');
        Segment::init(env('SEGMENT_KEY'));
    }


    public static function identify($user)
    {
        Segment::init(env('SEGMENT_KEY'));
        Log::info("Dispatch Identify Event.");
        Segment::identify($user);
    }

    public static function track(?string $user_id, ?string $event, ?array $properties)
    {
        Segment::init(env('SEGMENT_KEY'));
        Log::info("Dispatch Tracking Event.");
        Segment::track(array(
            "userId" => $user_id,
            "event" => $event,
            "properties" => $properties
        ));
    }
}
