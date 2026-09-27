<x-guest-layout>
    <x-slot name="title">{{ __('Reset your password') }}</x-slot>
    <x-slot name="description">{{ __('Choose a new password for your Meso Travels account.') }}</x-slot>
    <form method="POST" action="{{ route('password.store') }}" class="account-form">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div>
            <x-input-label for="email" value="Email address" />
            <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>
        <div>
            <x-input-label for="password" value="New password" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>
        <div>
            <x-input-label for="password_confirmation" value="Confirm new password" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>
        <x-primary-button class="account-button-full">{{ __('Reset password') }}</x-primary-button>
        <a class="account-link" href="{{ route('login') }}">{{ __('← Back to sign in') }}</a>
    </form>
</x-guest-layout>
