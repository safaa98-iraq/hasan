<x-admin-layout>
    <div class="admin-page-title">
        <div><h1>{{ __('Dashboard') }}</h1><p class="admin-page-description">{{ __('Manage the stories, places and journeys that bring Iraq to life.') }}</p></div>
        <a href="{{ site_home_url() }}" target="_blank" rel="noopener" class="btn btn-outline btn-sm">{{ __('↗ View public site') }}</a>
    </div>

    {{-- Stats --}}
    <div class="admin-stats">
        @foreach ([
            ['label' => 'Journeys', 'count' => $journeyCount, 'route' => 'admin.journeys.index'],
            ['label' => 'Places', 'count' => $placeCount, 'route' => 'admin.places.index'],
            ['label' => 'Categories', 'count' => $categoryCount, 'route' => 'admin.categories.index'],
            ['label' => 'Approach points', 'count' => $approachCount, 'route' => 'admin.approach-points.index'],
            ['label' => 'Site copy rows', 'count' => $pageCount, 'route' => 'admin.pages.index'],
        ] as $stat)
            <a href="{{ admin_route($stat['route']) }}" class="admin-stat">
                <p class="admin-stat-count">{{ $stat['count'] }}</p>
                <p class="admin-stat-label">{{ __($stat['label']) }}</p>
            </a>
        @endforeach
    </div>

    {{-- Tables --}}
    <div class="admin-dashboard-grid">
        {{-- Places --}}
        <section class="admin-card">
            <div class="admin-section-heading">
                <h2 class="admin-section-title">{{ __('Places') }}</h2>
                <a href="{{ admin_route('admin.places.index') }}" class="btn btn-outline btn-sm">{{ __('View all') }}</a>
            </div>
            <ul class="admin-list">
                @forelse ($latestPlaces as $place)
                    <li class="admin-list-row">
                        <span style="color: var(--admin-ink);">{{ $place->order }} · {{ $place->name }}</span>
                        <span class="admin-inline-actions">
                            @if ($place->is_published)
                                <span class="admin-status admin-status-published">{{ __('Published') }}</span>
                            @else
                                <span class="admin-status">{{ __('Draft') }}</span>
                            @endif
                            <a href="{{ admin_route('admin.places.edit', $place) }}" class="btn btn-outline btn-sm">{{ __('Edit') }}</a>
                        </span>
                    </li>
                @empty
                    <li class="admin-empty">{{ __('No places yet.') }}</li>
                @endforelse
            </ul>
        </section>

        {{-- Journeys --}}
        <section class="admin-card">
            <div class="admin-section-heading">
                <h2 class="admin-section-title">{{ __('Journeys') }}</h2>
                <a href="{{ admin_route('admin.journeys.index') }}" class="btn btn-outline btn-sm">{{ __('View all') }}</a>
            </div>
            <ul class="admin-list">
                @forelse ($latestJourneys as $journey)
                    <li class="admin-list-row">
                        <span style="color: var(--admin-ink);">{{ $journey->title }}</span>
                        <span class="admin-inline-actions">
                            @if ($journey->is_published)
                                <span class="admin-status admin-status-published">{{ __('Published') }}</span>
                            @else
                                <span class="admin-status">{{ __('Draft') }}</span>
                            @endif
                            <a href="{{ admin_route('admin.journeys.edit', $journey) }}" class="btn btn-outline btn-sm">{{ __('Edit') }}</a>
                        </span>
                    </li>
                @empty
                    <li class="admin-empty">{{ __('No journeys yet.') }}</li>
                @endforelse
            </ul>
        </section>
    </div>

    {{-- Quick Actions --}}
    <div class="admin-card admin-quick-actions">
        <span class="admin-muted text-sm">{{ __('Quick add:') }}</span>
        <a href="{{ admin_route('admin.journeys.create') }}" class="btn btn-primary btn-sm">{{ __('+ Journey') }}</a>
        <a href="{{ admin_route('admin.places.create') }}" class="btn btn-outline btn-sm">{{ __('+ Place') }}</a>
        <a href="{{ admin_route('admin.categories.create') }}" class="btn btn-outline btn-sm">{{ __('+ Category') }}</a>
        <a href="{{ admin_route('admin.approach-points.create') }}" class="btn btn-outline btn-sm">{{ __('+ Approach point') }}</a>
    </div>
</x-admin-layout>