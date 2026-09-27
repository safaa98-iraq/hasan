<x-admin-layout>
    <div class="admin-page-title admin-page-title-stacked">
        <h1>{{ __('Edit place') }} — {{ $place->name }}</h1>
        <a href="{{ admin_route('admin.places.index') }}" class="admin-back-link">{{ __('← Back to places') }}</a>
    </div>

    <form method="POST" action="{{ admin_route('admin.places.update', $place) }}" enctype="multipart/form-data" class="admin-card admin-form-card">
        @csrf @method('PATCH')
        @include('admin.places._form', ['imageUrl' => $place->image_path ? site_image_url($place->image_path) : null])
    </form>
</x-admin-layout>