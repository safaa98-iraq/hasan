<section class="places section page-shell" id="places" aria-labelledby="places-title">
    <div class="places-intro">
        <div class="section-label"><span>{{ $pages->get('places_eyebrow')?->title }}</span></div>
        <h2 id="places-title">{{ $pages->get('places_heading')?->title ?? (site_locale() === 'ar' ? 'اكتشف وجهات العراق.' : 'Discover the places of Iraq.') }}</h2>
    </div>
    <div class="place-list">
        @forelse ($places as $place)
            <article class="place-card">
                <span>{{ $place->number }}</span>
                <div>
                    <h3><a class="heading-link" href="{{ site_locale() === 'ar' ? route('places.show.locale', [$place, 'ar']) : route('places.show', $place) }}">{{ $place->name }}</a></h3>
                    <p>{{ $place->excerpt }}</p>
                </div>
            </article>
        @empty
            <p class="empty-copy">{{ site_locale() === 'ar' ? 'ستتوفر وجهات جديدة قريباً.' : 'New places will be available soon.' }}</p>
        @endforelse
    </div>
</section>
