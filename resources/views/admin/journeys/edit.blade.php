<x-admin-layout>
    <div class="admin-page-title admin-page-title-stacked">
        <h1>{{ __('Edit journey') }} — {{ $journey->title }}</h1>
        <div class="admin-inline-actions">
            <a href="{{ admin_route('admin.journeys.index') }}" class="admin-back-link">{{ __('← Back to journeys') }}</a>
            @if ($journey->is_published)
                <span class="admin-muted">·</span>
                <a href="{{ (site_locale() === 'ar' ? route('journeys.show.locale', [$journey, 'ar']) : route('journeys.show', $journey)) }}" target="_blank" rel="noopener" class="admin-link">{{ __('View on site ↗') }}</a>
            @else
                <span class="admin-status">{{ __('Draft · publish to view on site') }}</span>
            @endif
        </div>
    </div>

    <div class="admin-editor-grid">
        <form method="POST" action="{{ admin_route('admin.journeys.update', $journey) }}" enctype="multipart/form-data" class="admin-card h-fit">
            @csrf @method('PATCH')
            @include('admin.journeys._form')
        </form>

        <div class="space-y-6">
            <section class="admin-card">
                <div class="admin-section-heading">
                    <h2 class="admin-section-title">{{ __('Stops') }} ({{ $journey->stops->count() }})</h2>
                    <a href="{{ admin_route('admin.journeys.stops.create', $journey) }}" class="btn btn-primary btn-sm">{{ __('Add stop') }}</a>
                </div>

                <ol class="mt-5 space-y-3">
                    @forelse ($journey->stops as $stop)
                        <li class="admin-list-row admin-stop-row">
                            <span class="flex items-center gap-4">
                                <span class="font-mono text-lg font-semibold admin-muted">{{ $stop->number }}</span>
                                <span>
                                    <span class="admin-label">{{ $stop->name }}</span>
                                    <span class="block text-xs admin-muted">{{ $stop->label ?: '—' }} · {{ $stop->place?->name ?: __('No place linked') }}</span>
                                </span>
                            </span>
                            <span class="flex items-center gap-3 text-sm">
                                <a href="{{ admin_route('admin.journeys.stops.edit', [$journey, $stop]) }}" class="btn btn-outline btn-sm">{{ __('Edit') }}</a>
                                <form method="POST" action="{{ admin_route('admin.journeys.stops.destroy', [$journey, $stop]) }}" onsubmit="return confirm(this.dataset.confirm)" data-confirm="{{ __('Delete this stop?') }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                                </form>
                            </span>
                        </li>
                    @empty
                        <li class="rounded-lg border border-dashed admin-border p-6 text-center text-sm admin-muted">
                            {{ __('No stops yet — add the first one below or with the button above.') }}
                        </li>
                    @endforelse
                </ol>
            </section>

            <section class="admin-card admin-card-tinted">
                <h2 class="admin-section-title">{{ __('Quick add a stop') }}</h2>
                <form method="POST" action="{{ admin_route('admin.journeys.stops.store', $journey) }}" class="mt-4 space-y-4">
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-[6rem_1fr_1fr]">
                        <x-admin.input id="quick_order" name="order" label="Order" type="number" min="0" :value="old('order', ($journey->stops->max('order') ?? 0) + 1)" required />
                        <x-admin.input id="quick_name_en" name="name_en" label="Name (EN)" required />
                        <x-admin.input id="quick_name_ar" name="name_ar" label="Name (AR)" />
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-admin.input id="quick_label_en" name="label_en" label="Label (EN)" help="e.g. Arrive, Depart, Ancient city" />
                        <div>
                            <label for="quick_place_id" class="admin-label">{{ __('Linked place') }}</label>
                            <select id="quick_place_id" name="place_id" class="admin-input">
                                <option value="">{{ __('— None —') }}</option>
                                @foreach ($places as $place)
                                    <option value="{{ $place->id }}" @selected(old('place_id') == $place->id)>{{ $place->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Add stop') }}</button>
                </form>
            </section>
        </div>
    </div>
</x-admin-layout>