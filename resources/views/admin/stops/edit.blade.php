<x-admin-layout>
    <div class="admin-page-title admin-page-title-stacked">
        <h1>{{ __('Edit stop') }} — {{ $stop->name }} ({{ $journey->title }})</h1>
        <a href="{{ admin_route('admin.journeys.edit', $journey) }}" class="admin-back-link">{{ __('← Back to journey') }}</a>
    </div>

    <form method="POST" action="{{ admin_route('admin.journeys.stops.update', [$journey, $stop]) }}" enctype="multipart/form-data" class="admin-card admin-form-card">
        @csrf @method('PATCH')
        @include('admin.stops._form')
    </form>
</x-admin-layout>