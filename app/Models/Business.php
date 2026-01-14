<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Business extends Model
{
     use HasFactory, HasSlug;

    protected $fillable = [
        'name','slug', 'business_type_id', 'business_location_id', 'contact_no', 'email', 'address', 'website', 'description', 'is_approved'
    ];
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->preventOverwrite();
    }
    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }

    public function businessLocation()
    {
        return $this->belongsTo(BusinessLocation::class);
    }

    public function images()
    {
        return $this->hasMany(BusinessImage::class);
    }
}