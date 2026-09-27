<section aria-labelledby="update-password-title">
    <header class="account-section-heading">
        <p class="account-eyebrow">{{ __('Account security') }}</p>
        <h2 id="update-password-title">{{ __('Update password') }}</h2>
        <p>{{ __('Use a long, unique password to keep your account secure.') }}</p>
    </header>
    <form method="post" action="{{ route('password.update') }}" class="account-form">
        @csrf
        @method('put')
        <div>
            <x-input-label for="update_password_current_password" value="Current password" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>
        <div>
            <x-input-label for="update_password_password" value="New password" />
            <x-text-input id="update_password_password" name="password" type="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" />
        </div>
        <div>
            <x-input-label for="update_password_password_confirmation" value="Confirm new password" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>
        <div class="account-actions">
            <x-primary-button>{{ __('Save password') }}</x-primary-button>
            @if (session('status') === 'password-updated')
                <p class="account-saved" role="status">{{ __('Password updated.') }}</p>
            @endif
        </div>
    </form>
</section>
