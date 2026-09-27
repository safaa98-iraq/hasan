@props([
    'name' => '',
    'id' => null,
    'label' => null,
    'value' => '',
    'type' => 'text',
    'required' => false,
    'help' => null,
])

@php
    $fieldId = $id ?? $name;
    $descriptionIds = trim(($help ? $fieldId.'-help ' : '').($errors->has($name) ? $fieldId.'-error' : ''));
@endphp

<div class="admin-field">
    @if ($label)
        <label for="{{ $fieldId }}">
            {{ __($label) }}@if ($required) <span class="admin-required" aria-hidden="true">*</span>@endif
        </label>
    @endif
    <input
        id="{{ $fieldId }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        @if ($required) required @endif
        @if ($errors->has($name)) aria-invalid="true" @endif
        @if ($descriptionIds) aria-describedby="{{ $descriptionIds }}" @endif
        {{ $attributes->merge(['class' => 'admin-input', 'dir' => str_ends_with($name, '_ar') ? 'rtl' : 'ltr']) }}
    >
    @if ($help)
        <p id="{{ $fieldId }}-help" class="admin-field-help">{{ __($help) }}</p>
    @endif
    @error($name)
        <p id="{{ $fieldId }}-error" class="admin-field-error">{{ $message }}</p>
    @enderror
</div>
