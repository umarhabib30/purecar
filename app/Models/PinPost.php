<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PinPost extends Model
{
    protected $table = 'pin_posts';
    protected $fillable = [
        'auth_id', 
        'forum_post_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'auth_id');
    }

    public function forumPost()
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }
}
