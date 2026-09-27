<section class="closing" id="contact" aria-labelledby="closing-title">
    <div class="closing-pattern" aria-hidden="true"></div>
    <div class="page-shell closing-inner">
        <p class="eyebrow">{{ $pages->get('cta_eyebrow')?->title }}</p>
        <h2 id="closing-title">{{ $pages->get('cta_heading')?->title }}</h2>
        <p>{{ $pages->get('cta_body')?->title }}</p>
        @if (site_contact_url())
            <a class="text-link" href="{{ site_contact_url() }}">{{ site_locale() === 'ar' ? 'تواصل معنا لتخطيط رحلتك' : 'Contact us to plan your journey' }} <span aria-hidden="true">↗</span></a>
        @else
            <a class="text-link" href="{{ site_home_url('journey') }}"><span>{{ $pages->get('cta_button')?->title ?? (site_locale() === 'ar' ? 'استكشف الرحلات' : 'Explore the journeys') }}</span> <span aria-hidden="true">↗</span></a>
        @endif
    </div>
</section>
