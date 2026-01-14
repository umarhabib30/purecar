<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumBlockedUser extends Model
{
    use HasFactory;

    
    protected $table = 'forum_blocked_user';

    
    protected $fillable = [
        'auth_id',
        'user_id',
        'reason',
    ];

    
    protected $casts = [
        'auth_id' => 'integer',
        'user_id' => 'integer',
        'reason' => 'string',
    ];
    // ForumBlockedUser model
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}

