<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleKeeperData extends Model
{
    use HasFactory;

    protected $table = 'vehicle_keeper_data';

    protected $fillable = [
        'license_plate',
        'vehicle_data',
    ];

    protected $casts = [
        'vehicle_data' => 'array',
    ];
}
