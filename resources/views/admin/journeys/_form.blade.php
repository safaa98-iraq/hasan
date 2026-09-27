<div class="space-y-6">
    <div class="grid gap-5 sm:grid-cols-[7rem_1fr_1fr]">
        <x-admin.input name="order" label="Order" type="number" min="0" :value="old('order', $journey->order ?? 1)" required />
        <x-admin.input name="title_en" label="Title (English)" :value="old('title_en', $journey->title_en)" required />
        <x-admin.input name="title_ar" label="Title (Arabic)" :value="old('title_ar', $journey->title_ar)" />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.input name="subtitle_en" label="Subtitle (English)" :value="old('subtitle_en', $journey->subtitle_en)" />
        <x-admin.input name="subtitle_ar" label="Subtitle (Arabic)" :value="old('subtitle_ar', $journey->subtitle_ar)" />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.input name="price_en" label="Price (English)" help="e.g. $1,850 / person" :value="old('price_en', $journey->price_en)" />
        <x-admin.input name="price_ar" label="Price (Arabic)" help="e.g. 1,850$ للشخص" :value="old('price_ar', $journey->price_ar)" />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.input name="duration_en" label="Duration (English)" help="e.g. 8 Days / 7 Nights" :value="old('duration_en', $journey->duration_en)" />
        <x-admin.input name="duration_ar" label="Duration (Arabic)" help="e.g. 8 أيام / 7 ليال" :value="old('duration_ar', $journey->duration_ar)" />
    </div>

    <div>
        <label for="image_path" class="admin-label">{{ __('Journey Cover Image') }}</label>
        @if ($journey->image_path)
            <div class="admin-media-preview">
                <img src="{{ site_image_url($journey->image_path) }}" alt="{{ $journey->title_en }}">
                <a href="{{ site_image_url($journey->image_path) }}" target="_blank" rel="noopener" class="admin-link text-xs">{{ __('View current image') }}</a>
            </div>
        @endif
        <input id="image_path" name="image_path" type="file" accept="image/*"
               class="admin-input" aria-describedby="image-help" @error('image_path') aria-invalid="true" @enderror>
        <p id="image-help" class="admin-field-help">{{ __('Upload a JPG, PNG, WebP or GIF image up to 3 MB.') }}</p>
        @error('image_path')
            <p class="admin-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.textarea name="description_en" label="Description / Overview (English)" rows="6" :value="old('description_en', $journey->description_en)" help="Separate paragraphs with a blank line." />
        <x-admin.textarea name="description_ar" label="Description / Overview (Arabic)" rows="6" :value="old('description_ar', $journey->description_ar)" help="Separate paragraphs with a blank line." />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.textarea name="included_en" label="What is Included (English)" rows="5" :value="old('included_en', $journey->included_en)" help="One item per line." />
        <x-admin.textarea name="included_ar" label="What is Included (Arabic)" rows="5" :value="old('included_ar', $journey->included_ar)" help="One item per line." />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.textarea name="excluded_en" label="Not Included (English)" rows="4" :value="old('excluded_en', $journey->excluded_en)" help="One item per line." />
        <x-admin.textarea name="excluded_ar" label="Not Included (Arabic)" rows="4" :value="old('excluded_ar', $journey->excluded_ar)" help="One item per line." />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.input name="slug" label="Slug" help="Leave blank to auto-generate." :value="old('slug', $journey->slug)" />
    </div>

    <label class="admin-checkbox-label">
        <input type="hidden" name="is_published" value="0">
        <input type="checkbox" name="is_published" value="1" @if (old('is_published', $journey->is_published ?? false)) checked @endif
               class="rounded admin-border admin-text ">
        {{ __('Published') }}
    </label>

    <div class="admin-form-actions">
        <button type="submit" class="btn btn-primary">{{ __('Save journey') }}</button>
        <a href="{{ admin_route('admin.journeys.index') }}" class="btn btn-outline">{{ __('Cancel') }}</a>
    </div>
</div>