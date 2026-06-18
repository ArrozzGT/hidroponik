@props([
    'trigger' => null,
    'title' => null,
    'side' => 'left',
])

@php
$sideClasses = [
    'left' => 'left-0',
    'right' => 'right-0',
    'top' => 'top-0 w-full',
    'bottom' => 'bottom-0 w-full',
];
@endphp

<div x-data="{ open: false }" {{ $attributes->whereDoesntStartWith('wire:model') }}>
    {{-- Trigger --}}
    <div @click="open = true" class="cursor-pointer">
        {{ $trigger ?? $slot }}
    </div>

    {{-- Overlay --}}
    <div x-show="open" x-cloak
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 bg-black/30 backdrop-blur-sm"
        @click="open = false"
    ></div>

    {{-- Panel --}}
    <div x-show="open" x-cloak
        x-transition:enter="transition-transform duration-300 ease-out"
        x-transition:enter-start="{{ $side === 'left' ? '-translate-x-full' : ($side === 'right' ? 'translate-x-full' : ($side === 'top' ? '-translate-y-full' : 'translate-y-full')) }}"
        x-transition:enter-end="translate-x-0 translate-y-0"
        x-transition:leave="transition-transform duration-200 ease-in"
        x-transition:leave-start="translate-x-0 translate-y-0"
        x-transition:leave-end="{{ $side === 'left' ? '-translate-x-full' : ($side === 'right' ? 'translate-x-full' : ($side === 'top' ? '-translate-y-full' : 'translate-y-full')) }}"
        class="fixed z-50 top-0 bottom-0 w-80 max-w-[85vw] bg-white shadow-2xl overflow-y-auto {{ $sideClasses[$side] }}"
    >
        {{-- Header --}}
        @if ($title)
            <div class="flex items-center justify-between p-5 border-b border-[var(--border)]">
                <h3 class="text-lg font-bold text-[var(--foreground)]">{{ $title }}</h3>
                <button @click="open = false" class="p-2 rounded-xl hover:bg-green-50 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        {{-- Content --}}
        <div class="p-5">
            {{ $slot }}
        </div>

        {{-- Close button when no title --}}
        @if (!$title)
            <div class="absolute top-4 right-4">
                <button @click="open = false" class="p-2 rounded-xl hover:bg-green-50 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif
    </div>
</div>
