<?php

namespace App\Models;

 use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'background_image',
        'dealer_id',
        'source_type',
        'name',
        'email',
        'password',
        'plain_password',
        'remember_token',
        'last_login_at',
        'role',
        'phone_number',
        'watsaap_number',
        'location',
        'business_desc',
        'website',
        'email_verified_at',
        'lat', 
        'lng',
        'dealer_feed_url',
        'inquiry_email',
        'api'
    ];

    public function ratingsReceived()
    {
        return $this->hasMany(User_Rating::class); // Define foreign key 'user_id'
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'user_id');
    }

    // User has many adverts (from the advert's user_id foreign key)
    public function adverts()
    {
        return $this->hasMany(Advert::class, 'user_id');
    }

    // User has many favourite adverts through the Favourite model
    public function favouriteAdverts()
    {
        return $this->hasManyThrough(Advert::class, Favourite::class, 'user_id', 'advert_id');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($user) {
         
            $baseSlug = Str::slug($user->name . '-' . $user->location);
            
         
            $count = static::where('slug', 'LIKE', $baseSlug . '%')
                           ->count();
       
            $user->slug = $count ? "{$baseSlug}-" . ($count + 1) : $baseSlug;
        });
        
        static::updating(function ($user) {
            if ($user->isDirty('name') || $user->isDirty('location')) {
                $baseSlug = Str::slug($user->name . '-' . $user->location);
               
                $count = static::where('slug', 'LIKE', $baseSlug . '%')
                               ->where('id', '!=', $user->id)
                               ->count();
                $user->slug = $count ? "{$baseSlug}-" . ($count + 1) : $baseSlug;
            }
        });
    }



    public function feedSources()
    {
        return $this->hasMany(UserFeedSource::class);
    }

    public function activeFeedSources()
    {
        return $this->hasMany(UserFeedSource::class)->where('is_active', true);
    }


    public function hasSource($sourceType)
    {
        return $this->feedSources()->where('source_type', $sourceType)->exists();
    }


    public function getDealerIdForSource($sourceType)
    {
        return $this->feedSources()
            ->where('source_type', $sourceType)
            ->where('is_active', true)
            ->pluck('dealer_id')
            ->toArray();
    }
}
