<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#063e61">
    <link rel="icon" type="image/png" href="{{ asset('assets/meso-travels-logo.png') }}">

    <title>{{ __('Dashboard') }} · Meso Travels</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Newsreader:opsz,wght@6..72,400;6..72,500&family=Noto+Kufi+Arabic:wght@400;500;600&family=Noto+Naskh+Arabic:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/meso-travels.css') }}">

    <link rel="stylesheet" href="{{ asset('css/meso-admin.css') }}">
    @include('partials.theme-head')
</head>
<body class="admin-body">
    <a class="skip-link" href="#admin-content">{{ __('Skip to content') }}</a>
    {{-- Admin Header --}}
    <header class="admin-header">
        <a href="{{ admin_route('admin.dashboard') }}" class="admin-brand">
            <img src="{{ asset('assets/meso-travels-logo.png') }}" alt="Meso Travels">
            <span class="admin-brand-name">
                Meso Travels
                <span class="admin-badge">{{ __('Dashboard') }}</span>
            </span>
        </a>
        <div class="admin-header-actions">
            <x-theme-toggle />
            <a href="{{ route('profile.edit') }}" class="admin-header-link">{{ __('Account') }}</a>
            <a href="{{ site_home_url() }}" class="admin-header-link" target="_blank" rel="noopener">{{ __('↗ View site') }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-signout-btn">{{ __('Sign out') }}</button>
            </form>
        </div>
    </header>

    {{-- Sub-navigation --}}
    <nav class="admin-subnav" aria-label="{{ __('Admin navigation') }}">
        <a href="{{ admin_route('admin.dashboard') }}" @if(request()->routeIs('admin.dashboard')) class="active" aria-current="page" @endif>{{ __('Dashboard') }}</a>
        <a href="{{ admin_route('admin.journeys.index') }}" @if(request()->routeIs('admin.journeys.*')) class="active" aria-current="page" @endif>{{ __('Journeys') }}</a>
        <a href="{{ admin_route('admin.places.index') }}" @if(request()->routeIs('admin.places.*')) class="active" aria-current="page" @endif>{{ __('Places') }}</a>
        <a href="{{ admin_route('admin.categories.index') }}" @if(request()->routeIs('admin.categories.*')) class="active" aria-current="page" @endif>{{ __('Categories') }}</a>
        <a href="{{ admin_route('admin.approach-points.index') }}" @if(request()->routeIs('admin.approach-points.*')) class="active" aria-current="page" @endif>{{ __('Approach points') }}</a>
        <a href="{{ admin_route('admin.pages.index') }}" @if(request()->routeIs('admin.pages.*')) class="active" aria-current="page" @endif>{{ __('Site copy') }}</a>
        <a href="{{ admin_route('admin.settings.edit') }}" @if(request()->routeIs('*.settings.*')) aria-current="page" @endif>{{ __('Contact settings') }}</a>
    </nav>

    {{-- Flash messages --}}
    @if (session('status') || session('success'))
        <div class="admin-flash admin-flash-success" role="status">
            ✓ {{ __(session('status') ?? session('success')) }}
        </div>
    @endif

    @if (session('error'))
        <div class="admin-flash admin-flash-error" role="alert">
            ✕ {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="admin-flash admin-flash-error" role="alert">
            <strong>{{ __('Please check the highlighted fields.') }}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Main Content --}}
    <main id="admin-content" class="admin-main" tabindex="-1">
        @include('partials.admin-help')
        {{ $slot }}
    </main>
    <footer class="admin-footer">Meso Travels · {{ __('Content management') }}</footer>
</body>
</html>