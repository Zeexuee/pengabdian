<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id', 'type', 'title', 'content', 'image', 'video_url', 'video_file', 'order',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
