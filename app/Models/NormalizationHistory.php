<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NormalizationHistory extends Model
{
    protected $table = 'normalization_history';
    
    protected $fillable = [
        'category',
        'raw_value',
        'old_normalized_value',
        'new_normalized_value',
        'affected_records',
        'action',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}