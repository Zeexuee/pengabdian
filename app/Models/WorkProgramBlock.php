<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkProgramBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_program_id', 'type', 'title', 'content', 'image', 'video_url', 'order',
    ];

    public function workProgram()
    {
        return $this->belongsTo(WorkProgram::class);
    }
}
