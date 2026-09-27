<x-guest-layout>
    <x-slot name="title">{{ __('Sign in') }}</x-slot>
    <x-slot name="description">{{ __('Welcome back. Sign in to manage your Meso Travels account.') }}</x-slot>
    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="account-form">
        @csrf
        <div>
            <x-input-label for="email" value="Email address" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" :aria-invalid="$errors->has('email') ? 'true' : 'false'" aria-describedby="email-errors" />
            <x-input-error id="email-errors" :messages="$errors->get('email')" />
        </div>
        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" :aria-invalid="$errors->has('password') ? 'true' : 'false'" aria-describedby="password-errors" />
            <x-input-error id="password-errors" :messages="$errors->get('password')" />
        </div>
        <label class="account-remember" for="remember_me">
            <input type="checkbox" name="remember" id="remember_me" @checked(old('remember'))>
            <span>{{ __('Keep me signed in') }}</span>
        </label>
        <x-primary-button class="account-button-full">{{ __('Sign in') }} <span aria-hidden="true">→</span></x-primary-button>
        <div class="account-form-links">
            @if (Route::has('password.request'))
                <a class="account-link" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
            @endif
            @if (config('site.registration_enabled'))
                <a class="account-link" href="{{ route('register') }}">{{ __('Create an account') }}</a>
            @endif
        </div>
    </form>
</x-guest-layout>
