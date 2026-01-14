<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertReview extends Model
{
    //
    protected $table = 'advert_reviews';

    protected $fillable = [
        'advert_id',
        'comment',
        'user_id',
    ];

    public function advert()
    {
        return $this->belongsTo(Advert::class, 'advert_id');
    }
}
