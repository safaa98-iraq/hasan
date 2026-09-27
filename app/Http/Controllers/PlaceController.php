<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Place;

class PlaceController extends Controller
{
    public function show(Place $place, ?string $locale = null)
    {
        app()->setLocale($locale === 'ar' ? 'ar' : 'en');

        abort_unless($place->is_published, 404);

        return view('places.show', [
            'place' => $place->load(['stops' => fn ($query) => $query
                ->whereHas('journey', fn ($journeys) => $journeys->published())
                ->with('journey')
                ->orderBy('order')]),
            'pages' => Page::all()->keyBy('key'),
            'alternateUrl' => app()->getLocale() === 'ar'
                ? route('places.show', $place)
                : route('places.show.locale', [$place, 'ar']),
        ]);
    }
}
