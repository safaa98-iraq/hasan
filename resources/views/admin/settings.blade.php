<x-admin-layout>
    <div class="admin-page-title"><h1>{{ __('Contact settings') }}</h1></div>
    <form class="admin-card admin-form-card" method="POST" action="{{ admin_route('admin.settings.update') }}">
        @csrf @method('PUT')
        <x-admin.input name="email_en" type="email" label="Contact email (English)" :value="$email_en" help="Shown on the English public pages. Leave blank to use the environment setting." />
        <x-admin.input name="email_ar" type="email" label="Contact email (Arabic)" :value="$email_ar" help="Shown on the Arabic public pages. Leave blank to use the environment setting." />
        <p class="admin-field-help">{{ __('Use a working mailbox you own. Addresses ending in .test are examples and do not activate public email links.') }}</p>
        <div class="admin-form-actions"><button class="btn btn-primary" type="submit">{{ __('Save contact email') }}</button></div>
    </form>
</x-admin-layout>
