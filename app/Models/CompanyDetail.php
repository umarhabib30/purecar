<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name', 'about_us', 'instagram', 'youtube',
        'facebook', 'linkedin', 'x', 'email',
        'phone', 'address', 'ad_cost','ad_expiry',
    ];

}
