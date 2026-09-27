@props(['title' => 'Your profile'])
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#061b2a">
    <link rel="icon" type="image/png" href="{{ asset('assets/meso-travels-logo.png') }}">
    <title>{{ __($title) }} · Meso Travels</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Newsreader:opsz,wght@6..72,400;6..72,500&family=Noto+Kufi+Arabic:wght@400;500;600&family=Noto+Naskh+Arabic:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/meso-travels.css') }}">
    <link rel="stylesheet" href="{{ asset('css/meso-account.css') }}">
    @include('partials.theme-head')
</head>
<body class="account-body">
    <a class="skip-link" href="#main">{{ __('Skip to content') }}</a>
    <header class="account-header">
        <div class="page-shell account-header-inner">
            <a class="account-brand" href="{{ route('home') }}" aria-label="{{ __('Meso Travels home') }}">
                <x-application-logo class="account-logo" />
                <span><strong>Meso Travels</strong><small>Mesopotamia Revealed</small></span>
            </a>
            <x-theme-toggle />
            <nav class="account-navigation" aria-label="{{ __('Account navigation') }}">
                <a href="{{ route('home') }}">{{ __('View site') }}</a>
                <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                <a href="{{ route('profile.edit') }}" aria-current="page">{{ __('Your profile') }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="account-signout">{{ __('Sign out') }}</button>
                </form>
            </nav>
        </div>
    </header>
    <main id="main" class="page-shell account-main">{{ $slot }}</main>
    <footer class="account-footer page-shell">© {{ date('Y') }} Meso Travels · Mesopotamia Revealed</footer>
</body>
</html>
