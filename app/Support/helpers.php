<?php

use App\Models\Page;
use Illuminate\Support\Facades\URL;

if (! function_exists('site_locale')) {
    function site_locale(): string
    {
        return app()->getLocale() === 'ar' ? 'ar' : 'en';
    }
}

if (! function_exists('other_site_locale')) {
    function other_site_locale(): string
    {
        return site_locale() === 'ar' ? 'en' : 'ar';
    }
}

if (! function_exists('site_home_url')) {
    function site_home_url(?string $anchor = null): string
    {
        $url = site_locale() === 'ar' ? URL::to('/ar') : URL::to('/');

        return $anchor ? $url.'#'.$anchor : $url;
    }
}

if (! function_exists('site_language_url')) {
    function site_language_url(): string
    {
        $locale = other_site_locale();

        foreach (['places' => 'place', 'journeys' => 'journey'] as $resource => $parameter) {
            if (request()->routeIs($resource.'.show', $resource.'.show.locale')) {
                $model = request()->route($parameter);

                return $locale === 'ar'
                    ? route($resource.'.show.locale', [$model, $locale])
                    : route($resource.'.show', $model);
            }
        }

        return $locale === 'ar' ? route('home.locale', 'ar') : route('home');
    }
}

if (! function_exists('site_image_url')) {
    function site_image_url(?string $path, ?string $fallback = null): ?string
    {
        $path = trim($path ?: ($fallback ?? ''));

        if ($path === '') {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $path = ltrim($path, '/');

        return asset(str_starts_with($path, 'assets/') || str_starts_with($path, 'storage/')
            ? $path
            : 'storage/'.$path);
    }
}

if (! function_exists('site_contact_url')) {
    function site_contact_url(?string $subject = null): ?string
    {
        foreach ([
            Page::where('key', 'contact_email')->value('title_'.site_locale()),
            config('site.contact_email_'.site_locale()),
            config('site.contact_email'),
        ] as $email) {
            if (is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && ! str_ends_with(strtolower($email), '.test')) {
                return 'mailto:'.$email.($subject ? '?subject='.rawurlencode($subject) : '');
            }
        }

        return null;
    }
}

if (! function_exists('admin_route')) {
    function admin_route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        return route($name, $parameters, $absolute);
    }
}
