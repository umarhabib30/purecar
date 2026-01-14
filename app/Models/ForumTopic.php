<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    protected $table = 'forum_topics';
    protected $fillable=[
       'title',
       'image'
    ];


    public function forumTopicCategories()
    {
        return $this->hasMany(ForumTopicCategory::class);
    }

    public function countPostsInForumCategory($categoryId)
    {
        return ForumPost::where('forum_topic_category_id', $categoryId)->count();
    }
    




}
