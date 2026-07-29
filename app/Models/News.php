<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['title', 'slug', 'content', 'thumbnail', 'status', 'author_id', 'published_at', 'order'])]
class News extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function blocks()
    {
        return $this->hasMany(NewsBlock::class)->orderBy('order');
    }
}
