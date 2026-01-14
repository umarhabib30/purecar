<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $table = 'reviews'; 
    protected $fillable = [
        'seller_id',
        'auth_id',
        'reviews',
        'rating'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'auth_id');
    }
}
