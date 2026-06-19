@props([
    'variant' => 'primary',
    'size' => 'default',
    'icon' => null,
    'disabled' => false,
    'href' => null,
])

@php
$base = 'inline-flex items-center justify-center gap-2 font-medium rounded-lg transition-colors duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2';

$variants = [
    'primary' => 'bg-emerald-600 text-white hover:bg-emerald-700',
    'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200',
    'outline' => 'border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-50',
    'ghost' => 'text-gray-700 hover:bg-gray-50',
    'danger' => 'bg-red-600 text-white hover:bg-red-700',
];

$sizes = [
    'default' => 'px-4 py-2 text-sm',
    'sm' => 'px-3 py-1.5 text-xs',
    'lg' => 'px-6 py-3 text-base',
    'icon' => 'p-2',
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
