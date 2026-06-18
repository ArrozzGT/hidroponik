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

<div>
    @if ($label)
        <label for="{{ $id }}" class="block text-sm font-semibold text-[var(--foreground)] mb-1.5">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        @if ($icon)
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[var(--muted-foreground)]">
                <i data-lucide="{{ $icon }}" class="h-5 w-5" aria-hidden="true"></i>
            </div>
        @endif

        <select
            id="{{ $id }}"
            {{ $attributes->merge([
                'class' => 'w-full rounded-xl border-2 border-green-200 bg-white text-sm h-12 px-3 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 appearance-none cursor-pointer ' . ($icon ? 'pl-10 ' : ''),
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

        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-[var(--muted-foreground)] pointer-events-none">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>

    @if ($error)
        <p class="mt-1 text-xs font-semibold text-red-600">{{ $error }}</p>
    @endif
</div>
