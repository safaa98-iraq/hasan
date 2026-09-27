<?php

namespace App\Models;

use App\Traits\HasLocalizedFields;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasLocalizedFields;

    protected $fillable = [
        'key', 'title_en', 'title_ar', 'body_en', 'body_ar', 'image_path',
    ];

    public function scopeKey($query, string $key)
    {
        return $query->where('key', $key);
    }
}