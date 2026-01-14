<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPostLike extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forum_post_likes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'auth_id',
        'post_id',
        'post_user_id',
    ];

    /**
     * Relationships
     */

    
    public function forumPost()
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }

    
    public function user()
    {
        return $this->belongsTo(User::class, 'auth_id');
    }
}
