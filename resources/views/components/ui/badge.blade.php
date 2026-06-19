@props([
    'variant' => 'default',
    'pill' => false,
])

@php
$base = 'inline-flex items-center px-2.5 py-0.5 text-xs font-medium';
$base .= $pill ? ' rounded-full' : ' rounded-md';
$variants = [
    'default' => 'bg-gray-100 text-gray-700',
    'primary' => 'bg-emerald-100 text-emerald-700',
    'success' => 'bg-green-100 text-green-700',
    'warning' => 'bg-amber-100 text-amber-700',
    'danger' => 'bg-red-100 text-red-700',
    'info' => 'bg-blue-100 text-blue-700',
    'outline' => 'border border-gray-200 text-gray-600 bg-transparent',
];
$class = "$base {$variants[$variant]}";
@endphp

<span {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</span>
