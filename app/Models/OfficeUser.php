<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeUser extends BaseModel
{
    use HasFactory;

    protected function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    protected function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
