<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Blog extends Model
{

    protected $fillable=[
       'title',
       'content',
        'featured_image',
        'author_id',
        'category_id',
        'tags',
        'slug',
    ];


    public function nameAuthor()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }

    public function blogComments()
    {
        return $this->hasMany(BlogComment::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($blog) {
            $blog->slug = static::generateSlug($blog);
        });
        
        static::updating(function ($blog) {
            if ($blog->isDirty('title')) {
                $blog->slug = static::generateSlug($blog);
            }
        });
    }
    
    protected static function generateSlug($blog)
    {
        $baseSlug = Str::slug(Str::limit($blog->title, 150, ''));
        $count = static::where('slug', 'LIKE', $baseSlug . '%')
                       ->where('id', '!=', $blog->id)
                       ->count();
        return $count ? "{$baseSlug}-" . ($count + 1) : $baseSlug;
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

}
