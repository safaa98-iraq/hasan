<section class="hero" aria-labelledby="hero-title">
    <img class="hero-image" src="{{ site_image_url($pages->get('hero_heading')?->image_path, asset('assets/iraq-river-hero.webp')) }}" alt="{{ site_locale() === 'ar' ? 'نهر دجلة وقت الغروب' : 'The Tigris at golden hour' }}" width="1983" height="793" fetchpriority="high">
    <div class="hero-scrim" aria-hidden="true"></div>
    <div class="hero-content page-shell">
        <p class="eyebrow">{{ $pages->get('hero_eyebrow')?->title ?? (site_locale() === 'ar' ? 'بلاد الرافدين كما لم ترها · العراق' : 'Mesopotamia Revealed · Iraq') }}</p>
        <h1 id="hero-title">{{ $pages->get('hero_heading')?->title ?? (site_locale() === 'ar' ? 'اقترب أكثر. لدى العراق حكايات يرويها.' : 'Come closer. Iraq has stories to tell.') }}</h1>
        <p class="hero-intro">{{ $pages->get('hero_sub')?->title }}</p>
        <a class="button button-light" href="#journey">
            <span>{{ $pages->get('hero_cta')?->title ?? (site_locale() === 'ar' ? 'اكتشف الرحلات' : 'Explore the journeys') }}</span>
            <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4 10h11M11 6l4 4-4 4" /></svg>
        </a>
    </div>
    <div class="hero-foot page-shell">
        <span>{{ $journey?->number ?? '01' }}</span>
        <strong>{{ $journey?->title ?? (site_locale() === 'ar' ? 'اكتشف العراق' : 'Discover Iraq') }}</strong>
        <p>{{ $journey?->duration ?? (site_locale() === 'ar' ? 'تاريخ · تراث ديني · ثقافة محلية' : 'History · sacred heritage · local culture') }}</p>
    </div>
</section>
