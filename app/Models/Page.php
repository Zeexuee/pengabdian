<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'slug', 'meta_title', 'meta_description', 'meta_image', 'content_blocks'];

    protected $casts = [
        'content_blocks' => 'array',
    ];
}
