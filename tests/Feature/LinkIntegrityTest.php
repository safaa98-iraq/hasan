<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Journey;
use App\Models\Place;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class LinkIntegrityTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_application_controller_route_has_an_existing_action(): void
    {
        foreach (Route::getRoutes() as $route) {
            $action = $route->getActionName();

            if (! str_starts_with($action, 'App\\Http\\Controllers\\')) {
                continue;
            }

            [$controller, $method] = array_pad(explode('@', $action, 2), 2, '__invoke');
            $this->assertTrue(method_exists($controller, $method), $action);
        }

        $this->assertFalse(Route::has('admin.pages.show'));
    }

    public function test_nested_stop_actions_require_the_correct_journey(): void
    {
        $this->actingAs(User::factory()->dashboardAdmin()->create());
        $journey = Journey::create(['slug' => 'first', 'title_en' => 'First']);
        $other = Journey::create(['slug' => 'other', 'title_en' => 'Other']);
        $stop = $journey->stops()->create(['order' => 1, 'name_en' => 'Original stop']);

        $this->get(route('admin.journeys.stops.edit', [$journey, $stop]))->assertOk();
        $this->get(route('admin.journeys.stops.edit', [$other, $stop]))->assertNotFound();
        $this->put(route('admin.journeys.stops.update', [$other, $stop]), [
            'order' => 2,
            'name_en' => 'Wrong journey update',
        ])->assertNotFound();
        $this->delete(route('admin.journeys.stops.destroy', [$other, $stop]))->assertNotFound();

        $this->assertDatabaseHas('journey_stops', [
            'id' => $stop->id,
            'journey_id' => $journey->id,
            'name_en' => 'Original stop',
        ]);

        $this->put(route('admin.journeys.stops.update', [$journey, $stop]), [
            'order' => 2,
            'name_en' => 'Updated stop',
        ])->assertRedirect(route('admin.journeys.edit', $journey));
        $this->assertSame('Updated stop', $stop->fresh()->name_en);

        $this->delete(route('admin.journeys.stops.destroy', [$journey, $stop]))
            ->assertRedirect(route('admin.journeys.edit', $journey));
        $this->assertModelMissing($stop);
    }

    public function test_public_journeys_do_not_link_to_unpublished_places(): void
    {
        $place = Place::factory()->create(['is_published' => false]);
        $journey = Journey::create(['slug' => 'published', 'title_en' => 'Published', 'is_published' => true]);
        $journey->stops()->create(['order' => 1, 'name_en' => 'Visible itinerary stop', 'place_id' => $place->id]);

        $this->get(route('journeys.show', $journey))
            ->assertOk()
            ->assertViewHas('journey', fn ($record) => $record->stops->first()->place === null)
            ->assertSee('Visible itinerary stop')
            ->assertDontSee('href="'.route('places.show', $place).'"', false);

        $this->get(route('home'))
            ->assertOk()
            ->assertViewHas('journey', fn ($record) => $record->stops->first()->place === null);
    }

    public function test_public_places_only_list_published_journeys(): void
    {
        $place = Place::factory()->create(['is_published' => true]);
        $hidden = Journey::create(['slug' => 'hidden', 'title_en' => 'Hidden journey', 'is_published' => false]);
        $published = Journey::create(['slug' => 'published', 'title_en' => 'Published journey', 'is_published' => true]);

        foreach ([$hidden, $published] as $journey) {
            $journey->stops()->create(['order' => 1, 'name_en' => 'Stop', 'place_id' => $place->id]);
        }

        $this->get(route('places.show', $place))
            ->assertOk()
            ->assertViewHas('place', fn ($record) => $record->stops->pluck('journey_id')->all() === [$published->id])
            ->assertDontSee('Hidden journey')
            ->assertSee(route('journeys.show', $published));
    }

    public function test_default_public_routes_reset_locale_after_an_arabic_request(): void
    {
        $place = Place::factory()->create(['is_published' => true]);
        $journey = Journey::create(['slug' => 'journey', 'title_en' => 'Journey', 'is_published' => true]);

        foreach ([route('home'), route('places.show', $place), route('journeys.show', $journey)] as $url) {
            $this->get('/ar')->assertOk()->assertSee('lang="ar"', false);
            $this->get($url)->assertOk()->assertSee('lang="en"', false);
        }

        $this->get(route('places.show', $place))->assertOk();
        $this->assertSame(route('places.show.locale', [$place, 'ar']), site_language_url());
        $this->get(route('journeys.show.locale', [$journey, 'ar']))->assertOk();
        $this->assertSame(route('journeys.show', $journey), site_language_url());
    }

    public function test_generated_and_normalized_slugs_are_validated_before_saving(): void
    {
        $this->actingAs(User::factory()->dashboardAdmin()->create());

        foreach ([['journeys', Journey::class, 'title_en'], ['places', Place::class, 'name_en'], ['categories', Category::class, 'title_en']] as [$resource, $model, $field]) {
            $existing = $model::create(['slug' => 'same-title', $field => 'Same title', 'order' => 1]);
            $other = $model::create(['slug' => 'other-title', $field => 'Other title', 'order' => 2]);

            $this->post(route('admin.'.$resource.'.store'), ['order' => 3, $field => 'Same title'])
                ->assertSessionHasErrors('slug');
            $this->put(route('admin.'.$resource.'.update', $other), [
                'order' => 2,
                $field => 'Other title',
                'slug' => 'Same Title',
            ])->assertSessionHasErrors('slug');

            $this->assertSame('same-title', $existing->fresh()->slug);
            $this->assertSame('other-title', $other->fresh()->slug);
            $this->assertSame(2, $model::count());
        }
    }

    public function test_media_urls_and_configured_contact_links_resolve_consistently(): void
    {
        $this->assertSame(asset('storage/images/places/baghdad.svg'), site_image_url('images/places/baghdad.svg'));
        $this->assertSame(asset('storage/images/photo.jpg'), site_image_url('/storage/images/photo.jpg'));
        $this->assertSame(asset('assets/iraq-river-hero.webp'), site_image_url(null, 'assets/iraq-river-hero.webp'));
        $this->assertSame('https://example.com/photo.jpg', site_image_url('https://example.com/photo.jpg'));
        $this->assertNull(site_image_url(null));

        config(['site.contact_email' => null]);
        $this->assertNull(site_contact_url());
        config(['site.contact_email' => 'not-an-email']);
        $this->assertNull(site_contact_url());
        config(['site.contact_email' => 'journeys@example.com']);
        $this->assertSame('mailto:journeys@example.com?subject=Journey%20%26%20dates', site_contact_url('Journey & dates'));
    }
}
