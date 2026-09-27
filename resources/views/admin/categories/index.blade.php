<x-admin-layout>
    <div class="admin-page-title">
        <div>
            <h1>{{ __('Categories') }}</h1>
            <p class="admin-page-description">{{ __('The "Ways to see Iraq" cards.') }}</p>
        </div>
        <a href="{{ admin_route('admin.categories.create') }}" class="btn btn-primary btn-sm">{{ __('New category') }}</a>
    </div>

    <div class="admin-card admin-table-wrap" tabindex="0" role="region" aria-label="{{ __('Content list') }}">
        <table class="w-full text-left text-sm">
            <thead class="border-b admin-border admin-surface text-xs uppercase tracking-wider admin-muted">
                <tr>
                    <th class="px-4 py-3">{{ __('Order') }}</th>
                    <th class="px-4 py-3">{{ __('Numeral') }}</th>
                    <th class="px-4 py-3">{{ __('Title') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y admin-border">
                @forelse ($categories as $category)
                    <tr class="">
                        <td class="px-4 py-3">{{ $category->order }}</td>
                        <td class="px-4 py-3 font-semibold admin-text">{{ $category->numeral }}</td>
                        <td class="px-4 py-3 font-medium admin-text">{{ $category->title }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ admin_route('admin.categories.edit', $category) }}" class="btn btn-outline btn-sm">{{ __('Edit') }}</a>
                            <form method="POST" action="{{ admin_route('admin.categories.destroy', $category) }}" class="inline" onsubmit="return confirm(this.dataset.confirm)" data-confirm="{{ __('Delete this category?') }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="ms-3 btn btn-danger btn-sm">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center admin-muted">{{ __('No categories yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>