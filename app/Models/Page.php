<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
     protected $fillable = [
        'id',
        'title',
        'slug',
        'meta_keys',
        'meta_description',
        'description',
        'image',
        
    ];
}
