@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 rounded-xl text-sm font-semibold leading-5 text-white bg-primary-600 shadow-soft transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 py-2 rounded-xl text-sm font-medium leading-5 text-gray-500 hover:text-primary-700 hover:bg-primary-50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
