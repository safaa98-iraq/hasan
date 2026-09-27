<button {{ $attributes->merge(['type' => 'button', 'class' => 'account-button account-button-secondary']) }}>
    {{ $slot }}
</button>
