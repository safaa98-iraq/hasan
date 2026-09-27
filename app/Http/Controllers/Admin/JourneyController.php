<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\UploadsImages;
use App\Http\Controllers\Controller;
use App\Models\Journey;
use App\Models\Place;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JourneyController extends Controller
{
    use UploadsImages;

    public function index()
    {
        return view('admin.journeys.index', [
            'journeys' => Journey::withCount('stops')->orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.journeys.create', [
            'journey' => new Journey,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image_path'] = $this->storeImage($request, 'journeys');

        Journey::create($data);

        return redirect(admin_route('admin.journeys.index'))->with('status', 'Journey created.');
    }

    public function edit(Journey $journey)
    {
        return view('admin.journeys.edit', [
            'journey' => $journey->load('stops.place'),
            'places' => Place::orderBy('order')->get(),
        ]);
    }

    public function update(Request $request, Journey $journey): RedirectResponse
    {
        $data = $this->validated($request, $journey);
        $data['image_path'] = $this->storeImage($request, 'journeys', $journey->image_path);

        $journey->update($data);

        return redirect(admin_route('admin.journeys.edit', $journey))->with('status', 'Journey updated.');
    }

    public function destroy(Journey $journey): RedirectResponse
    {
        $journey->delete();

        return redirect(admin_route('admin.journeys.index'))->with('status', 'Journey deleted.');
    }

    private function validated(Request $request, ?Journey $journey = null): array
    {
        $slug = $request->input('slug');
        $title = $request->input('title_en');

        if (($slug === null || is_string($slug)) && is_string($title)) {
            $request->merge(['slug' => Str::slug($slug ?: $title) ?: 'journey']);
        }

        $uniqueSlug = 'unique:journeys,slug'.($journey ? ','.$journey->id : '');

        return $request->validate([
            'slug' => ['required', 'string', 'max:255', $uniqueSlug],
            'order' => ['required', 'integer', 'min:0'],
            'title_en' => ['required', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'subtitle_en' => ['nullable', 'string', 'max:255'],
            'subtitle_ar' => ['nullable', 'string', 'max:255'],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'price_en' => ['nullable', 'string', 'max:255'],
            'price_ar' => ['nullable', 'string', 'max:255'],
            'duration_en' => ['nullable', 'string', 'max:255'],
            'duration_ar' => ['nullable', 'string', 'max:255'],
            'included_en' => ['nullable', 'string'],
            'included_ar' => ['nullable', 'string'],
            'excluded_en' => ['nullable', 'string'],
            'excluded_ar' => ['nullable', 'string'],
            'image_path' => ['nullable', 'image', 'max:3072'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }
}
