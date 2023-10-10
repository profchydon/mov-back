<?php

namespace App\Models;

use App\Domains\Constant\CompanyConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyOffice extends Model
{
    use HasFactory;


    protected $hidden = [
        CompanyConstant::TENANT_ID,
    ];
}
