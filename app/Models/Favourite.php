<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    //
    protected $fillable = ['user', 'advert_id', 'favourite'];

    // Favourite belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Favourite belongs to an advert
    public function advert()
    {
        return $this->belongsTo(Advert::class, 'advert_id','user_id');
    }

    // User Model
    public function favouriteAdverts()
    {
        return $this->hasManyThrough(Advert::class, Favourite::class, 'user_id', 'advert_id');
    }


}
