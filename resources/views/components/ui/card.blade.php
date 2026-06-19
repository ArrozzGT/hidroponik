@props([
    'variant' => 'default',
    'padding' => 'md',
    'class' => ''
])

@php
$base = 'bg-white';
$variants = [
    'default' => 'border border-gray-100 rounded-xl',
    'bordered' => 'border-2 border-gray-100 rounded-xl',
    'flat' => 'bg-gray-50 rounded-xl',
    'hover' => 'border border-gray-100 rounded-xl transition-base hover:border-gray-200',
];
$paddings = [
    'none' => '',
    'sm' => 'p-4',
    'md' => 'p-6',
    'lg' => 'p-8',
];
@endphp

<div {{ $attributes->merge(['class' => "$base {$variants[$variant]} {$paddings[$padding]} $class"]) }}>
    {{ $slot }}
</div>
