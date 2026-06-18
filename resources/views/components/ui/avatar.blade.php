@props([
    'src' => null,
    'alt' => '',
    'size' => 'md',
    'fallback' => null,
])

@php
$sizes = [
    'sm' => 'h-8 w-8',
    'md' => 'h-10 w-10',
    'lg' => 'h-12 w-12',
    'xl' => 'h-16 w-16',
];
@endphp

<div {{ $attributes->merge(['class' => 'relative rounded-full overflow-hidden flex-shrink-0 ring-2 ring-green-200 ' . ($sizes[$size] ?? $sizes['md'])]) }}>
    @if ($src)
        <img src="{{ $src }}" alt="{{ $alt }}" class="h-full w-full object-cover" />
    @elseif ($fallback)
        <div class="h-full w-full flex items-center justify-center bg-green-100 text-green-700 font-bold text-sm">
            {{ $fallback }}
        </div>
    @endif
</div>
