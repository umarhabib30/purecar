<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'note_id';
    
    protected $fillable = [
        'content',
        'type',
        'created_by',
    ];

    public function adverts()
    {
        return $this->belongsToMany(Advert::class, 'advert_note', 'note_id', 'advert_id')
                    ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}