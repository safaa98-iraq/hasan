@props(['value' => null])

<label {{ $attributes->merge(['class' => 'account-label']) }}>
    {{ __((string) ($value ?? $slot)) }}
</label>
