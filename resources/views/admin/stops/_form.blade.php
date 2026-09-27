<div class="space-y-6">
    <div class="grid gap-5 sm:grid-cols-[6rem_1fr]">
        <x-admin.input name="order" label="Order" type="number" min="0" :value="old('order', $stop->order ?? ($journey->stops->max('order') ?? 0) + 1)" required />
        <x-admin.input name="name_en" label="Name (English)" :value="old('name_en', $stop->name_en)" required />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.input name="name_ar" label="Name (Arabic)" :value="old('name_ar', $stop->name_ar)" />
        <x-admin.input name="label_en" label="Label (English)" help="e.g. Arrive, Ancient city, Sacred heritage" :value="old('label_en', $stop->label_en)" />
        <x-admin.input name="label_ar" label="Label (Arabic)" :value="old('label_ar', $stop->label_ar)" />
    </div>

    <div>
        <label for="place_id" class="admin-label">{{ __('Linked place') }}</label>
        <select id="place_id" name="place_id" class="admin-input">
            <option value="">{{ __('— None —') }}</option>
            @foreach ($places as $place)
                <option value="{{ $place->id }}" @if (old('place_id', $stop->place_id) == $place->id) selected @endif>{{ $place->name }}</option>
            @endforeach
        </select>
        @error('place_id')
            <p class="mt-1 text-xs admin-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.textarea name="description_en" label="Stop Description (English)" rows="4" :value="old('description_en', $stop->description_en)" />
        <x-admin.textarea name="description_ar" label="Stop Description (Arabic)" rows="4" :value="old('description_ar', $stop->description_ar)" />
    </div>

    <div>
        <label for="image_path" class="admin-label">{{ __('Stop Photo') }}</label>
        @if ($stop->image_path)
            <div class="admin-media-preview">
                <img src="{{ site_image_url($stop->image_path) }}" alt="{{ $stop->name_en }}">
                <a href="{{ site_image_url($stop->image_path) }}" target="_blank" rel="noopener" class="admin-link text-xs">{{ __('View current photo') }}</a>
            </div>
        @endif
        <input id="image_path" name="image_path" type="file" accept="image/*"
               class="admin-input" aria-describedby="image-help" @error('image_path') aria-invalid="true" @enderror>
        <p id="image-help" class="admin-field-help">{{ __('Upload a JPG, PNG, WebP or GIF image up to 3 MB.') }}</p>
        @error('image_path')
            <p class="admin-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="admin-form-actions">
        <button type="submit" class="btn btn-primary">{{ __('Save stop') }}</button>
        <a href="{{ admin_route('admin.journeys.edit', $journey) }}" class="btn btn-outline">{{ __('Cancel') }}</a>
    </div>
</div>