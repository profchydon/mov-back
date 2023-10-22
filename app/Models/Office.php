<?php

namespace App\Models;

use App\Domains\Constant\OfficeConstant;
use App\Domains\Enum\Office\OfficeStatusEnum;
use App\Traits\GetsTableName;
use App\Traits\QueryFormatter;
use App\Traits\UsesUUID;
use App\Traits\WithActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Office extends BaseModel
{
    use UsesUUID;

    protected $guarded = [
        OfficeConstant::ID,
    ];

    protected $casts = [
        OfficeConstant::ID => 'string',
        OfficeConstant::STATUS => OfficeStatusEnum::class,
    ];

    protected $hidden = [
        OfficeConstant::TENANT_ID,
    ];

    protected static array $searchable = [
        'offices.name', 'offices.street_address',
    ];

    protected static array $filterable = [
        'company' => 'offices.company_id',
        'country' => 'offices.country',
    ];

    public function areas(): HasMany
    {
        return $this->hasMany(OfficeArea::class, 'office_id');
    }
}
