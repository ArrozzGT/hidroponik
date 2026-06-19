<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-emerald-600 text-white hover:bg-emerald-700 px-4 py-2 text-sm rounded-lg font-medium transition-colors']) }}>
    {{ $slot }}
</button>
