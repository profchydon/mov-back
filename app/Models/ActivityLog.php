<?php

namespace App\Models;

use App\Traits\QueryFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    use QueryFormatter;

    protected static array $searchable = [
        'description',
        'subject_id',
    ];


    protected static array $filterable = [
        'event' => 'event',
        'date' => 'created_at',
        'subject' => 'subject_type'
    ];

    protected $with = ['causer'];
}
