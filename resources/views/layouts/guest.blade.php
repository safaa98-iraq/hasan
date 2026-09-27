<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#061b2a">
    <link rel="icon" type="image/png" href="{{ asset('assets/meso-travels-logo.png') }}">
    <title>{{ __(trim((string) ($title ?? 'Your account'))) }} · Meso Travels</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Newsreader:opsz,wght@6..72,400;6..72,500&family=Noto+Kufi+Arabic:wght@400;500;600&family=Noto+Naskh+Arabic:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/meso-travels.css') }}">
    <link rel="stylesheet" href="{{ asset('css/meso-account.css') }}">
    @include('partials.theme-head')
</head>
<body class="account-body guest-body">
    <a class="skip-link" href="#main">{{ __('Skip to content') }}</a>
    <main id="main" class="guest-wrap">
        <div class="guest-shell">
            <div class="guest-theme-tools"><x-theme-toggle />
            </div>
            <a class="account-brand guest-brand" href="{{ route('home') }}" aria-label="{{ __('Meso Travels home') }}">
                <x-application-logo class="account-logo" />
                <span><strong>Meso Travels</strong><small>Mesopotamia Revealed</small></span>
            </a>
            <div class="guest-card">
                <header class="account-section-heading">
                    <p class="account-eyebrow">{{ __('Your Meso account') }}</p>
                    <h1>{{ __(trim((string) ($title ?? 'Your account'))) }}</h1>
                    @isset($description)<p>{{ __(trim((string) $description)) }}</p>@endisset
                </header>
                {{ $slot }}
            </div>
            <p class="guest-site-link"><a href="{{ route('home') }}">{{ __('← Back to the public site') }}</a></p>
        </div>
    </main>
</body>
</html>
