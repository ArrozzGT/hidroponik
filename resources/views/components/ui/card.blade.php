@props([
    'padding' => true,
    'hover' => false,
    'class' => '',
])

@php
$base = 'bg-white rounded-2xl border';
$borderColor = 'border-[var(--border)]';
$shadow = 'shadow-sm';
$hoverClass = $hover ? 'hover:-translate-y-1.5 hover:shadow-xl transition-all duration-300 cursor-pointer border-green-100/50 hover:border-green-100' : 'transition-shadow hover:shadow-md';
$padClass = $padding ? 'p-5 sm:p-6' : '';
@endphp

<div {{ $attributes->merge(['class' => trim("$base $borderColor $shadow $hoverClass $padClass $class")]) }}>
    {{ $slot }}
</div>
