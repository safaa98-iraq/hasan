<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\UploadsImages;
use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PlaceController extends Controller
{
    use UploadsImages;

    public function index(): View
    {
        return view('admin.places.index', [
            'places' => Place::orderBy('order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.places.create', [
            'place' => new Place,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image_path'] = $this->storeImage($request, 'places');

        Place::create($data);

        return redirect(admin_route('admin.places.index'))->with('status', 'Place created.');
    }

    public function edit(Place $place): View
    {
        return view('admin.places.edit', [
            'place' => $place,
            'imageUrl' => $this->imageUrl($place->image_path),
        ]);
    }

    public function update(Request $request, Place $place): RedirectResponse
    {
        $data = $this->validated($request, $place);
        $data['image_path'] = $this->storeImage($request, 'places', $place->image_path);

        $place->update($data);

        return redirect(admin_route('admin.places.index'))->with('status', 'Place updated.');
    }

    public function destroy(Place $place): RedirectResponse
    {
        $place->delete();

        return redirect(admin_route('admin.places.index'))->with('status', 'Place deleted.');
    }

    private function validated(Request $request, ?Place $place = null): array
    {
        $slug = $request->input('slug');
        $title = $request->input('name_en');

        if (($slug === null || is_string($slug)) && is_string($title)) {
            $request->merge(['slug' => Str::slug($slug ?: $title) ?: 'place']);
        }

        $uniqueSlug = 'unique:places,slug'.($place ? ','.$place->id : '');

        return $request->validate([
            'slug' => ['required', 'string', 'max:255', $uniqueSlug],
            'order' => ['required', 'integer', 'min:0'],
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'excerpt_en' => ['nullable', 'string'],
            'excerpt_ar' => ['nullable', 'string'],
            'body_en' => ['nullable', 'string'],
            'body_ar' => ['nullable', 'string'],
            'image_path' => ['nullable', 'image', 'max:2048'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }
}
