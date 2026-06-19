@props([
    'trigger' => null,
    'title' => null,
    'side' => 'left',
])

@php
$sideClasses = [
    'left' => 'left-0 rounded-r-xl',
    'right' => 'right-0 rounded-l-xl',
    'top' => 'top-0 w-full',
    'bottom' => 'bottom-0 w-full',
];
@endphp

<div x-data="{ open: false }">
    <div @click="open = true" class="cursor-pointer">
        {{ $trigger ?? $slot }}
    </div>

    <div x-show="open" x-cloak
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 bg-black/20"
        @click="open = false"
    ></div>

    <div x-show="open" x-cloak
        x-transition:enter="transition-transform duration-300 ease-out"
        x-transition:enter-start="{{ $side === 'left' ? '-translate-x-full' : ($side === 'right' ? 'translate-x-full' : ($side === 'top' ? '-translate-y-full' : 'translate-y-full')) }}"
        x-transition:enter-end="translate-x-0 translate-y-0"
        x-transition:leave="transition-transform duration-200 ease-in"
        x-transition:leave-start="translate-x-0 translate-y-0"
        x-transition:leave-end="{{ $side === 'left' ? '-translate-x-full' : ($side === 'right' ? 'translate-x-full' : ($side === 'top' ? '-translate-y-full' : 'translate-y-full')) }}"
        class="fixed z-50 top-0 bottom-0 w-80 max-w-[85vw] bg-white shadow-elegant overflow-y-auto {{ $sideClasses[$side] }}"
    >
        @if ($title)
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <h3 class="text-base font-heading font-semibold text-gray-900">{{ $title }}</h3>
                <button @click="open = false" class="p-1.5 rounded-lg hover:bg-gray-50 transition-colors text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" style="width:18px;height:18px;" aria-hidden="true"></i>
                </button>
            </div>
        @endif

        <div class="p-5">
            {{ $slot }}
        </div>

        @if (!$title)
            <div class="absolute top-4 right-4">
                <button @click="open = false" class="p-1.5 rounded-lg hover:bg-gray-50 transition-colors text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" style="width:18px;height:18px;" aria-hidden="true"></i>
                </button>
            </div>
        @endif
    </div>
</div>
