<?php

namespace App\Models;

use App\Traits\HasLocalizedFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JourneyStop extends Model
{
    use HasLocalizedFields;

    protected $fillable = [
        'journey_id', 'order', 'name_en', 'name_ar', 'label_en', 'label_ar', 'place_id',
        'description_en', 'description_ar', 'image_path',
    ];

    public function journey(): BelongsTo
    {
        return $this->belongsTo(Journey::class);
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }
}