<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotData extends Model
{
    use HasFactory;

    protected $table = 'mot_data';

    protected $fillable = [
        'license_plate',
        'mot_history',
    ];

    protected $casts = [
        'mot_history' => 'array',
    ];
}
