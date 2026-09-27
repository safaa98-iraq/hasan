@php
    $code = trim($__env->yieldContent('code', '500'));
    $arabic = app()->getLocale() === 'ar' || request()->segment(1) === 'ar' || str_ends_with(request()->path(), '/ar');
    $messages = [
        '401' => ['Please sign in to continue.', 'يرجى تسجيل الدخول للمتابعة.'],
        '403' => ['You do not have access to this page.', 'ليس لديك صلاحية للوصول إلى هذه الصفحة.'],
        '404' => ['This page is no longer here, but there is more to discover.', 'هذه الصفحة غير موجودة، لكن هناك المزيد لتكتشفه.'],
        '419' => ['Your session has expired. Go back, refresh the page and try again.', 'انتهت صلاحية الجلسة. عد إلى الصفحة وحدّثها ثم حاول مجدداً.'],
        '429' => ['Too many requests. Please wait a moment and try again.', 'طلبات كثيرة في وقت قصير. انتظر قليلاً ثم حاول مجدداً.'],
        '500' => ['Something went wrong. Please try again shortly.', 'حدث خطأ. يرجى المحاولة مجدداً بعد قليل.'],
        '503' => ['We are making a few updates. Please come back shortly.', 'نعمل على تحديث الموقع. يرجى العودة بعد قليل.'],
    ];
    $message = ($messages[$code] ?? $messages['500'])[$arabic ? 1 : 0];
@endphp
<!doctype html>
<html lang="{{ $arabic ? 'ar' : 'en' }}" dir="{{ $arabic ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#061b2a">
    <title>{{ $code }} · Meso Travels</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/meso-travels-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Newsreader:opsz,wght@6..72,400;6..72,500&family=Noto+Kufi+Arabic:wght@400;500;600&family=Noto+Naskh+Arabic:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/meso-travels.css') }}">
    @include('partials.theme-head')
</head>
<body class="error-page">
    <main class="page-shell error-content">
        <x-theme-toggle />
        <a class="brand" href="{{ $arabic ? route('home.locale', 'ar') : route('home') }}" aria-label="{{ $arabic ? 'الصفحة الرئيسية' : 'Home' }}">
            <img class="brand-logo" src="{{ asset('assets/meso-travels-logo.png') }}" alt="Meso Travels" width="78" height="78">
        </a>
        <p class="eyebrow">Meso Travels · {{ $code }}</p>
        <h1>{{ $message }}</h1>
        <a class="gold-button" href="{{ $arabic ? route('home.locale', 'ar') : route('home') }}">{{ $arabic ? 'العودة إلى الرئيسية' : 'Back to home' }} <span class="direction-arrow" aria-hidden="true">→</span></a>
    </main>
</body>
</html>
