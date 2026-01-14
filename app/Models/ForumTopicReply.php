<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumTopicReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_post_id',
        'user_id',
        'auth_id',
        'content',
        'media'
    ];

    /**
     * Get the forum post that owns the reply.
     */
    
    public function forumPost()
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }

    /**
     * Get the user who made the reply.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function author()
{
    return $this->belongsTo(User::class, 'auth_id');
}

}
