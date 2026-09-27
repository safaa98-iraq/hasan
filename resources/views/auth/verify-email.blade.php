<x-guest-layout>
    <x-slot name="title">{{ __('Verify your email') }}</x-slot>
    <x-slot name="description">{{ __('Follow the link in your verification email to confirm your address. You can request a new email below.') }}</x-slot>
    @if (session('status') === 'verification-link-sent')
        <x-auth-session-status status="A new verification link has been sent to your email address." />
    @endif
    <div class="account-form">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="account-button-full">{{ __('Resend verification email') }}</x-primary-button>
        </form>
        <div class="account-form-links">
            <a class="account-link" href="{{ route('profile.edit') }}">{{ __('Update email address') }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="account-link">{{ __('Sign out') }}</button>
            </form>
        </div>
    </div>
</x-guest-layout>
