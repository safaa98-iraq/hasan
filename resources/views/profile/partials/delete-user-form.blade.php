<section aria-labelledby="delete-account-title">
    <header class="account-section-heading">
        <p class="account-eyebrow">{{ __('Account management') }}</p>
        <h2 id="delete-account-title">{{ __('Delete account') }}</h2>
        <p>{{ __('Deleting your account is permanent. Save any information you wish to keep before continuing.') }}</p>
    </header>
    <x-danger-button type="button" x-data="" x-on:click="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete account') }}</x-danger-button>
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" aria-labelledby="delete-account-confirmation" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="account-modal-form account-form">
            @csrf
            @method('delete')
            <header class="account-section-heading">
                <h2 id="delete-account-confirmation">{{ __('Delete your account?') }}</h2>
                <p>{{ __('Enter your password to confirm the permanent deletion of your account. This action cannot be undone.') }}</p>
            </header>
            <div>
                <x-input-label for="delete_account_password" value="Password" />
                <x-text-input id="delete_account_password" name="password" type="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->userDeletion->get('password')" />
            </div>
            <div class="account-actions account-actions-end">
                <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                <x-danger-button>{{ __('Delete account') }}</x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
