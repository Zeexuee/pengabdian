<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WorkProgram extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'image', 'start_date', 'end_date', 'status'];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date'   => 'date',
        ];
    }

    /**
     * Auto-generate slug dari title saat membuat / memperbarui.
     */
    protected static function booted(): void
    {
        static::creating(function (WorkProgram $model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->title);
            }
        });

        static::updating(function (WorkProgram $model) {
            if ($model->isDirty('title') && empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->title, $model->id);
            }
        });
    }

    public static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;

        while (
            static::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function blocks()
    {
        return $this->hasMany(WorkProgramBlock::class)->orderBy('order');
    }
}
