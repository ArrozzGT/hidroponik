@props([
    'label' => null,
    'icon' => null,
    'error' => null,
    'help' => null,
    'id' => null,
    'toggleable' => false,
])

@php
$id = $id ?? 'input-' . Str::random(8);
$hasIcon = $icon !== null;
@endphp

@php
$inputType = $attributes->get('type', 'text');
@endphp

<div class="space-y-1.5">
    @if ($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif

    <div class="relative" @if($toggleable) x-data="{ show: false }" @endif>
        @if ($hasIcon)
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                <i data-lucide="{{ $icon }}" class="h-4 w-4" aria-hidden="true"></i>
            </div>
        @endif

        <input
            id="{{ $id }}"
            {{ $attributes->merge([
                'class' => 'block w-full px-3 py-2 border rounded-lg text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:ring-offset-0 transition-colors ' . ($hasIcon ? 'pl-9 ' : '') . ($toggleable ? 'pr-9 ' : '') . ($error ? 'border-red-400' : 'border-gray-200'),
            ]) }}
            @if($toggleable)
                :type="show ? 'text' : '{{ $inputType }}'"
            @endif
        />

        @if($toggleable)
            <button type="button" @click="show = !show"
                class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1 transition-colors"
                tabindex="-1" aria-label="Toggle password visibility">
                <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                </svg>
            </button>
        @endif
    </div>

    @if ($help && !$error)
        <p class="text-xs text-gray-400 mt-1">{{ $help }}</p>
    @endif

    @if ($error)
        <p class="text-xs text-red-600 mt-1">{{ $error }}</p>
    @endif
</div>
