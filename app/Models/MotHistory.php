<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotHistory extends Model
{
    protected $fillable = [
        'vrm',
        'test_date',
        'test_number',
        'test_result',
        'odometer_reading',
        'odometer_unit',
        'expiry_date',
        'advisory_notices'
    ];

    protected $casts = [
        'test_date' => 'date',
        'expiry_date' => 'date',
        'advisory_notices' => 'array'
    ];
}