<x-admin-layout>
    <div class="admin-page-title">
        <div>
            <h1>{{ __('Places') }}</h1>
            <p class="admin-page-description">{{ __('Manage destination cards, stories and their links to journey stops.') }}</p>
        </div>
        <a href="{{ admin_route('admin.places.create') }}" class="btn btn-primary">{{ __('+ New place') }}</a>
    </div>

    <div class="admin-card admin-table-wrap" tabindex="0" role="region" aria-label="{{ __('Content list') }}">
        <table>
            <thead>
                <tr>
                    <th style="padding: 12px 16px;">#</th>
                    <th style="padding: 12px 16px;">{{ __('Name') }}</th>
                    <th style="padding: 12px 16px;">{{ __('Slug') }}</th>
                    <th style="padding: 12px 16px;">{{ __('Status') }}</th>
                    <th style="padding: 12px 16px; text-align: right;">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($places as $place)
                    <tr>
                        <td style="padding: 12px 16px; font-size: 0.82rem; color: var(--admin-ink-soft); font-variant-numeric: tabular-nums;">{{ $place->order }}</td>
                        <td style="padding: 12px 16px;">
                            <span style="font-weight: 600; color: var(--admin-ink);">{{ $place->name }}</span>
                            @if ($place->name_ar)
                                <span style="margin-inline-start: 8px; color: var(--admin-ink-soft); font-size: 0.85rem;">· {{ $place->name_ar }}</span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px; font-size: 0.82rem; color: var(--admin-ink-soft); font-family: monospace;">{{ $place->slug }}</td>
                        <td style="padding: 12px 16px;">
                            @if ($place->is_published)
                                <span class="admin-status admin-status-published">{{ __('Published') }}</span>
                            @else
                                <span class="admin-status">{{ __('Draft') }}</span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px; text-align: right; white-space: nowrap;">
                            @if ($place->is_published)
                                <a href="{{ (site_locale() === 'ar' ? route('places.show.locale', [$place, 'ar']) : route('places.show', $place)) }}" target="_blank" rel="noopener" class="btn btn-outline btn-sm">{{ __('View ↗') }}</a>
                            @endif
                            <a href="{{ admin_route('admin.places.edit', $place) }}" class="btn btn-primary btn-sm" style="margin-inline-start: 8px;">{{ __('Edit') }}</a>
                            <form method="POST" action="{{ admin_route('admin.places.destroy', $place) }}" style="display: inline; margin-inline-start: 8px;" onsubmit="return confirm(this.dataset.confirm)" data-confirm="{{ __('Delete this place?') }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 32px; text-align: center; color: var(--admin-ink-soft); font-size: 0.9rem;">{{ __('No places yet.') }} <a href="{{ admin_route('admin.places.create') }}" style="color: var(--admin-lapis);">{{ __('Create one →') }}</a></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>