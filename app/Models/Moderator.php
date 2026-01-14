<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moderator extends Model
{
    use HasFactory;

    
    protected $table = 'moderators';

    
    protected $fillable = [
        'user_id',
        'forum_topic_id',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forumTopicCategory()
    {
        return $this->belongsTo(ForumTopicCategory::class, 'id'); 
    }
}
