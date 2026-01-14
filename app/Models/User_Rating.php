<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Rating extends Model
{
    //
    protected $table = 'user_ratings';

    protected $fillable=[
        'rating_id',
        'user_id',
        'rating'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
