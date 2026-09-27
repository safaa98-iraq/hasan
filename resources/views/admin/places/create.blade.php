<x-admin-layout>
    <div class="admin-page-title admin-page-title-stacked">
        <h1>{{ __('New place') }}</h1>
        <a href="{{ admin_route('admin.places.index') }}" class="admin-back-link">{{ __('← Back to places') }}</a>
    </div>

    <form method="POST" action="{{ admin_route('admin.places.store') }}" enctype="multipart/form-data" class="admin-card admin-form-card">
        @csrf
        @include('admin.places._form')
    </form>
</x-admin-layout>