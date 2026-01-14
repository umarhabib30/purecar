<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'advert_id',
        'advert_name',
        'seller_email',
        'full_name',
        'email',
        'phone_number',
        'message',
    ];

    public function advert()
    {
        return $this->belongsTo(Advert::class, 'advert_id', 'advert_id');
    }
}