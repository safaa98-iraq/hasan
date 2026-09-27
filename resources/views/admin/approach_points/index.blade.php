<x-admin-layout>
    <div class="admin-page-title">
        <div>
            <h1>{{ __('Approach points') }}</h1>
            <p class="admin-page-description">{{ __('The three columns in "Travel with context. Leave with connection."') }}</p>
        </div>
        <a href="{{ admin_route('admin.approach-points.create') }}" class="btn btn-primary btn-sm">{{ __('New point') }}</a>
    </div>

    <div class="admin-card admin-table-wrap" tabindex="0" role="region" aria-label="{{ __('Content list') }}">
        <table class="w-full text-left text-sm">
            <thead class="border-b admin-border admin-surface text-xs uppercase tracking-wider admin-muted">
                <tr>
                    <th class="px-4 py-3">{{ __('Order') }}</th>
                    <th class="px-4 py-3">{{ __('Title') }}</th>
                    <th class="px-4 py-3">{{ __('Description') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y admin-border">
                @forelse ($points as $point)
                    <tr class=" align-top">
                        <td class="px-4 py-3">{{ $point->order }}</td>
                        <td class="px-4 py-3 font-medium admin-text">{{ $point->title }}</td>
                        <td class="max-w-md px-4 py-3 admin-muted">{{ Str::limit($point->description, 100) }}</td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="{{ admin_route('admin.approach-points.edit', $point) }}" class="btn btn-outline btn-sm">{{ __('Edit') }}</a>
                            <form method="POST" action="{{ admin_route('admin.approach-points.destroy', $point) }}" class="inline" onsubmit="return confirm(this.dataset.confirm)" data-confirm="{{ __('Delete this approach point?') }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="ms-3 btn btn-danger btn-sm">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center admin-muted">{{ __('No approach points yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>