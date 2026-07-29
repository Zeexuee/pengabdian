<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'education_id', 'type', 'title', 'content', 'image', 'video_url', 'video_file', 'order',
    ];

    public function education()
    {
        return $this->belongsTo(Education::class);
    }
}
