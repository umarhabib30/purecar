<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumPostMedia extends Model
{
    protected $table = 'forum_post_media';

    protected $fillable=[
       'forum_post_id',
       'media',
    ];

    public function forumPost()
    {
        return $this->belongsTo(ForumPost::class);
    }

}
