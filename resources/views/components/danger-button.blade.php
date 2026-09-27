<button {{ $attributes->merge(['type' => 'submit', 'class' => 'account-button account-button-danger']) }}>
    {{ $slot }}
</button>
