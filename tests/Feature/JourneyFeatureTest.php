<?php

namespace Tests\Feature;

use App\Models\Journey;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JourneyFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_journey_links_and_prices(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('/journeys/between-rivers-and-revelation');
        $response->assertSee('$1,850');
        $response->assertSee('Between Rivers');
    }

    public function test_journey_detail_page_renders_with_prices_photos_and_texts(): void
    {
        $this->seed();

        $response = $this->get('/journeys/between-rivers-and-revelation');

        $response->assertStatus(200);
        $response->assertSee('$1,850 / person');
        $response->assertSee('8 Days / 7 Nights');
        $response->assertSee('Six stops from the Abbasid heart of Baghdad');
        $response->assertSee('Baghdad');
        $response->assertSee('Babylon');
        $response->assertSee('What is Included');
        $response->assertSee('Journey Gallery');
    }

    public function test_arabic_journey_detail_page_renders_rtl_and_arabic_content(): void
    {
        $this->seed();

        $response = $this->get('/journeys/between-rivers-and-revelation/ar');

        $response->assertStatus(200);
        $response->assertSee('dir="rtl"', false);
        $response->assertSee('بين النهرين والوحي', false);
        $response->assertSee('1,850$ للشخص', false);
        $response->assertSee('الرحلة تشمل', false);
        $response->assertSee('معرض صور الرحلة', false);
    }

    public function test_unpublished_journey_returns_404(): void
    {
        $journey = Journey::create([
            'slug' => 'hidden-journey',
            'title_en' => 'Hidden Journey',
            'order' => 99,
            'is_published' => false,
        ]);

        $this->get('/journeys/hidden-journey')->assertStatus(404);
    }

    public function test_admin_panel_enforces_english_primary_locale(): void
    {
        $this->seed();
        $admin = User::first();

        // Simulate visiting Arabic site first
        $this->get('/ar');

        // Then visiting admin panel
        $response = $this->actingAs($admin)->get('/admin/journeys');

        $response->assertStatus(200);
        $response->assertSee('lang="en"', false);
        $response->assertSee('dir="ltr"', false);
        $response->assertSee('Journeys');
        $response->assertSee('Price / Duration');
    }

    public function test_admin_can_create_journey_with_price_and_details(): void
    {
        $this->seed();
        $admin = User::first();

        $response = $this->actingAs($admin)->post('/admin/journeys', [
            'order' => 3,
            'title_en' => 'Northern Mountain Citadel',
            'title_ar' => 'قلعة الجبال الشمالية',
            'subtitle_en' => 'Kurdish highlands and historic monasteries',
            'subtitle_ar' => 'مرتفعات كردستان والأديرة التاريخية',
            'price_en' => '$1,600 / person',
            'price_ar' => '1,600$ للشخص',
            'duration_en' => '5 Days / 4 Nights',
            'duration_ar' => '5 أيام / 4 ليال',
            'description_en' => 'An adventurous path through northern Iraqi valleys.',
            'description_ar' => 'مسار مشوق عبر وديان شمال العراق.',
            'included_en' => "Mountain lodge stays\n4x4 transport",
            'included_ar' => "إقامة جبلية\nنقل دفع رباعي",
            'is_published' => 1,
        ]);

        $response->assertRedirect('/admin/journeys');

        $this->assertDatabaseHas('journeys', [
            'title_en' => 'Northern Mountain Citadel',
            'price_en' => '$1,600 / person',
            'duration_en' => '5 Days / 4 Nights',
            'is_published' => true,
        ]);
    }
}
