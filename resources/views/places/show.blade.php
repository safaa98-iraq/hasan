<x-app-layout :alternate-url="site_locale() === 'ar' ? route('places.show', $place) : route('places.show.locale', [$place, 'ar'])" :pages="$pages" :title="$place->name" :description="$place->excerpt">
    {{-- Subpage Hero --}}
    <section class="subpage-hero">
        @if ($place->image_path)
            <img src="{{ site_image_url($place->image_path) }}" alt="{{ $place->name }}" class="hero-image" fetchpriority="high">
        @else
            <img src="{{ asset('assets/iraq-river-hero.webp') }}" alt="{{ $place->name }}" class="hero-image" fetchpriority="high">
        @endif
        <div class="subpage-hero-scrim" aria-hidden="true"></div>

        <div class="page-shell" style="align-self: center;">
            <p class="eyebrow" style="margin-bottom: 14px;">
                <a href="{{ site_home_url('places') }}" style="color: var(--sand); text-decoration: none; opacity: 0.85; transition: opacity 160ms;">
                    {{ app()->getLocale() === 'ar' ? 'جميع الوجهات' : 'All Places' }}
                </a>
                <span style="opacity: 0.5; margin: 0 8px;">·</span>
                <span>{{ $place->number }}</span>
            </p>
            <h1>{{ $place->name }}</h1>
            @if ($place->excerpt)
                <p class="subpage-hero-subtitle">{{ $place->excerpt }}</p>
            @endif
        </div>
    </section>

    {{-- Main Content --}}
    <section class="content-section">
        <div class="page-shell content-grid">
            {{-- Left Column: Body Text --}}
            <div style="display: flex; flex-direction: column; gap: 36px;">
                <div class="detail-card">
                    <div class="section-label" style="border: none; padding-top: 0; margin-bottom: 18px;">
                        <span style="color: var(--lapis);">
                            {{ app()->getLocale() === 'ar' ? 'عن هذه الوجهة' : 'About this place' }}
                        </span>
                    </div>
                    <div style="font-size: 1.05rem; line-height: 1.8; color: var(--ink-soft);">
                        {!! $place->localizedParagraphs('body') !!}
                    </div>
                </div>
            </div>

            {{-- Right Sticky Column: Journey Info --}}
            <aside style="display: flex; flex-direction: column; gap: 28px;">
                <div class="detail-card-dark sticky-card">
                    @if ($place->stops->isNotEmpty())
                        <div class="section-label" style="border: none; padding-top: 0; margin-bottom: 18px;">
                            <span style="color: var(--sand); font-size: 0.74rem;">
                                {{ app()->getLocale() === 'ar' ? 'على مسار الرحلة' : 'On the Journey' }}
                            </span>
                        </div>

                        <ul style="margin: 0; padding: 0; list-style: none; display: flex; flex-direction: column; gap: 2px;">
                            @foreach ($place->stops as $stop)
                                <li style="display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 14px 0; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                                    <span style="display: flex; align-items: center; gap: 12px;">
                                        <span class="stop-badge" style="width: 32px; height: 32px; font-size: 0.88rem;">{{ $stop->number }}</span>
                                        <span>
                                            <span style="display: block; font-family: var(--serif); font-size: 1.1rem; font-weight: 500; color: var(--white);">
                                                {{ $stop->name }}
                                            </span>
                                            <span style="display: block; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.15em; color: rgba(255, 253, 248, 0.6);">
                                                {{ $stop->label }}
                                            </span>
                                        </span>
                                    </span>
                                    <span style="font-size: 0.74rem; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(255, 253, 248, 0.5);">
                                        {{ $stop->journey->title }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        @php $firstJourney = $place->stops->first()?->journey; @endphp
                        @if ($firstJourney)
                            <div style="margin-top: 22px; display: flex; flex-direction: column; gap: 10px;">
                                <a href="{{ site_locale() === 'ar' ? route('journeys.show.locale', [$firstJourney, 'ar']) : route('journeys.show', $firstJourney) }}"
                                   class="gold-button" style="width: 100%;">
                                    <span>{{ app()->getLocale() === 'ar' ? 'عرض تفاصيل الرحلة كاملة' : 'View Full Journey Details' }}</span>
                                    <span aria-hidden="true" style="display: inline-block;" class="direction-arrow">→</span>
                                </a>

                                @if ($firstJourney->price)
                                    <p style="text-align: center; font-size: 0.78rem; color: rgba(255, 253, 248, 0.65); margin: 4px 0 0;">
                                        {{ app()->getLocale() === 'ar' ? 'ابتداءً من' : 'Starting from' }}
                                        <strong style="color: var(--sun);">{{ $firstJourney->price }}</strong>
                                    </p>
                                @endif
                            </div>
                        @else
                            <div style="margin-top: 22px;">
                                <a href="{{ site_home_url('journey') }}"
                                   class="gold-button" style="width: 100%;">
                                    {{ app()->getLocale() === 'ar' ? 'عرض الرحلة' : 'View the Journey' }}
                                    <span aria-hidden="true" style="display: inline-block;" class="direction-arrow">→</span>
                                </a>
                            </div>
                        @endif
                    @else
                        <p class="eyebrow" style="color: var(--sand); font-size: 0.74rem; margin-bottom: 10px;">
                            {{ app()->getLocale() === 'ar' ? 'على مسار الرحلة' : 'On the Journey' }}
                        </p>
                        <p style="font-size: 0.9rem; line-height: 1.5; color: rgba(255, 253, 248, 0.7);">
                            {{ app()->getLocale() === 'ar' ? 'هذا المكان ليس جزءاً من رحلة منشورة حتى الآن.' : 'This place is not yet part of a published journey.' }}
                        </p>
                    @endif
                </div>

                {{-- Back to all places card --}}
                <div class="detail-card" style="text-align: center; padding: 24px;">
                    <a href="{{ site_home_url('places') }}" class="outline-button" style="width: 100%;">
                        {{ app()->getLocale() === 'ar' ? 'جميع الوجهات' : 'All places' }}
                    </a>
                </div>
            </aside>
        </div>
    </section>
</x-app-layout>