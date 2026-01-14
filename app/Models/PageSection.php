<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{

//    protected $fillable=[
//       'title',
//       'content',
//        'featured_image',
//        'author_id',
//        'category_id',
//        'tags',
//    ];

protected $fillable = [
    'page_id',
    'section',
    'name',
    'type',
    'value'
];

}
