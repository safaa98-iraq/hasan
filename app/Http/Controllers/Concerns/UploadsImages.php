<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

trait UploadsImages
{
    /**
     * Store an uploaded image on the public disk and return its path,
     * or null when no file was uploaded.
     */
    protected function storeImage(Request $request, string $directory, ?string $current = null): ?string
    {
        if (! $request->hasFile('image_path')) {
            return $current;
        }

        $file = $request->file('image_path');
        $extension = $file->extension();
        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'], true)) {
            throw ValidationException::withMessages(['image_path' => __('Please upload a JPG, PNG, WebP, GIF or BMP image.')]);
        }
        $path = $file->storeAs('images/'.$directory, Str::uuid().'.'.$extension, 'public');
        if (! $path) {
            throw ValidationException::withMessages(['image_path' => __('The image could not be saved. Please try again.')]);
        }

        return $path;
    }

    /**
     * Build a URL for an image stored on the public disk.
     */
    protected function imageUrl(?string $path): ?string
    {
        return site_image_url($path);
    }
}
