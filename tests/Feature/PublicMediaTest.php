<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicMediaTest extends TestCase
{
    public function test_public_image_can_be_served_without_a_symlink(): void
    {
        config(['filesystems.public_media_fallback' => true]);
        Storage::fake('public');
        $path = UploadedFile::fake()->image('photo.jpg')->store('atlas', 'public');
        $this->get('/storage/'.$path)->assertOk()->assertHeader('Content-Type', 'image/jpeg');
    }

    public function test_php_disguised_images_and_private_symlinks_are_rejected(): void
    {
        config(['filesystems.public_media_fallback' => true]);
        Storage::fake('public');
        Storage::fake('local');
        Storage::disk('public')->put('probe.php', '<?php echo "never";');
        Storage::disk('public')->put('probe.jpg', '<?php echo "never";');
        Storage::disk('local')->put('secret.jpg', UploadedFile::fake()->image('secret.jpg')->getContent());
        symlink(Storage::disk('local')->path('secret.jpg'), Storage::disk('public')->path('outside.jpg'));
        foreach (['probe.php', 'probe.jpg', 'outside.jpg', 'missing.jpg', '%2e%2e/private/secret.jpg'] as $path) {
            $this->get('/storage/'.$path)->assertNotFound();
        }
    }

    public function test_fallback_is_disabled_by_default(): void
    {
        config(['filesystems.public_media_fallback' => false]);
        Storage::fake('public');
        $path = UploadedFile::fake()->image('photo.jpg')->store('atlas', 'public');
        $this->get('/storage/'.$path)->assertNotFound();
    }
}
