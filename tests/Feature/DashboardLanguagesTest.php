<?php

namespace Tests\Feature;

use App\Models\Journey;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardLanguagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_existing_account_types_use_the_shared_login_and_dashboard(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
        $this->get('/login')->assertOk()->assertDontSee('Arabic sign-in');
        foreach ([null, 'en', 'ar'] as $locale) {
            $user = User::factory()->create(['dashboard_locale' => $locale]);
            $this->post('/login', ['email' => $user->email, 'password' => 'password'])->assertRedirect();
            $this->assertAuthenticatedAs($user);
            $this->get('/dashboard')->assertRedirect(route('admin.dashboard'));
            $this->get('/admin')->assertOk()->assertSee('Quick tip')->assertSee('data-theme-toggle', false);
            $this->post('/logout')->assertRedirect('/');
            $this->assertGuest();
        }
    }

    public function test_old_language_bookmarks_redirect_to_shared_routes(): void
    {
        foreach (['en', 'ar'] as $locale) {
            $this->get('/admin/'.$locale.'/login')->assertRedirect(route('login'));
            $this->get('/admin/'.$locale)->assertRedirect(route('admin.dashboard'));
            $this->get('/admin/'.$locale.'/places')->assertRedirect(route('admin.places.index'));
        }
    }

    public function test_shared_dashboard_renders_forms_and_saves_both_languages(): void
    {
        $this->seed();
        $journey = Journey::first();
        $this->actingAs(User::factory()->create());
        foreach (['', '/places', '/places/create', '/journeys', '/journeys/create', '/journeys/'.$journey->slug.'/edit', '/journeys/'.$journey->slug.'/stops/create', '/categories', '/categories/create', '/approach-points', '/approach-points/create', '/pages', '/pages/'.Page::where('key', 'hero_heading')->value('id').'/edit', '/settings/contact'] as $path) {
            $this->get('/admin'.$path)->assertOk()->assertSee('lang="en"', false)->assertSee('meso-theme.js')->assertSee('data-theme-toggle', false)->assertSee('Quick tip');
        }
        $this->get('/admin/categories/create')->assertSee('name="title_en"', false)->assertSee('name="title_ar"', false);
        $this->post('/admin/categories', ['title_en' => 'Test category', 'title_ar' => 'تصنيف جديد', 'order' => 8])->assertSessionHasNoErrors()->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['title_en' => 'Test category', 'title_ar' => 'تصنيف جديد']);
    }

    public function test_both_public_contact_emails_are_managed_together(): void
    {
        $this->actingAs(User::factory()->create());
        $this->get('/admin/settings/contact')->assertOk()->assertSee('name="email_en"', false)->assertSee('name="email_ar"', false);
        $this->put('/admin/settings/contact', ['email_en' => 'english@example.com', 'email_ar' => 'arabic@example.com'])->assertSessionHasNoErrors()->assertRedirect(route('admin.settings.edit'));
        $this->assertDatabaseHas('pages', ['key' => 'contact_email', 'title_en' => 'english@example.com', 'title_ar' => 'arabic@example.com']);
        $this->get('/')->assertOk()->assertSee('mailto:english@example.com')->assertDontSee('mailto:arabic@example.com');
        $this->get('/ar')->assertOk()->assertSee('mailto:arabic@example.com')->assertDontSee('mailto:english@example.com');
        $this->put('/admin/settings/contact', ['email_en' => 'invalid', 'email_ar' => 'arabic@example.com'])->assertSessionHasErrors('email_en');
        $this->assertDatabaseHas('pages', ['key' => 'contact_email', 'title_en' => 'english@example.com']);
        $this->put('/admin/settings/contact', ['email_en' => '', 'email_ar' => 'arabic@mesotravels.test'])->assertSessionHasNoErrors();
        config(['site.contact_email_ar' => 'configured-arabic@example.com']);
        $this->get('/ar')->assertDontSee('mailto:arabic@mesotravels.test')->assertSee('mailto:configured-arabic@example.com');
    }

    public function test_registration_is_closed_by_default(): void
    {
        config(['site.registration_enabled' => false]);
        $this->get('/register')->assertNotFound();
        $this->post('/register', ['name' => 'Test', 'email' => 'blocked@example.com', 'password' => 'password', 'password_confirmation' => 'password'])->assertNotFound();
        $this->assertDatabaseMissing('users', ['email' => 'blocked@example.com']);
    }
}
