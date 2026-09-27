<x-app-layout :alternate-url="site_locale() === 'ar' ? route('journeys.show', $journey) : route('journeys.show.locale', [$journey, 'ar'])" :pages="$pages" :title="$journey->title" :description="$journey->subtitle">
    {{-- Subpage Hero Section --}}
    <section class="subpage-hero">
        @if ($journey->image_path)
            <img src="{{ site_image_url($journey->image_path) }}" alt="{{ $journey->title }}" class="hero-image" fetchpriority="high">
        @else
            <img src="{{ asset('assets/iraq-river-hero.webp') }}" alt="{{ $journey->title }}" class="hero-image" fetchpriority="high">
        @endif
        <div class="subpage-hero-scrim" aria-hidden="true"></div>

        <div class="page-shell" style="align-self: center;">
            <p class="eyebrow" style="margin-bottom: 14px;">
                <a href="{{ site_home_url('journey') }}" style="color: var(--sand); text-decoration: none;">
                    {{ app()->getLocale() === 'ar' ? 'العودة إلى الرحلات' : 'All Journeys' }}
                </a>
                <span style="opacity: 0.6; margin: 0 8px;">·</span>
                <span>{{ $journey->number }}</span>
            </p>

            <h1>{{ $journey->title }}</h1>

            @if ($journey->subtitle)
                <p class="subpage-hero-subtitle">{{ $journey->subtitle }}</p>
            @endif

            {{-- Quick Badges --}}
            <div class="badge-pill-row">
                @if ($journey->price)
                    <div class="badge-pill badge-pill-accent">
                        <span style="opacity: 0.8; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.1em;">{{ app()->getLocale() === 'ar' ? 'السعر' : 'Price' }}</span>
                        <span>{{ $journey->price }}</span>
                    </div>
                @endif

                @if ($journey->duration)
                    <div class="badge-pill">
                        <span style="opacity: 0.7; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.1em;">{{ app()->getLocale() === 'ar' ? 'المدة' : 'Duration' }}</span>
                        <span>{{ $journey->duration }}</span>
                    </div>
                @endif

                <div class="badge-pill">
                    <span style="opacity: 0.7; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.1em;">{{ app()->getLocale() === 'ar' ? 'المحطات' : 'Stops' }}</span>
                    <span>{{ $journey->stops->count() }} {{ app()->getLocale() === 'ar' ? 'محطات' : 'stops' }}</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content Section --}}
    <section class="content-section">
        <div class="page-shell content-grid">
            {{-- Left Column: Overview, Gallery, Itinerary, Inclusions --}}
            <div style="display: flex; flex-direction: column; gap: 48px;">
                {{-- Overview & Story --}}
                <div class="detail-card">
                    <div class="section-label" style="border: none; padding-top: 0; margin-bottom: 16px;">
                        <span style="color: var(--lapis);">{{ app()->getLocale() === 'ar' ? 'عن هذه الرحلة' : 'Journey Overview' }}</span>
                    </div>
                    <div style="font-size: 1.05rem; line-height: 1.8; color: var(--ink-soft);">
                        {!! $journey->localizedParagraphs('description') !!}
                    </div>
                </div>

                {{-- Photo Gallery --}}
                @php
                    $galleryImages = is_array($journey->gallery) ? $journey->gallery : [];
                    if (empty($galleryImages) && $journey->image_path) {
                        $galleryImages = [$journey->image_path];
                    }
                    foreach ($journey->stops as $s) {
                        if ($s->image_path && !in_array($s->image_path, $galleryImages)) {
                            $galleryImages[] = $s->image_path;
                        }
                    }
                @endphp

                @if (!empty($galleryImages))
                    <div class="detail-card">
                        <div class="section-label" style="border: none; padding-top: 0; margin-bottom: 20px;">
                            <span style="color: var(--lapis);">{{ app()->getLocale() === 'ar' ? 'معرض صور الرحلة' : 'Journey Gallery' }}</span>
                        </div>
                        <div class="journey-gallery">
                            @foreach ($galleryImages as $img)
                                <div style="aspect-ratio: 4/3; overflow: hidden; border-radius: 12px; border: 1px solid var(--line); background: var(--paper);">
                                    <img src="{{ site_image_url($img) }}" alt="{{ $journey->title }} — {{ app()->getLocale() === 'ar' ? 'صورة' : 'Photo' }} {{ $loop->iteration }}" loading="lazy"
                                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 300ms ease;"
                                         >
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Stop by Stop Itinerary --}}
                <div>
                    <div style="display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 8px;">
                        <div class="section-label" style="border: none; padding-top: 0;">
                            <span style="color: var(--lapis);">{{ app()->getLocale() === 'ar' ? 'محطات وخط سير الرحلة' : 'Itinerary & Stops' }}</span>
                        </div>
                        <span style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--ink-soft); opacity: 0.7;">
                            {{ $journey->stops->count() }} {{ app()->getLocale() === 'ar' ? 'محطة' : 'Stops' }}
                        </span>
                    </div>

                    <div class="itinerary-list">
                        @forelse ($journey->stops as $stop)
                            <article class="itinerary-card">
                                <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                                    <div style="display: flex; align-items: center; gap: 14px;">
                                        <span class="stop-badge">{{ $stop->number }}</span>
                                        <div>
                                            <h3 style="margin: 0; font-family: var(--serif); font-size: 1.55rem; font-weight: 500; color: var(--ink);">
                                                {{ $stop->name }}
                                            </h3>
                                            @if ($stop->label)
                                                <small style="display: block; font-size: 0.74rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--river); font-weight: 600; margin-top: 2px;">
                                                    {{ $stop->label }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($stop->place?->is_published)
                                        <a href="{{ site_locale() === 'ar' ? route('places.show.locale', [$stop->place, 'ar']) : route('places.show', $stop->place) }}"
                                           class="outline-button" style="font-size: 0.78rem; padding: 0 16px; min-height: 36px;">
                                            <span>{{ app()->getLocale() === 'ar' ? 'عن هذا المكان' : 'About this place' }}</span>
                                            <span aria-hidden="true" style="display: inline-block;" class="direction-arrow">→</span>
                                        </a>
                                    @endif
                                </div>

                                @if ($stop->description)
                                    <p style="margin: 16px 0 0; font-size: 0.98rem; line-height: 1.65; color: var(--ink-soft);">
                                        {{ $stop->description }}
                                    </p>
                                @endif

                                @if ($stop->image_path)
                                    <div style="margin-top: 18px; border-radius: 12px; overflow: hidden; border: 1px solid var(--line); max-height: 280px;">
                                        <img src="{{ site_image_url($stop->image_path) }}" alt="{{ $stop->name }}"
                                             style="width: 100%; height: 100%; max-height: 280px; object-fit: cover;">
                                    </div>
                                @endif
                            </article>
                        @empty
                            <p style="color: var(--ink-soft); font-size: 0.95rem;">{{ app()->getLocale() === 'ar' ? 'لا توجد محطات مسجلة لهذه الرحلة حتى الآن.' : 'No stops registered for this journey yet.' }}</p>
                        @endforelse
                    </div>
                </div>

                {{-- What's Included & Excluded --}}
                @if (!empty($journey->included_list) || !empty($journey->excluded_list))
                    <div class="inclusions-grid">
                        @if (!empty($journey->included_list))
                            <div class="detail-card">
                                <h3 style="margin: 0 0 16px; font-family: var(--serif); font-size: 1.35rem; font-weight: 500; color: var(--ink); display: flex; align-items: center; gap: 8px;">
                                    <span style="color: #2b7a4b; font-weight: bold;">✓</span>
                                    {{ app()->getLocale() === 'ar' ? 'الرحلة تشمل' : 'What is Included' }}
                                </h3>
                                <ul style="margin: 0; padding: 0; list-style: none; display: flex; flex-direction: column; gap: 10px;">
                                    @foreach ($journey->included_list as $item)
                                        <li style="display: flex; align-items: flex-start; gap: 10px; font-size: 0.92rem; line-height: 1.5; color: var(--ink-soft);">
                                            <span style="color: var(--sun); font-size: 0.75rem; margin-top: 4px;">◆</span>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (!empty($journey->excluded_list))
                            <div class="detail-card">
                                <h3 style="margin: 0 0 16px; font-family: var(--serif); font-size: 1.35rem; font-weight: 500; color: var(--ink); display: flex; align-items: center; gap: 8px;">
                                    <span style="color: #9c413b; font-weight: bold;">✕</span>
                                    {{ app()->getLocale() === 'ar' ? 'الرحلة لا تشمل' : 'Not Included' }}
                                </h3>
                                <ul style="margin: 0; padding: 0; list-style: none; display: flex; flex-direction: column; gap: 10px;">
                                    @foreach ($journey->excluded_list as $item)
                                        <li style="display: flex; align-items: flex-start; gap: 10px; font-size: 0.92rem; line-height: 1.5; color: var(--ink-soft); opacity: 0.85;">
                                            <span style="color: var(--line); font-size: 0.75rem; margin-top: 4px;">◇</span>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Right Sticky Column: Pricing & Booking Card --}}
            <aside style="display: flex; flex-direction: column; gap: 28px;">
                <div class="detail-card-dark sticky-card">
                    <p class="eyebrow" style="color: var(--sand); margin-bottom: 8px; font-size: 0.72rem;">
                        {{ app()->getLocale() === 'ar' ? 'الحجز والاستفسار' : 'Booking & Inquiries' }}
                    </p>

                    @if ($journey->price)
                        <div style="border-bottom: 1px solid rgba(255, 255, 255, 0.15); padding-bottom: 18px; margin-bottom: 20px;">
                            <span style="display: block; font-size: 0.74rem; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255, 253, 248, 0.7);">
                                {{ app()->getLocale() === 'ar' ? 'سعر الرحلة' : 'Starting from' }}
                            </span>
                            <span style="font-family: var(--serif); font-size: 2.4rem; font-weight: 500; color: var(--sun);">
                                {{ $journey->price }}
                            </span>
                        </div>
                    @endif

                    <dl style="display: flex; flex-direction: column; gap: 12px; margin: 0 0 24px; font-size: 0.9rem;">
                        @if ($journey->duration)
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding-bottom: 8px;">
                                <dt style="color: rgba(255, 253, 248, 0.7);">{{ app()->getLocale() === 'ar' ? 'المدة' : 'Duration' }}</dt>
                                <dd style="font-weight: 600; color: var(--white); margin: 0;">{{ $journey->duration }}</dd>
                            </div>
                        @endif
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding-bottom: 8px;">
                            <dt style="color: rgba(255, 253, 248, 0.7);">{{ app()->getLocale() === 'ar' ? 'المحطات' : 'Stops' }}</dt>
                            <dd style="font-weight: 600; color: var(--white); margin: 0;">{{ $journey->stops->count() }} {{ app()->getLocale() === 'ar' ? 'محطات' : 'stops' }}</dd>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding-bottom: 8px;">
                            <dt style="color: rgba(255, 253, 248, 0.7);">{{ app()->getLocale() === 'ar' ? 'نوع الرحلة' : 'Tour Type' }}</dt>
                            <dd style="font-weight: 600; color: var(--white); margin: 0;">{{ app()->getLocale() === 'ar' ? 'خاصة وموجهة' : 'Private & Guided' }}</dd>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <dt style="color: rgba(255, 253, 248, 0.7);">{{ app()->getLocale() === 'ar' ? 'اللغات' : 'Languages' }}</dt>
                            <dd style="font-weight: 600; color: var(--white); margin: 0;">{{ app()->getLocale() === 'ar' ? 'الإنجليزية، العربية' : 'English, Arabic' }}</dd>
                        </div>
                    </dl>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @if ($contactUrl = site_contact_url('Inquiry for journey: ' . $journey->title))
                            <a href="{{ $contactUrl }}" class="gold-button">
                                <span>{{ app()->getLocale() === 'ar' ? 'استفسر عن هذه الرحلة' : 'Inquire about this journey' }}</span>
                                <span aria-hidden="true" class="direction-arrow">→</span>
                            </a>
                        @else
                            <p class="booking-note">{{ app()->getLocale() === 'ar' ? 'سيُعلن عن تفاصيل التواصل والحجز قريباً.' : 'Contact and booking details will be announced soon.' }}</p>
                        @endif

                        <a href="{{ site_home_url('journey') }}"
                           class="button button-light" style="width: 100%; border-radius: 999px; min-height: 44px; font-size: 0.8rem; border-color: rgba(255, 255, 255, 0.25);">
                            {{ app()->getLocale() === 'ar' ? 'استعراض كل المسارات' : 'View All Journeys' }}
                        </a>
                    </div>

                    <p style="margin: 20px 0 0; font-size: 0.78rem; text-align: center; color: rgba(255, 253, 248, 0.65); line-height: 1.45;">
                        {{ app()->getLocale() === 'ar' ? 'رحلات ميسو ترافلز تضمن تجربة أصيلة ومدروسة بمعرفة أهل البلاد.' : 'Meso Travels journeys are thoughtfully paced and curated by local insiders.' }}
                    </p>
                </div>

                {{-- Other Journeys Card --}}
                @if ($otherJourneys->isNotEmpty())
                    <div class="detail-card">
                        <div class="section-label" style="border: none; padding-top: 0; margin-bottom: 12px;">
                            <span style="color: var(--lapis); font-size: 0.74rem;">{{ app()->getLocale() === 'ar' ? 'رحلات أخرى قد تهمك' : 'Other Journeys' }}</span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @foreach ($otherJourneys as $oj)
                                <a href="{{ site_locale() === 'ar' ? route('journeys.show.locale', [$oj, 'ar']) : route('journeys.show', $oj) }}"
                                   style="text-decoration: none; padding-bottom: 10px; border-bottom: 1px solid var(--line); color: inherit; transition: opacity 160ms ease;"
                                   class="related-journey">
                                    <p style="margin: 0; font-family: var(--serif); font-size: 1.15rem; font-weight: 500; color: var(--ink);">
                                        {{ $oj->title }}
                                    </p>
                                    @if ($oj->price || $oj->duration)
                                        <p style="margin: 4px 0 0; font-size: 0.8rem; color: var(--ink-soft);">
                                            {{ collect([$oj->duration, $oj->price])->filter()->join(' · ') }}
                                        </p>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </section>
</x-app-layout>
