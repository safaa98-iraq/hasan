<x-guest-layout>
    <x-slot name="title">{{ __('Confirm your password') }}</x-slot>
    <x-slot name="description">{{ __('Please confirm your password before continuing to this secure area.') }}</x-slot>
    <form method="POST" action="{{ route('password.confirm') }}" class="account-form">
        @csrf
        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password" name="password" required autofocus autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>
        <x-primary-button class="account-button-full">{{ __('Confirm password') }}</x-primary-button>
        <a class="account-link" href="{{ route('profile.edit') }}">{{ __('← Back to your profile') }}</a>
    </form>
</x-guest-layout>
