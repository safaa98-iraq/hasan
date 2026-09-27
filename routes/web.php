<?php

use App\Http\Controllers\Admin\ApproachPointController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JourneyController as AdminJourneyController;
use App\Http\Controllers\Admin\JourneyStopController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PlaceController as AdminPlaceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\PlaceController;
use App\Http\Middleware\SetAdminLocale;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/{locale}', [HomeController::class, 'index'])->whereIn('locale', ['en', 'ar'])->name('home.locale');

Route::get('/places/{place:slug}', [PlaceController::class, 'show'])->name('places.show');
Route::get('/places/{place:slug}/{locale}', [PlaceController::class, 'show'])->whereIn('locale', ['en', 'ar'])->name('places.show.locale');

Route::get('/journeys/{journey:slug}', [JourneyController::class, 'show'])->name('journeys.show');
Route::get('/journeys/{journey:slug}/{locale}', [JourneyController::class, 'show'])->whereIn('locale', ['en', 'ar'])->name('journeys.show.locale');

Route::middleware(['auth', SetAdminLocale::class])
        ->prefix('admin')->name('admin.')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

            Route::get('settings/contact', [ContactSettingController::class, 'edit'])->name('settings.edit');
            Route::put('settings/contact', [ContactSettingController::class, 'update'])->name('settings.update');

            Route::resource('places', AdminPlaceController::class)->except(['show']);
            Route::resource('categories', CategoryController::class)->except(['show']);
            Route::resource('approach-points', ApproachPointController::class)->except(['show']);
            Route::resource('journeys', AdminJourneyController::class)->except(['show']);
            Route::resource('journeys.stops', JourneyStopController::class)->except(['show'])->scoped();
            Route::resource('pages', PageController::class)->only(['index', 'edit', 'update']);
        });

// Keep bookmarks from the former language-specific dashboards working.
Route::get('/admin/{legacyLocale}/{path?}', function (string $legacyLocale, ?string $path = null) {
    return redirect($path === 'login' ? route('login') : url('/admin'.($path ? '/'.$path : '')));
})->whereIn('legacyLocale', ['en', 'ar'])->where('path', '.*');

Route::get('/dashboard', function () {
    return redirect(route('admin.dashboard'));
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
