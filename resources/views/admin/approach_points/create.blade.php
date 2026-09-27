<x-admin-layout>
    <div class="admin-page-title admin-page-title-stacked">
        <h1>{{ __('New approach point') }}</h1>
        <a href="{{ admin_route('admin.approach-points.index') }}" class="admin-back-link">{{ __('← Back to approach points') }}</a>
    </div>

    <form method="POST" action="{{ admin_route('admin.approach-points.store') }}" class="admin-card admin-form-card">
        @csrf
        @include('admin.approach_points._form')
    </form>
</x-admin-layout>