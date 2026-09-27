<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_redirects_to_login_when_unauthenticated(): void
    {
        $this->seed();

        $this->get('/admin')->assertRedirect('/login');
        $this->get('/admin/places')->assertRedirect('/login');
        $this->get('/admin/journeys')->assertRedirect('/login');
        $this->get('/admin/pages')->assertRedirect('/login');
    }

    public function test_authenticated_admin_can_visit_the_dashboard(): void
    {
        $this->seed();

        $user = User::where('email', 'admin@iraqrevealed.test')->firstOrFail();

        $this->actingAs($user)
            ->get('/admin')
            ->assertStatus(200)
            ->assertSee('Dashboard');
    }

    public function test_authenticated_admin_can_create_a_category(): void
    {
        $this->seed();

        $user = User::where('email', 'admin@iraqrevealed.test')->firstOrFail();

        $this->actingAs($user)
            ->post('/admin/categories', [
                'order' => 4,
                'roman_numeral' => 'IV',
                'title_en' => 'Test Category',
                'description_en' => 'Test description',
            ])
            ->assertRedirect('/admin/categories');

        $this->assertDatabaseHas('categories', ['title_en' => 'Test Category']);
    }
}