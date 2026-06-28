@props([
    'label' => null,
    'icon' => null,
    'error' => null,
    'placeholder' => 'Pilih...',
    'id' => null,
    'options' => [],
])

@php
$id = $id ?? 'select-' . Str::random(8);
@endphp

<div class="space-y-1.5">
    @if ($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        @if ($icon)
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                <i data-lucide="{{ $icon }}" class="h-4 w-4" aria-hidden="true"></i>
            </div>
        @endif

        <select
            id="{{ $id }}"
            {{ $attributes->merge([
                'class' => 'block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:border-emerald-400 focus:ring-1 focus:ring-emerald-400 focus:ring-offset-0 transition-colors appearance-none ' . ($icon ? 'pl-9 ' : ''),
            ]) }}
        >
            @if ($placeholder)
                <option value="" disabled selected>{{ $placeholder }}</option>
            @endif
            @foreach ($options as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
            {{ $slot }}
        </select>

        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>

    @if ($error)
        <p class="text-xs text-red-600 mt-1">{{ $error }}</p>
    @endif
</div>
