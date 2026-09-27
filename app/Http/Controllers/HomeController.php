<?php

namespace App\Http\Controllers;

use App\Models\ApproachPoint;
use App\Models\Category;
use App\Models\Journey;
use App\Models\Page;
use App\Models\Place;

class HomeController extends Controller
{
    public function index(?string $locale = null)
    {
        app()->setLocale($locale === 'ar' ? 'ar' : 'en');

        $pages = Page::all()->keyBy('key');

        $journeys = Journey::query()
            ->published()
            ->with(['stops.place' => fn ($query) => $query->published()])
            ->get();

        $journey = $journeys->first();

        $places = Place::published()->get();
        $categories = Category::orderBy('order')->get();
        $approachPoints = ApproachPoint::orderBy('order')->get();

        return view('home', compact('pages', 'journey', 'journeys', 'places', 'categories', 'approachPoints'));
    }
}
