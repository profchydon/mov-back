<?php

namespace App\Services\V2;

use Illuminate\Support\Facades\Log;
use Segment\Segment;

class EventTrackerService
{
    public function __construct()
    {
        Segment::init(env('SEGMENT_KEY'));
    }

    public static function identify(string $userId, array $traits)
    {
        Segment::init(env('SEGMENT_KEY'));
        Log::info('Dispatch Identify Event.');
        Segment::identify([
            'userId' => $userId,
            'traits' => $traits,
          ]);
    }

    public static function track(?string $user_id, ?string $event, ?array $properties)
    {
        Segment::init(env('SEGMENT_KEY'));
        Log::info('Dispatch Tracking Event.');
        Segment::track([
            'userId' => $user_id,
            'event' => $event,
            'properties' => $properties,
        ]);
    }
}
