<x-guest-layout>
    <x-slot name="title">{{ __('Forgot your password?') }}</x-slot>
    <x-slot name="description">{{ __('Enter your email address and we will send you a link to choose a new password.') }}</x-slot>
    <x-auth-session-status :status="session('status')" />
    <form method="POST" action="{{ route('password.email') }}" class="account-form">
        @csrf
        <div>
            <x-input-label for="email" value="Email address" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" />
        </div>
        <x-primary-button class="account-button-full">{{ __('Send password reset link') }}</x-primary-button>
        <a class="account-link" href="{{ route('login') }}">{{ __('← Back to sign in') }}</a>
    </form>
</x-guest-layout>
