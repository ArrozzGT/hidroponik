@props(['href'])

<a {{ $attributes->merge(['href' => $href]) }} class="block w-full px-4 py-2.5 text-start text-sm font-medium text-gray-600 hover:bg-primary-50 hover:text-primary-700 focus:outline-none focus:bg-primary-50 focus:text-primary-700 transition-colors">
    {{ $slot }}
</a>
