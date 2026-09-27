@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'account-status', 'role' => 'status']) }}>
        {{ __($status) }}
    </div>
@endif
