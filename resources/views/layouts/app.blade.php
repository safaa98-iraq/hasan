<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ site_locale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#061b2a">
    <meta name="description" content="{{ $description ?? $pages?->get('meta_description')?->title ?? (site_locale() === 'ar' ? 'رحلات مدروسة عبر مدن العراق القديمة وتراثه الديني وثقافته الحية.' : 'Thoughtful journeys through Iraq’s ancient cities, living faith and everyday culture.') }}">
    <title>{{ $title ? $title . ' · Meso Travels' : ($pages?->get('meta_title')?->title ?? (site_locale() === 'ar' ? 'ميسو ترافلز — بلاد الرافدين كما لم ترها' : 'Meso Travels — Mesopotamia Revealed')) }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/meso-travels-logo.png') }}">
    <link rel="alternate" hreflang="{{ other_site_locale() }}" href="{{ $alternateUrl ?? site_language_url() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Newsreader:opsz,wght@6..72,400;6..72,500&family=Noto+Kufi+Arabic:wght@400;500;600&family=Noto+Naskh+Arabic:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/meso-travels.css') }}">
    <script src="{{ asset('js/meso-travels.js') }}" defer></script>
    @include('partials.theme-head')
</head>
<body id="top">
    <a class="skip-link" href="#main">{{ site_locale() === 'ar' ? 'الانتقال إلى المحتوى' : 'Skip to content' }}</a>
    <header class="site-header" data-header>
        <a class="brand" href="{{ site_home_url() }}" aria-label="{{ site_locale() === 'ar' ? 'الصفحة الرئيسية لميسو ترافلز' : 'Meso Travels home' }}">
            <img class="brand-logo" src="{{ asset('assets/meso-travels-logo.png') }}" alt="" width="1254" height="1254">
        </a>
        <nav class="site-nav" id="site-nav" aria-label="{{ site_locale() === 'ar' ? 'التنقل الرئيسي' : 'Main navigation' }}">
            <a href="{{ site_home_url('journey') }}">{{ site_locale() === 'ar' ? 'الرحلات' : 'The journeys' }}</a>
            <a href="{{ site_home_url('places') }}">{{ site_locale() === 'ar' ? 'الوجهات' : 'Places' }}</a>
            <a href="{{ site_home_url('approach') }}">{{ site_locale() === 'ar' ? 'نهجنا' : 'Our approach' }}</a>
        </nav>
        <div class="header-actions">
            <x-theme-toggle />
            <a class="language-toggle" data-language-toggle href="{{ $alternateUrl ?? site_language_url() }}" lang="{{ other_site_locale() }}" hreflang="{{ other_site_locale() }}" aria-label="{{ site_locale() === 'ar' ? 'View this page in English' : 'عرض هذه الصفحة باللغة العربية' }}">{{ site_locale() === 'ar' ? 'English' : 'العربية' }}</a>
            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-nav">
                <span class="sr-only">{{ site_locale() === 'ar' ? 'فتح القائمة' : 'Open menu' }}</span>
                <span aria-hidden="true"></span><span aria-hidden="true"></span>
            </button>
        </div>
    </header>
    <main id="main" tabindex="-1">{{ $slot }}</main>
    <footer class="site-footer">
        <div class="page-shell footer-inner">
            <a class="brand footer-brand" href="#top" aria-label="{{ site_locale() === 'ar' ? 'العودة إلى أعلى الصفحة' : 'Back to top' }}">
                <img class="brand-logo" src="{{ asset('assets/meso-travels-logo.png') }}" alt="Meso Travels" width="1254" height="1254" loading="lazy">
            </a>
            <p>{{ $pages?->get('footer_tagline')?->title ?? (site_locale() === 'ar' ? 'بلاد الرافدين كما لم ترها' : 'Mesopotamia Revealed') }}</p>
            <div class="footer-meta">
                <p>{{ $pages?->get('footer_copyright')?->title ?? '© Meso Travels' }} {{ date('Y') }}</p>
                <a href="{{ route('admin.dashboard') }}">{{ site_locale() === 'ar' ? 'لوحة الإدارة' : 'Administration' }}</a>
                @auth
                    <a href="{{ route('profile.edit') }}">{{ site_locale() === 'ar' ? 'حسابي' : 'My account' }}</a>
                @endauth
            </div>
        </div>
    </footer>
</body>
</html>
