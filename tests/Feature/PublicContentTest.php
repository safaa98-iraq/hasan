<?php

namespace Tests\Feature;

use App\Models\ApproachPoint;
use App\Models\Category;
use App\Models\Journey;
use App\Models\Page;
use App\Models\Place;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_uses_edited_content_and_all_published_records_in_both_languages(): void
    {
        $this->seed();
        Page::where('key', 'hero_heading')->update(['title_en' => 'A new story of Iraq', 'title_ar' => 'حكاية جديدة عن العراق']);
        Page::where('key', 'intro_body')->update(['body_en' => 'Edited introduction from the dashboard.']);
        Category::first()->update(['title_en' => 'Updated cultural experience']);
        ApproachPoint::first()->update(['description_en' => 'Updated local approach']);
        $place = Place::factory()->create(['slug' => 'new-destination', 'name_en' => 'New destination', 'name_ar' => 'وجهة جديدة', 'is_published' => true]);
        $journey = Journey::create(['slug' => 'new-journey', 'title_en' => 'New journey', 'title_ar' => 'رحلة جديدة', 'is_published' => true, 'order' => 9]);
        $hidden = Place::factory()->create(['slug' => 'hidden-destination', 'is_published' => false]);

        $this->get('/')
            ->assertOk()
            ->assertSee('A new story of Iraq')
            ->assertDontSee('Come closer.')
            ->assertSee('Edited introduction from the dashboard.')
            ->assertSee('Updated cultural experience')
            ->assertSee('Updated local approach')
            ->assertSee('href="'.route('places.show', $place).'"', false)
            ->assertSee('href="'.route('journeys.show', $journey).'"', false)
            ->assertDontSee('href="'.route('places.show', $hidden).'"', false);

        $this->get('/ar')->assertOk()->assertSee('حكاية جديدة عن العراق')
            ->assertSee('وجهة جديدة')->assertSee('رحلة جديدة')
            ->assertSee('href="'.route('places.show.locale', [$place, 'ar']).'"', false)
            ->assertSee('href="'.route('journeys.show.locale', [$journey, 'ar']).'"', false);
    }

    public function test_public_page_links_and_fragment_targets_resolve_in_both_languages(): void
    {
        $this->seed();
        $urls = [route('home'), route('home.locale', 'ar')];
        foreach (Place::published()->get() as $place) {
            $urls[] = route('places.show', $place);
            $urls[] = route('places.show.locale', [$place, 'ar']);
        }
        foreach (Journey::published()->get() as $journey) {
            $urls[] = route('journeys.show', $journey);
            $urls[] = route('journeys.show.locale', [$journey, 'ar']);
        }
        $cache = [];
        foreach ($urls as $url) {
            $response = $this->get($url)->assertOk();
            $document = $this->document($response->getContent());
            $xpath = new DOMXPath($document);
            $this->assertSame(1, $xpath->query('//*[@id="top"]')->length, $url);
            $this->assertSame(1, $xpath->query('//a[@data-language-toggle and @href]')->length, $url);
            foreach ($xpath->query('//a[@href]') as $link) {
                $href = $link->getAttribute('href');
                if (str_starts_with($href, '#')) {
                    $target = $url.$href;
                } elseif (parse_url($href, PHP_URL_HOST) === parse_url($url, PHP_URL_HOST)) {
                    $target = $href;
                } else {
                    continue;
                }
                $path = parse_url($target, PHP_URL_PATH) ?: '/';
                if (str_starts_with($path, '/admin') || $path === '/profile') {
                    continue;
                }
                if (! isset($cache[$path])) {
                    $cache[$path] = $this->get($path)->assertOk()->getContent();
                }
                $fragment = parse_url($target, PHP_URL_FRAGMENT);
                if ($fragment) {
                    $targetXpath = new DOMXPath($this->document($cache[$path]));
                    $this->assertSame(1, $targetXpath->query('//*[@id="'.$fragment.'"]')->length, $url.' -> '.$href);
                }
            }
        }
    }

    public function test_contact_action_is_available_only_with_configured_email(): void
    {
        $this->seed();
        $journey = Journey::published()->firstOrFail();
        config(['site.contact_email' => null]);
        $this->get(route('journeys.show', $journey))->assertOk()
            ->assertDontSee('mailto:')
            ->assertSee('Contact and booking details will be announced soon.');

        config(['site.contact_email' => 'travel@example.com']);
        $this->get(route('journeys.show.locale', [$journey, 'ar']))->assertOk()
            ->assertSee('mailto:travel@example.com?subject='.rawurlencode('Inquiry for journey: '.$journey->title_ar), false)
            ->assertSee('استفسر عن هذه الرحلة');
        $this->get('/')->assertOk()->assertSee('href="mailto:travel@example.com"', false);
    }

    private function document(string $html): DOMDocument
    {
        $document = new DOMDocument;
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="UTF-8">'.$html);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        return $document;
    }
}
