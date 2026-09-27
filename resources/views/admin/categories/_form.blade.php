<div class="space-y-6">
    <div class="grid gap-5 sm:grid-cols-[7rem_8rem_1fr]">
        <x-admin.input name="order" label="Order" type="number" min="0" :value="old('order', $category->order ?? 1)" required />
        <x-admin.input name="roman_numeral" label="Numeral" help="e.g. I, II, III" :value="old('roman_numeral', $category->roman_numeral) ?? $category->numeral" />
        <x-admin.input name="title_en" label="Title (English)" :value="old('title_en', $category->title_en)" required />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.input name="title_ar" label="Title (Arabic)" :value="old('title_ar', $category->title_ar)" />
        <x-admin.input name="slug" label="Slug" help="Leave blank to auto-generate." :value="old('slug', $category->slug)" />
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.textarea name="description_en" label="Description (English)" rows="5" :value="old('description_en', $category->description_en)" />
        <x-admin.textarea name="description_ar" label="Description (Arabic)" rows="5" :value="old('description_ar', $category->description_ar)" />
    </div>

    <div class="admin-form-actions">
        <button type="submit" class="btn btn-primary">{{ __('Save category') }}</button>
        <a href="{{ admin_route('admin.categories.index') }}" class="btn btn-outline">{{ __('Cancel') }}</a>
    </div>
</div>