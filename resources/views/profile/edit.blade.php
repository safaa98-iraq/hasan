<x-account-layout title="Your profile">
    <header class="account-page-heading">
        <p class="account-eyebrow">{{ __('Meso Travels account') }}</p>
        <h1>{{ __('Your profile') }}</h1>
        <p>{{ __('Manage your personal details, password and account preferences.') }}</p>
    </header>
    <div class="account-profile-grid">
        <div class="account-panel">@include('profile.partials.update-profile-information-form')</div>
        <div class="account-panel">@include('profile.partials.update-password-form')</div>
        <div class="account-panel account-panel-danger">@include('profile.partials.delete-user-form')</div>
    </div>
</x-account-layout>
