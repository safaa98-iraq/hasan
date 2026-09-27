<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApproachPoint;
use App\Models\Category;
use App\Models\Journey;
use App\Models\Page;
use App\Models\Place;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'placeCount' => Place::count(),
            'journeyCount' => Journey::count(),
            'categoryCount' => Category::count(),
            'approachCount' => ApproachPoint::count(),
            'pageCount' => Page::where('key', '!=', 'contact_email')->count(),
            'latestPlaces' => Place::orderBy('order')->limit(5)->get(),
            'latestJourneys' => Journey::orderBy('id', 'desc')->limit(5)->get(),
        ]);
    }
}
