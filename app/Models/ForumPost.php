<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class ForumPost extends Model
{
    protected $table = 'forum_posts';
    protected $fillable=[
       'forum_topic_category_id',
       'content',
       'topic',
       'user_id',
        'slug',
    ];


    public function forumPostMedia()
    {
        return $this->hasMany(ForumPostMedia::class);
    }


    public function userDetails()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function forumTopicCategory()
    {
        return $this->belongsTo(ForumTopicCategory::class, 'forum_topic_category_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(ForumPostLike::class, 'post_id');
    }
    public function dislikes()
    {
        return $this->hasMany(ForumPostDeslike::class, 'post_id');
    }
    
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
    public function getdisLikesCountAttribute()
    {
        return $this->dislikes()->count();
    }
        
    public function forumTopicReplies()
    {
        return $this->hasMany(ForumTopicReply::class);
    }
    // In ForumPost.php model
    public function replies()
    {
        return $this->hasMany(ForumTopicReply::class, 'forum_post_id');
    }
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($forumPost) {
            $forumPost->slug = static::generateSlug($forumPost);
        });
        
        static::updating(function ($forumPost) {
            if ($forumPost->isDirty('topic')) {
                $forumPost->slug = static::generateSlug($forumPost);
            }
        });
    }
    
    protected static function generateSlug($forumPost)
    {
       
        $baseSlug = Str::slug(Str::limit($forumPost->topic, 150, ''));
        
        $count = static::where('slug', 'LIKE', $baseSlug . '%')
                    ->where('id', '!=', $forumPost->id)
                    ->count();
        
        
        return $count ? "{$baseSlug}-" . ($count + 1) : $baseSlug;
    }
    

    public function getRouteKeyName()
    {
        return 'slug';
    }


}
