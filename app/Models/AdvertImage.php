<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertImage extends Model
{
    protected $table = 'advert_images'; 
    protected $primaryKey = 'advert_id';

    protected $fillable = [
        'advert_id',
        'image_url',
    ];

    public function advert()
    {
        return $this->belongsTo(Advert::class, 'advert_id', 'advert_id');
    }
}
