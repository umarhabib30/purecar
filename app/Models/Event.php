<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'featured_image',
        'gallery_images',
        'slug'
    ];

    protected $casts = [
        'gallery_images' => 'array',
    ];
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($event) {
            $event->slug = static::generateSlug($event);
        });
        
        static::updating(function ($event) {
            if ($event->isDirty('title') || $event->isDirty('event_date')) {
                $event->slug = static::generateSlug($event);
            }
        });
    }
    
    protected static function generateSlug($event)
    {
       
        $date = $event->event_date ? date('d-m-Y', strtotime($event->event_date)) : date('d-m-Y');
        
       
        $baseSlug = Str::slug($event->title . '-' . $date);
        
      
        $count = static::where('slug', 'LIKE', $baseSlug . '%')
                       ->where('id', '!=', $event->id)
                       ->count();
        

        return $count ? "{$baseSlug}-" . ($count + 1) : $baseSlug;
    }
    
   
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
