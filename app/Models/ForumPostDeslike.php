<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ForumPostDeslike extends Model
{
    use HasFactory;

    protected $table = 'forum_post_deslikes';
    protected $fillable = [
        'auth_id',
        'post_id',
        'post_user_id',
    ];
    public function forumPost()
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }

    
    public function user()
    {
        return $this->belongsTo(User::class, 'auth_id');
    }
}


