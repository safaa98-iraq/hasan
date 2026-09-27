<x-admin-layout>
    <div class="admin-page-title admin-page-title-stacked">
        <h1>{{ __('Edit category') }} — {{ $category->title }}</h1>
        <a href="{{ admin_route('admin.categories.index') }}" class="admin-back-link">{{ __('← Back to categories') }}</a>
    </div>

    <form method="POST" action="{{ admin_route('admin.categories.update', $category) }}" class="admin-card admin-form-card">
        @csrf @method('PATCH')
        @include('admin.categories._form')
    </form>
</x-admin-layout>