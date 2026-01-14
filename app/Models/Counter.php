<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = ['advert_id', 'counter_type'];


    public function advert()
    {
        return $this->belongsTo(Advert::class, 'advert_id', 'advert_id');
    }

}
