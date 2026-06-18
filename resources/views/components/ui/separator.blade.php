@props([
    'class' => '',
])

<hr {{ $attributes->merge(['class' => 'border-t ' . ($class ?: 'border-[var(--border)]')]) }} />
