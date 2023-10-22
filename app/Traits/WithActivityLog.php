<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait WithActivityLog
{
    use LogsActivity;

    protected static $recordEvents = ['created','retrieved','updated','deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        $className = explode('\\', static::class);
        $className = array_pop($className);

        return LogOptions::defaults()
            ->setDescriptionForEvent(fn($eventName) => "{$className} was {$eventName}")
            ->logAll();
    }

    public function getLogNameToUse(): ?string
    {
        return 'Core Backend';
    }

}
