<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApproachPoint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApproachPointController extends Controller
{
    public function index(): View
    {
        return view('admin.approach_points.index', [
            'points' => ApproachPoint::orderBy('order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.approach_points.create', [
            'point' => new ApproachPoint,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        ApproachPoint::create($this->validated($request));

        return redirect(admin_route('admin.approach-points.index'))->with('status', 'Approach point created.');
    }

    public function edit(ApproachPoint $approachPoint): View
    {
        return view('admin.approach_points.edit', [
            'point' => $approachPoint,
        ]);
    }

    public function update(Request $request, ApproachPoint $approachPoint): RedirectResponse
    {
        $approachPoint->update($this->validated($request));

        return redirect(admin_route('admin.approach-points.index'))->with('status', 'Approach point updated.');
    }

    public function destroy(ApproachPoint $approachPoint): RedirectResponse
    {
        $approachPoint->delete();

        return redirect(admin_route('admin.approach-points.index'))->with('status', 'Approach point deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'order' => ['required', 'integer', 'min:0'],
            'title_en' => ['required', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
        ]);
    }
}
