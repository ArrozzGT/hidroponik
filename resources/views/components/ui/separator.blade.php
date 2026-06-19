@props([
    'class' => '',
])

<hr {{ $attributes->merge(['class' => 'border-t border-gray-100' . ($class ? ' ' . $class : '')]) }} />
