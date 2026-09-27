<x-admin-layout>
    <div class="admin-page-title admin-page-title-stacked">
        <h1>{{ __('New journey') }}</h1>
        <a href="{{ admin_route('admin.journeys.index') }}" class="admin-back-link">{{ __('← Back to journeys') }}</a>
    </div>

    <form method="POST" action="{{ admin_route('admin.journeys.store') }}" enctype="multipart/form-data" class="admin-card admin-form-card">
        @csrf
        @include('admin.journeys._form')
    </form>
</x-admin-layout>