<button {{ $attributes->merge(['type' => 'button', 'class' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 text-sm rounded-lg font-medium transition-colors']) }}>
    {{ $slot }}
</button>
