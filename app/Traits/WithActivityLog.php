<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait WithActivityLog
{
    use LogsActivity;

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn($eventName) => $this->getEventDescription($eventName))
            ->logAll();
    }

    public function getLogNameToUse(): ?string
    {
        return 'Core Backend';
    }

    public function getEventDescription($eventName)
    {
        $className = explode('\\', static::class);
        $className = array_pop($className);
        Log::info("I got here");
        return "{$className} was {$eventName}";
    }
}
