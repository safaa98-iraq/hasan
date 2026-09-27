<x-guest-layout>
    <x-slot name="title">{{ __('Create an account') }}</x-slot>
    <x-slot name="description">{{ __('Set up your Meso Travels account.') }}</x-slot>
    <form method="POST" action="{{ route('register') }}" class="account-form">
        @csrf
        <div>
            <x-input-label for="name" value="Name" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label for="email" value="Email address" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>
        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>
        <div>
            <x-input-label for="password_confirmation" value="Confirm password" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>
        <x-primary-button class="account-button-full">{{ __('Create account') }}</x-primary-button>
        <p class="account-form-links">{{ __('Already registered?') }} <a class="account-link" href="{{ route('login') }}">{{ __('Sign in') }}</a></p>
    </form>
</x-guest-layout>
