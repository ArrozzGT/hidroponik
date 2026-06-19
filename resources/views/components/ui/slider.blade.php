@props([
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'value' => 50,
    'label' => null,
])

<div x-data="{
    value: {{ $value }},
    min: {{ $min }},
    max: {{ $max }},
    get percent() { return ((this.value - this.min) / (this.max - this.min)) * 100; }
}" {{ $attributes->merge(['class' => 'w-full']) }}>
    @if ($label)
        <label class="block text-sm font-semibold text-[var(--foreground)] mb-3">{{ $label }}</label>
    @endif

    <div class="relative h-2 bg-green-100 rounded-full">
        <div
            class="absolute top-0 left-0 h-full bg-gradient-to-r from-green-500 to-[var(--primary)] rounded-full transition-all duration-150"
            :style="'width: ' + percent + '%'"
        ></div>
        <input
            type="range"
            :min="min"
            :max="max"
            :step="{{ $step }}"
            x-model="value"
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
        />
        <div
            class="absolute top-1/2 -translate-y-1/2 -ml-3 h-6 w-6 rounded-full bg-white border-2 border-emerald-600 transition-all duration-150 pointer-events-none"
            :style="'left: ' + percent + '%'"
        ></div>
    </div>
</div>
