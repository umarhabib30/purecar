<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class advert extends Model
{
    protected $table = 'adverts';
    protected $primaryKey = 'advert_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'image',
        'main_image',
        'name',
        'license_plate',
        'miles',
        'engine',
        'owner',
        'description',
        'date_posted',
        'expiry_date',
        'status',
        'subscription',
        'email_sent',
        'view_count',
        'message_count',
        'call_count',
        'favourite',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'advert_id', 'advert_id');
    }
    public function car()
    {
        return $this->hasOne(Car::class, 'advert_id', 'advert_id');
    }
    public function images()
    {
        return $this->hasMany(AdvertImage::class, 'advert_id', 'advert_id');
    }

    public function reviews()
    {
        return $this->hasMany(AdvertReview::class, 'advert_id', 'advert_id');
    }
        public function counters()
    {
        return $this->hasMany(Counter::class, 'advert_id', 'advert_id');
    }
    public function advert_images()
    {
        return $this->hasMany(AdvertImage::class, 'advert_id', 'advert_id');
    }
    public function payment()
    {
        return $this->belongsTo(PaymentRecord::class, 'advert_id','advert_id');
    }
     public function notes()
    {
        return $this->belongsToMany(Note::class, 'advert_note', 'advert_id', 'note_id')
            ->withTimestamps();
    }



}
