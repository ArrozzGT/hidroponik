@props([
    'variant' => 'primary',
    'size' => 'default',
    'icon' => null,
    'disabled' => false,
    'href' => null,
])

@php
$base = 'inline-flex items-center justify-center gap-2 font-semibold rounded-xl active:scale-95 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-600 focus-visible:ring-offset-2';

$variants = [
    'primary' => 'bg-[var(--primary)] text-white shadow-lg shadow-green-600/30 hover:bg-green-700',
    'secondary' => 'bg-white text-[var(--foreground)] border shadow-sm hover:bg-green-50',
    'outline' => 'bg-transparent text-[var(--primary)] border-2 border-[var(--primary)] hover:bg-green-50',
    'ghost' => 'text-[var(--foreground)] hover:bg-green-50 hover:text-[var(--primary)]',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 shadow-sm',
];

$sizes = [
    'default' => 'px-5 py-2.5 text-sm',
    'sm' => 'px-3 py-1.5 text-xs',
    'lg' => 'px-6 py-3 text-base',
    'icon' => 'h-10 w-10',
];

$classes = trim("$base $variants[$variant] $sizes[$size]");
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<i data-lucide="{{ $icon }}" class="h-4 w-4" aria-hidden="true"></i>@endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'disabled' => $disabled]) }}>
        @if ($icon)<i data-lucide="{{ $icon }}" class="h-4 w-4" aria-hidden="true"></i>@endif
        {{ $slot }}
    </button>
@endif
