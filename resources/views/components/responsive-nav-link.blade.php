@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-4 py-2.5 rounded-xl text-start text-sm font-semibold text-white bg-primary-600 shadow-soft transition duration-150 ease-in-out'
            : 'block w-full px-4 py-2.5 rounded-xl text-start text-sm font-medium text-gray-600 hover:text-primary-700 hover:bg-primary-50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
