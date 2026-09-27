<section aria-labelledby="profile-information-title">
    <header class="account-section-heading">
        <p class="account-eyebrow">{{ __('Personal details') }}</p>
        <h2 id="profile-information-title">{{ __('Profile information') }}</h2>
        <p>{{ __('Update your name and email address.') }}</p>
    </header>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <form method="post" action="{{ route('profile.update') }}" class="account-form">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="name" value="Name" />
            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label for="email" value="Email address" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <p class="account-help">{{ __('Your email address is unverified.') }} <button type="submit" form="send-verification" class="account-link">{{ __('Resend verification email') }}</button></p>
                @if (session('status') === 'verification-link-sent')
                    <x-auth-session-status status="A new verification link has been sent to your email address." />
                @endif
            @endif
        </div>
        <div class="account-actions">
            <x-primary-button>{{ __('Save profile') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p class="account-saved" role="status">{{ __('Profile saved.') }}</p>
            @endif
        </div>
    </form>
</section>
