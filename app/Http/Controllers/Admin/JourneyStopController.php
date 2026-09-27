<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\UploadsImages;
use App\Http\Controllers\Controller;
use App\Models\Journey;
use App\Models\JourneyStop;
use App\Models\Place;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JourneyStopController extends Controller
{
    use UploadsImages;

    public function index(Journey $journey): RedirectResponse
    {
        return redirect(admin_route('admin.journeys.edit', $journey));
    }

    public function create(Journey $journey)
    {
        return view('admin.stops.create', [
            'journey' => $journey,
            'stop' => new JourneyStop(['journey_id' => $journey->id]),
            'places' => Place::orderBy('order')->get(),
        ]);
    }

    public function store(Request $request, Journey $journey): RedirectResponse
    {
        $data = $this->validated($request);
        $data['journey_id'] = $journey->id;
        $data['image_path'] = $this->storeImage($request, 'stops');

        JourneyStop::create($data);

        return redirect(admin_route('admin.journeys.edit', $journey))->with('status', 'Stop added.');
    }

    public function edit(Journey $journey, JourneyStop $stop)
    {
        return view('admin.stops.edit', [
            'journey' => $journey,
            'stop' => $stop,
            'places' => Place::orderBy('order')->get(),
        ]);
    }

    public function update(Request $request, Journey $journey, JourneyStop $stop): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image_path'] = $this->storeImage($request, 'stops', $stop->image_path);

        $stop->update($data);

        return redirect(admin_route('admin.journeys.edit', $journey))->with('status', 'Stop updated.');
    }

    public function destroy(Journey $journey, JourneyStop $stop): RedirectResponse
    {
        $stop->delete();

        return redirect(admin_route('admin.journeys.edit', $journey))->with('status', 'Stop deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'order' => ['required', 'integer', 'min:0'],
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'label_en' => ['nullable', 'string', 'max:255'],
            'label_ar' => ['nullable', 'string', 'max:255'],
            'place_id' => ['nullable', 'exists:places,id'],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'image_path' => ['nullable', 'image', 'max:3072'],
        ]);
    }
}
