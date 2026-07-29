<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'banner_image', 'description', 'order'])]
class Division extends Model
{
    use HasFactory;

    public function members()
    {
        return $this->hasMany(Member::class)->orderBy('order', 'asc');
    }
}
