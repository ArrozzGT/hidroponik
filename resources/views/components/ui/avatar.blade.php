@props([
    'src' => null,
    'alt' => '',
    'size' => 'md',
    'fallback' => null,
])

@php
$sizes = [
    'sm' => 'w-6 h-6',
    'md' => 'w-8 h-8',
    'lg' => 'w-10 h-10',
    'xl' => 'w-14 h-14',
];
$fontSizes = [
    'sm' => 'text-[9px]',
    'md' => 'text-xs',
    'lg' => 'text-sm',
    'xl' => 'text-lg',
];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-full overflow-hidden flex-shrink-0 ' . ($sizes[$size] ?? $sizes['md'])]) }}>
    @if ($src)
        <img src="{{ $src }}" alt="{{ $alt }}" class="h-full w-full object-cover" loading="lazy" />
    @else
        <div class="h-full w-full flex items-center justify-center bg-gray-100 text-gray-500 font-medium {{ $fontSizes[$size] ?? 'text-xs' }}">
            {{ $fallback }}
        </div>
    @endif
</div>
