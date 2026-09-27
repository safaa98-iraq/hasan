@php
    $name = request()->route()->getName();
    $hint = match (true) {
        str_contains($name, '.stops.') => 'Link a stop to a published place to give visitors a working destination link.',
        str_contains($name, '.journeys.') => 'Save the journey first, then add its stops. Put each included or excluded item on a separate line.',
        str_contains($name, '.pages.') => 'Edit the title for most site text. The intro_body record uses Body; only hero_heading uses the uploaded image.',
        str_contains($name, '.categories.'), str_contains($name, '.approach-points.') => 'These cards appear on the homepage. Order controls their position.',
        str_contains($name, '.places.') => 'Use a smaller Order number to display an item earlier. Draft items stay hidden from visitors.',
        str_contains($name, '.settings.') => 'Use a working mailbox you own. Addresses ending in .test are examples and do not activate public email links.',
        default => 'Add a place, create a journey, then add its stops. Use Published when the content is ready for visitors.',
    };
@endphp
<aside class="admin-help" aria-label="{{ __('Quick tip') }}">
    <strong>{{ __('Quick tip') }}</strong><p>{{ __($hint) }}</p>
</aside>
