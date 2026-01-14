<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReportedUser extends Model
{
    protected $table = 'forum_reported_user';

    
    protected $fillable = [
        'auth_id',
        'user_id',
        'reason',
        'forum_topic_id',
    ];
    public function user()
{
    return $this->belongsTo(User::class, 'auth_id');
}
public function Reporteduser()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
