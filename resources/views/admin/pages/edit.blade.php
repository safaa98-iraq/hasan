<x-admin-layout>
    <div class="admin-page-title admin-page-title-stacked">
        <h1>{{ __('Edit site copy') }}</h1>
        <a href="{{ admin_route('admin.pages.index') }}" class="admin-back-link">{{ __('← Back to site copy') }}</a>
        <p class="mt-2"><code class="rounded bg-white px-1.5 py-0.5 text-xs admin-muted ring-1 admin-ring">{{ $page->key }}</code></p>
    </div>

    <form method="POST" action="{{ admin_route('admin.pages.update', $page) }}" enctype="multipart/form-data" class="admin-card admin-form-card">
        @csrf @method('PATCH')
        <div class="space-y-6">
            <div class="grid gap-5 md:grid-cols-2">
                <x-admin.input name="title_en" label="Title (English)" :value="old('title_en', $page->title_en)" />
                <x-admin.input name="title_ar" label="Title (Arabic)" :value="old('title_ar', $page->title_ar)" />
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <x-admin.textarea name="body_en" label="Body (English)" rows="6" :value="old('body_en', $page->body_en)" help="Separate paragraphs with a blank line." />
                <x-admin.textarea name="body_ar" label="Body (Arabic)" rows="6" :value="old('body_ar', $page->body_ar)" help="Separate paragraphs with a blank line." />
            </div>

            <div>
                <label for="image_path" class="admin-label">{{ __('Image') }}</label>
                @if ($imageUrl)
                    <div class="admin-media-preview">
                        <img src="{{ $imageUrl }}" alt="">
                        <span class="text-xs admin-muted">{{ $page->image_path }}</span>
                    </div>
                @endif
                <input id="image_path" name="image_path" type="file" accept="image/*"
                       class="admin-input" aria-describedby="image-help" @error('image_path') aria-invalid="true" @enderror>
                <p id="image-help" class="admin-field-help">{{ __('Upload a JPG, PNG, WebP or GIF image up to 4 MB.') }}</p>
                @error('image_path')
                    <p class="admin-field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="btn btn-primary">{{ __('Save page') }}</button>
                <a href="{{ admin_route('admin.pages.index') }}" class="btn btn-outline">{{ __('Cancel') }}</a>
            </div>
        </div>
    </form>
</x-admin-layout>