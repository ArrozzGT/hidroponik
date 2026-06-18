@props([
    'variant' => 'default',
])

@php
$variants = [
    'default' => 'bg-green-100 text-green-800 ring-1 ring-green-200',
    'primary' => 'bg-[var(--primary)] text-white',
    'success' => 'bg-green-100 text-green-800 ring-1 ring-green-200',
    'warning' => 'bg-amber-100 text-amber-800 ring-1 ring-amber-200',
    'danger' => 'bg-red-100 text-red-800 ring-1 ring-red-200',
    'info' => 'bg-blue-100 text-blue-800 ring-1 ring-blue-200',
    'outline' => 'bg-transparent text-[var(--primary)] border border-[var(--primary)]',
];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full ' . ($variants[$variant] ?? $variants['default'])]) }}>
    {{ $slot }}
</span>
