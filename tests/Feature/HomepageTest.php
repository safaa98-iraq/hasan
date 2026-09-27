<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_returns_200_and_renders_the_hero_heading_from_the_database(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Come closer.');
        $response->assertSee('Iraq has stories to tell.');
        $response->assertSee('Explore the first journey');
    }

    public function test_arabic_homepage_renders_rtl_and_localized_copy(): void
    {
        $this->seed();

        $response = $this->get('/ar');

        $response->assertStatus(200);
        $response->assertSee('اقترب أكثر.', false);
        $response->assertSee('dir="rtl"', false);
    }

    public function test_published_place_detail_page_renders(): void
    {
        $this->seed();

        $response = $this->get('/places/baghdad');

        $response->assertStatus(200);
        $response->assertSee('Baghdad begins with the Tigris.');
    }

    public function test_unpublished_place_detail_page_returns_404(): void
    {
        $this->seed();

        $unpublished = \App\Models\Place::factory()->create(['is_published' => false, 'order' => 99]);

        $this->get("/places/{$unpublished->slug}")->assertStatus(404);
    }
}