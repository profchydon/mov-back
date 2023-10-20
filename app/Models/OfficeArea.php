<?php

namespace App\Models;

use App\Domains\Constant\OfficeConstant;
use App\Domains\Enum\Office\OfficeStatusEnum;
use App\Traits\GetsTableName;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class OfficeArea extends BaseModel
{
    use UsesUUID, SoftDeletes;

    protected $guarded = [
        OfficeConstant::ID,
    ];

    protected $hidden = [
        OfficeConstant::TENANT_ID,
    ];

    protected $casts = [
        OfficeConstant::ID => 'string',
        OfficeConstant::STATUS => OfficeStatusEnum::class,
    ];

    /**
     * Generate a new UUID for the model.
     *
     * @return string
     */
    public function newUniqueId()
    {
        return (string) Uuid::uuid4();
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array
     */
    public function uniqueIds()
    {
        return ['id'];
    }

    public static function boot()
    {
        parent::boot();
    }
}
