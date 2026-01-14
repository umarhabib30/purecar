<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleData extends Model
{
    use HasFactory;

    protected $table = 'vehicle_data';

    protected $fillable = ['license_plate', 'data'];

    protected $casts = [
        'data' => 'array',
    ];
}
