<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug', 'content', 'thumbnail', 'video_url', 'is_published'])]
class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }
}
