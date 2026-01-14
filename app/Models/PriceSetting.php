<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceSetting extends Model
{
    protected $table = 'price_settings';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'min_price',
        'max_price'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'min_price' => 'decimal:2',
        'max_price' => 'decimal:2'
    ];
}