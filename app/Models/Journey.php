<?php

namespace App\Models;

use App\Traits\HasLocalizedFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Journey extends Model
{
    use HasLocalizedFields;

    protected $fillable = [
        'slug', 'title_en', 'title_ar', 'subtitle_en', 'subtitle_ar',
        'description_en', 'description_ar', 'price_en', 'price_ar',
        'duration_en', 'duration_ar', 'image_path', 'gallery',
        'included_en', 'included_ar', 'excluded_en', 'excluded_ar',
        'is_published', 'order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'gallery' => 'array',
    ];

    public function stops(): HasMany
    {
        return $this->hasMany(JourneyStop::class)->orderBy('order');
    }

    public function publishedStops(): HasMany
    {
        return $this->hasMany(JourneyStop::class)->orderBy('order');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Return list of included items as an array of strings.
     */
    public function getIncludedListAttribute(): array
    {
        $raw = (string) $this->included;
        return array_values(array_filter(array_map('trim', preg_split('/\r?\n/', $raw) ?: [])));
    }

    /**
     * Return list of excluded items as an array of strings.
     */
    public function getExcludedListAttribute(): array
    {
        $raw = (string) $this->excluded;
        return array_values(array_filter(array_map('trim', preg_split('/\r?\n/', $raw) ?: [])));
    }
}