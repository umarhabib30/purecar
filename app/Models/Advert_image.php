<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advert_image extends Model
{
    //
    protected $table='advert_images';
    protected $primaryKey = 'image_id';

    protected $fillable=[
        'advert_id',
        'image_url',
    ];

    public function adverts()
{
    return $this->belongsTo(Advert::class, 'advert_id', 'advert_id');
}
}

