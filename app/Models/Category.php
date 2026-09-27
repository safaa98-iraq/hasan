<?php

namespace App\Models;

use App\Traits\HasLocalizedFields;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasLocalizedFields;

    protected $fillable = [
        'slug', 'order', 'roman_numeral',
        'title_en', 'title_ar', 'description_en', 'description_ar',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getNumeralAttribute(): string
    {
        if ($this->roman_numeral) {
            return $this->roman_numeral;
        }

        $romans = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X'];

        return $romans[$this->order] ?? (string) $this->order;
    }
}