<button {{ $attributes->merge(['type' => 'submit', 'class' => 'account-button account-button-primary']) }}>
    {{ $slot }}
</button>
