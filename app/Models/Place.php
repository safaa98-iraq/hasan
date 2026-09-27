<?php

namespace App\Models;

use App\Traits\HasLocalizedFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Place extends Model
{
    use HasFactory;
    use HasLocalizedFields;

    protected $fillable = [
        'slug', 'order', 'name_en', 'name_ar', 'excerpt_en', 'excerpt_ar',
        'body_en', 'body_ar', 'image_path', 'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function stops(): HasMany
    {
        return $this->hasMany(JourneyStop::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}