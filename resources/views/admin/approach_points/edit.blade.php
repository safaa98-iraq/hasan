<x-admin-layout>
    <div class="admin-page-title admin-page-title-stacked">
        <h1>{{ __('Edit approach point') }} — {{ $point->title }}</h1>
        <a href="{{ admin_route('admin.approach-points.index') }}" class="admin-back-link">{{ __('← Back to approach points') }}</a>
    </div>

    <form method="POST" action="{{ admin_route('admin.approach-points.update', $point) }}" class="admin-card admin-form-card">
        @csrf @method('PATCH')
        @include('admin.approach_points._form')
    </form>
</x-admin-layout>