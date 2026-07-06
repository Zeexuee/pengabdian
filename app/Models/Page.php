<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'slug', 'content_blocks'];

    protected $casts = [
        'content_blocks' => 'array',
    ];
}
