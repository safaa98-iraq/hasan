<div class="space-y-6">
    <div class="grid gap-5 sm:grid-cols-[7rem_1fr]">
        <x-admin.input name="order" label="Order" type="number" min="0" :value="old('order', $point->order ?? 1)" required />
        <x-admin.input name="title_en" label="Title (English)" :value="old('title_en', $point->title_en)" required />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.textarea name="description_en" label="Description (English)" rows="5" :value="old('description_en', $point->description_en)" />
        <x-admin.textarea name="description_ar" label="Description (Arabic)" rows="5" :value="old('description_ar', $point->description_ar)" />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.input name="title_ar" label="Title (Arabic)" :value="old('title_ar', $point->title_ar)" />
    </div>

    <div class="admin-form-actions">
        <button type="submit" class="btn btn-primary">{{ __('Save approach point') }}</button>
        <a href="{{ admin_route('admin.approach-points.index') }}" class="btn btn-outline">{{ __('Cancel') }}</a>
    </div>
</div>