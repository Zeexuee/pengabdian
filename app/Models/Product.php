<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'category',
        'shopee_url',
        'tokopedia_url',
        'whatsapp_url',
        'video_url',
        'is_active',
        'order',
    ];

    /**
     * Helper accessor untuk URL WhatsApp yang terformat rapi.
     */
    public function getFormattedWhatsappUrlAttribute(): ?string
    {
        if (empty($this->whatsapp_url)) {
            return null;
        }

        $url = trim($this->whatsapp_url);

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        if (str_starts_with($url, 'wa.me/')) {
            return 'https://' . $url;
        }

        // Jika diinput berupa nomor telepon (misal: 081234567890 atau +6281234567890)
        $number = preg_replace('/[^0-9]/', '', $url);
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }

        if (!empty($number)) {
            $text = urlencode("Halo, saya tertarik dengan produk " . $this->name);
            return "https://wa.me/{$number}?text={$text}";
        }

        return $url;
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Auto-generate slug dari name saat membuat / memperbarui.
     */
    protected static function booted(): void
    {
        static::creating(function (Product $model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->name);
            }
        });

        static::updating(function (Product $model) {
            if ($model->isDirty('name') && empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->name, $model->id);
            }
        });
    }

    public static function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $base = Str::slug($name);
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

    /**
     * Relasi ke gambar-gambar produk.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    /**
     * Scope: hanya produk yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
