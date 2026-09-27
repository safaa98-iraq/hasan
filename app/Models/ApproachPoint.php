<?php

namespace App\Models;

use App\Traits\HasLocalizedFields;
use Illuminate\Database\Eloquent\Model;

class ApproachPoint extends Model
{
    use HasLocalizedFields;

    protected $fillable = [
        'order', 'title_en', 'title_ar', 'description_en', 'description_ar',
    ];
}