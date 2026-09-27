<x-admin-layout>
    <div class="admin-page-title admin-page-title-stacked">
        <h1>{{ __('Site copy') }}</h1>
        <p class="admin-page-description">{{ __('Manage the bilingual headlines, descriptions, contact details and labels configured for the public site.') }}</p>
    </div>

    <div class="admin-card admin-table-wrap" tabindex="0" role="region" aria-label="{{ __('Content list') }}">
        <table class="w-full text-left text-sm">
            <thead class="border-b admin-border admin-surface text-xs uppercase tracking-wider admin-muted">
                <tr>
                    <th class="px-4 py-3">{{ __('Key') }}</th>
                    <th class="px-4 py-3">{{ __('Title') }}</th>
                    <th class="px-4 py-3">{{ __('Has body') }}</th>
                    <th class="px-4 py-3">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y admin-border">
                @foreach ($pages as $page)
                    <tr class="">
                        <td class="px-4 py-3"><code class="rounded admin-surface px-1.5 py-0.5 text-xs admin-muted">{{ $page->key }}</code></td>
                        <td class="px-4 py-3 font-medium admin-text">{{ Str::limit($page->title, 80) }}</td>
                        <td class="px-4 py-3 admin-muted">{{ $page->body ? __('Yes') : '—' }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ admin_route('admin.pages.edit', $page) }}" class="btn btn-outline btn-sm">{{ __('Edit') }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>