<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicMediaController extends Controller
{
    public function __invoke(string $path): BinaryFileResponse
    {
        abort_unless(config('filesystems.public_media_fallback'), 404);
        // Resolve both paths to reject traversal and symlinks outside the public disk.
        $root = realpath(Storage::disk('public')->path(''));
        $file = realpath(Storage::disk('public')->path($path));
        abort_unless($root && $file && str_starts_with($file, $root.DIRECTORY_SEPARATOR) && is_file($file), 404);
        $types = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp', 'gif' => 'image/gif', 'bmp' => 'image/bmp'];
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        abort_unless(isset($types[$extension]), 404);
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file);
        abort_unless($mime === $types[$extension] || ($extension === 'bmp' && $mime === 'image/x-ms-bmp'), 404);

        return response()->file($file, [
            'Content-Type' => $mime,
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
