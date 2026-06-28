@props([
    'href'    => null,
    'label'   => 'Kembali',
    'variant' => 'default',
])

@php
    $fallbackUrl = $href ?? url()->previous();
    $baseJs = "if(window.history.length > 2){ event.preventDefault(); history.back(); }";

    $variantClass = match($variant) {
        'minimal' => 'text-gray-500 hover:text-emerald-600',
        'pill'    => 'bg-white border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 px-3 py-1.5 rounded-full shadow-sm',
        default   => 'text-gray-600 hover:text-emerald-600',
    };
@endphp

<a
    href="{{ $fallbackUrl }}"
    onclick="{{ $baseJs }}"
    {{ $attributes->merge(['class' => "inline-flex items-center gap-2 text-sm font-medium transition-all duration-200 group $variantClass"]) }}
>
    <span class="flex items-center justify-center w-7 h-7 rounded-lg border border-gray-200 bg-white group-hover:border-emerald-300 group-hover:bg-emerald-50 group-hover:-translate-x-0.5 transition-all duration-200 flex-shrink-0 shadow-sm">
        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
    </span>
    <span>{{ $label }}</span>
</a>
