<x-admin-layout>
    <div class="admin-page-title">
        <div>
            <h1>{{ __('Journeys') }}</h1>
            <p class="admin-page-description">{{ __('Multi-stop routes with pricing, duration, photos and full itinerary.') }}</p>
        </div>
        <a href="{{ admin_route('admin.journeys.create') }}" class="btn btn-primary">{{ __('+ New journey') }}</a>
    </div>

    <div class="admin-card admin-table-wrap" tabindex="0" role="region" aria-label="{{ __('Content list') }}">
        <table>
            <thead>
                <tr>
                    <th style="padding: 12px 16px;">#</th>
                    <th style="padding: 12px 16px;">{{ __('Cover') }}</th>
                    <th style="padding: 12px 16px;">{{ __('Title') }}</th>
                    <th style="padding: 12px 16px;">{{ __('Price / Duration') }}</th>
                    <th style="padding: 12px 16px;">{{ __('Stops') }}</th>
                    <th style="padding: 12px 16px;">{{ __('Status') }}</th>
                    <th style="padding: 12px 16px; text-align: right;">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($journeys as $journey)
                    <tr>
                        <td style="padding: 12px 16px; font-size: 0.82rem; color: var(--admin-ink-soft); font-variant-numeric: tabular-nums;">{{ $journey->order }}</td>
                        <td style="padding: 12px 16px;">
                            @if ($journey->image_path)
                                <img src="{{ site_image_url($journey->image_path) }}" alt="{{ $journey->title }}" class="img-thumb">
                            @else
                                <div style="width: 60px; height: 45px; border-radius: 8px; background: rgba(6,62,97,0.07); border: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: center; font-size: 0.62rem; color: var(--admin-ink-soft);">{{ __('No img') }}</div>
                            @endif
                        </td>
                        <td style="padding: 12px 16px;">
                            <span style="display: block; font-weight: 600; color: var(--admin-ink);">{{ $journey->title }}</span>
                            @if ($journey->title_ar)
                                <span style="display: block; font-size: 0.8rem; color: var(--admin-ink-soft);">{{ $journey->title_ar }}</span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px;">
                            @if ($journey->price)
                                <span style="display: block; font-weight: 700; color: var(--admin-lapis);">{{ $journey->price }}</span>
                            @endif
                            @if ($journey->duration)
                                <span style="display: block; font-size: 0.8rem; opacity: 0.65;">{{ $journey->duration }}</span>
                            @endif
                            @if (!$journey->price && !$journey->duration)
                                <span style="opacity: 0.35;">—</span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px; font-size: 0.88rem; opacity: 0.75;">{{ $journey->stops_count }}</td>
                        <td style="padding: 12px 16px;">
                            @if ($journey->is_published)
                                <span class="admin-status admin-status-published">{{ __('Published') }}</span>
                            @else
                                <span class="admin-status">{{ __('Draft') }}</span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px; text-align: right; white-space: nowrap;">
                            @if ($journey->is_published)
                                <a href="{{ (site_locale() === 'ar' ? route('journeys.show.locale', [$journey, 'ar']) : route('journeys.show', $journey)) }}" target="_blank" rel="noopener" class="btn btn-outline btn-sm">{{ __('View ↗') }}</a>
                            @endif
                            <a href="{{ admin_route('admin.journeys.edit', $journey) }}" class="btn btn-primary btn-sm">{{ __('Edit') }}</a>
                            <form method="POST" action="{{ admin_route('admin.journeys.destroy', $journey) }}" style="display: inline;" onsubmit="return confirm(this.dataset.confirm)" data-confirm="{{ __('Delete this journey and all its stops?') }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 32px; text-align: center; color: var(--admin-ink-soft); font-size: 0.9rem;">{{ __('No journeys yet.') }} <a href="{{ admin_route('admin.journeys.create') }}" style="color: var(--admin-lapis);">{{ __('Create one →') }}</a></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>