<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Models\Page;

class JourneyController extends Controller
{
    /**
     * Display the full details of a journey to customers.
     */
    public function show(Journey $journey, ?string $locale = null)
    {
        app()->setLocale($locale === 'ar' ? 'ar' : 'en');

        abort_unless($journey->is_published, 404);

        $journey->load(['stops.place' => fn ($query) => $query->published()]);

        $otherJourneys = Journey::published()
            ->where('id', '!=', $journey->id)
            ->take(3)
            ->get();

        return view('journeys.show', [
            'journey' => $journey,
            'pages' => Page::all()->keyBy('key'),
            'otherJourneys' => $otherJourneys,
            'alternateUrl' => app()->getLocale() === 'ar'
                ? route('journeys.show', $journey)
                : route('journeys.show.locale', [$journey, 'ar']),
        ]);
    }
}
