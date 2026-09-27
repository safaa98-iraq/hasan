<?php

namespace Tests\Feature;

use App\Models\Place;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DashboardUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploads_use_unique_names_and_detected_extensions_and_survive_text_edits(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->dashboardAdmin()->create());
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+jRz0AAAAASUVORK5CYII=');
        $paths = [];
        foreach ([1, 2] as $number) {
            $this->post('/admin/places', [
                'name_en' => 'Destination '.$number,
                'order' => $number,
                'image_path' => UploadedFile::fake()->createWithContent('same-name.jpg', $png)->mimeType('image/png'),
            ])->assertSessionHasNoErrors()->assertRedirect(route('admin.places.index'));
            $place = Place::where('slug', 'destination-'.$number)->firstOrFail();
            $paths[] = $place->image_path;
            $this->assertStringEndsWith('.png', $place->image_path);
            Storage::disk('public')->assertExists($place->image_path);
        }
        $this->assertNotSame($paths[0], $paths[1]);
        $place = Place::first();
        $this->put(route('admin.places.update', $place), ['name_en' => 'Renamed', 'order' => 1])->assertSessionHasNoErrors();
        $this->assertSame($paths[0], $place->fresh()->image_path);
    }
}
