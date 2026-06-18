@props([
    'id' => null,
    'label' => null,
    'checked' => false,
])

@php
$id = $id ?? 'checkbox-' . Str::random(8);
@endphp

<label for="{{ $id }}" class="flex items-center gap-3 cursor-pointer group">
    <input
        type="checkbox"
        id="{{ $id }}"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'h-5 w-5 rounded border-2 border-green-600 text-[var(--primary)] focus:ring-green-600 focus:ring-offset-0 cursor-pointer transition-colors']) }}
    />
    @if ($label)
        <span class="text-sm text-[var(--foreground)] group-hover:text-[var(--primary)] transition-colors">
            {{ $label }}
        </span>
    @endif
    {{ $slot }}
</label>
