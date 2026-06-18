@props([
    'required' => false,
])

<label {{ $attributes->merge(['class' => 'block text-sm font-semibold text-[var(--foreground)]']) }}>
    {{ $slot }}
    @if ($required)
        <span class="text-red-500 ml-0.5">*</span>
    @endif
</label>
