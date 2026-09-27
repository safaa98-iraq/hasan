<section class="journey section" id="journey" aria-labelledby="journey-title">
    <div class="page-shell">
        <div class="journey-heading">
            <div>
                <p class="eyebrow dark">{{ $pages->get('journey_eyebrow')?->title }}</p>
                <h2 id="journey-title">
                    @if ($journey)
                        <a class="heading-link" href="{{ site_locale() === 'ar' ? route('journeys.show.locale', [$journey, 'ar']) : route('journeys.show', $journey) }}">{{ $journey->title }}</a>
                    @else
                        {{ site_locale() === 'ar' ? 'رحلتك القادمة تبدأ هنا.' : 'Your next journey starts here.' }}
                    @endif
                </h2>
            </div>
            <p>{{ $journey?->subtitle ?? (site_locale() === 'ar' ? 'نعمل على إعداد رحلات جديدة. تابعنا لمعرفة المزيد.' : 'New journeys are being prepared. Check back for more.') }}</p>
        </div>
        @if ($journey)
            <ol class="route" style="--stop-count: {{ max(1, $journey->stops->count()) }}" aria-label="{{ site_locale() === 'ar' ? 'مسار الرحلة' : 'Journey route' }}">
                @foreach ($journey->stops as $stop)
                    <li class="route-stop {{ $loop->first ? 'route-start' : '' }} {{ $loop->last ? 'route-return' : '' }}">
                        <span class="route-number">{{ $stop->number }}</span>
                        <div>
                            <strong>
                                @if ($stop->place?->is_published)
                                    <a class="heading-link" href="{{ site_locale() === 'ar' ? route('places.show.locale', [$stop->place, 'ar']) : route('places.show', $stop->place) }}">{{ $stop->name }}</a>
                                @else
                                    {{ $stop->name }}
                                @endif
                            </strong>
                            <small>{{ $stop->label }}</small>
                        </div>
                    </li>
                @endforeach
            </ol>
            <div class="journey-note">
                <span>{{ site_locale() === 'ar' ? 'صُممت كحكاية واحدة مترابطة' : 'Designed as one connected story' }}</span>
                <p>{{ $journey->description }}</p>
            </div>
            <div class="journey-actions">
                <a class="button" href="{{ site_locale() === 'ar' ? route('journeys.show.locale', [$journey, 'ar']) : route('journeys.show', $journey) }}">
                    {{ site_locale() === 'ar' ? 'التفاصيل والأسعار والصور' : 'Journey details, pricing & photos' }}
                    <span aria-hidden="true" class="direction-arrow">→</span>
                </a>
                @if ($journey->price)<span class="journey-price">{{ $journey->price }}</span>@endif
            </div>
        @endif
        @if ($journeys->count() > 1)
            <div class="more-journeys">
                @foreach ($journeys->skip(1) as $otherJourney)
                    <a class="journey-preview" href="{{ site_locale() === 'ar' ? route('journeys.show.locale', [$otherJourney, 'ar']) : route('journeys.show', $otherJourney) }}">
                        <span class="eyebrow dark">{{ $otherJourney->number }}</span>
                        <h3>{{ $otherJourney->title }}</h3>
                        <p>{{ $otherJourney->subtitle }}</p>
                        <span>{{ collect([$otherJourney->duration, $otherJourney->price])->filter()->join(' · ') }}</span>
                        <span class="direction-arrow" aria-hidden="true">→</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
