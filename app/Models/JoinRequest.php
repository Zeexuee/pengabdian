<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'email', 'phone_number', 'reason', 'status', 'admin_notes'])]
class JoinRequest extends Model
{
    use HasFactory;
}
