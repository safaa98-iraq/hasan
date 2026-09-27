<div class="space-y-6">
    <div class="grid gap-5 sm:grid-cols-[7rem_1fr_1fr]">
        <x-admin.input name="order" label="Order" type="number" min="0" :value="old('order', $place->order ?? 1)" required />
        <x-admin.input name="slug" label="Slug" help="Leave blank to auto-generate." :value="old('slug', $place->slug)" />
        <x-admin.input name="name_en" label="Name (English)" :value="old('name_en', $place->name_en)" required />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.input name="name_ar" label="Name (Arabic)" :value="old('name_ar', $place->name_ar)" />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.textarea name="excerpt_en" label="Excerpt (English)" rows="3" :value="old('excerpt_en', $place->excerpt_en)" />
        <x-admin.textarea name="excerpt_ar" label="Excerpt (Arabic)" rows="3" :value="old('excerpt_ar', $place->excerpt_ar)" />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.textarea name="body_en" label="Body (English)" rows="8" :value="old('body_en', $place->body_en)" help="Separate paragraphs with a blank line." />
        <x-admin.textarea name="body_ar" label="Body (Arabic)" rows="8" :value="old('body_ar', $place->body_ar)" help="Separate paragraphs with a blank line." />
    </div>

    <div>
        <label for="image_path" class="admin-label">{{ __('Image') }}</label>
        @if (isset($imageUrl) && $imageUrl)
            <div class="admin-media-preview">
                <img src="{{ $imageUrl }}" alt="{{ $place->name_en }}">
                <a href="{{ $imageUrl }}" class="admin-link" target="_blank" rel="noopener">{{ __('View current image') }}</a>
            </div>
        @endif
        <input id="image_path" name="image_path" type="file" accept="image/*"
               class="admin-input" aria-describedby="image-help" @error('image_path') aria-invalid="true" @enderror>
        <p id="image-help" class="admin-field-help">{{ __('Upload a JPG, PNG, WebP or GIF image up to 2 MB.') }}</p>
        @error('image_path')
            <p class="admin-field-error">{{ $message }}</p>
        @enderror
    </div>

    <label class="admin-checkbox-label">
        <input type="hidden" name="is_published" value="0">
        <input type="checkbox" name="is_published" value="1" @if (old('is_published', $place->is_published ?? false)) checked @endif
               class="rounded admin-border admin-text ">
        {{ __('Published') }}
    </label>

    <div class="admin-form-actions">
        <button type="submit" class="btn btn-primary">{{ __('Save place') }}</button>
        <a href="{{ admin_route('admin.places.index') }}" class="btn btn-outline">{{ __('Cancel') }}</a>
    </div>
</div>