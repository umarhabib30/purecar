<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumTopicCategory extends Model
{
    protected $table = 'forum_topic_categories';

    protected $fillable=[
       'forum_topic_id',
       'category',
       'image',
    ];

    public function forumTopic()
    {
        return $this->belongsTo(ForumTopic::class);
    }
    public function forumPosts()
{
    return $this->hasMany(ForumPost::class, 'forum_topic_category_id');
}


}
