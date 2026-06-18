@props([
    'label' => null,
    'icon' => null,
    'error' => null,
    'help' => null,
    'id' => null,
])

@php
$id = $id ?? 'input-' . Str::random(8);
$hasIcon = $icon !== null;
@endphp

<div {{ $attributes->whereDoesntStartWith('wire:model')->except(['class', 'type', 'placeholder', 'value']) }}>
    @if ($label)
        <label for="{{ $id }}" class="block text-sm font-semibold text-[var(--foreground)] mb-1.5">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        @if ($hasIcon)
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[var(--muted-foreground)]">
                <i data-lucide="{{ $icon }}" class="h-5 w-5" aria-hidden="true"></i>
            </div>
        @endif

        <input
            id="{{ $id }}"
            {{ $attributes->whereStartsWith('wire:model') }}
            {{ $attributes->merge([
                'class' => 'w-full rounded-xl border-2 bg-white text-sm transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-green-600 ' . ($hasIcon ? 'pl-10 ' : '') . ($error ? 'border-red-500 focus:ring-red-500' : 'border-green-200 focus:border-green-600') . ' h-12 px-3',
            ])->except(['label', 'icon', 'error', 'help', 'id']) }}
        />
    </div>

    @if ($help && !$error)
        <p class="mt-1 text-xs text-[var(--muted-foreground)]">{{ $help }}</p>
    @endif

    @if ($error)
        <p class="mt-1 text-xs font-semibold text-red-600">{{ $error }}</p>
    @endif
</div>
