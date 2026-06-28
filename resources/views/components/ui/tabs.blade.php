@props([
    'tabs' => [],
    'selected' => null,
    'id' => null,
])

@php
$id = $id ?? 'tabs-' . Str::random(8);
$selected = $selected ?: (isset($tabs[0]) ? $tabs[0]['id'] : '');
@endphp

<div x-data="{ tab: '{{ $selected }}' }" {{ $attributes->merge(['class' => 'w-full']) }}>
    <div class="flex border-b border-gray-100 overflow-x-auto" role="tablist">
        @foreach ($tabs as $tab)
            <button
                @click="tab = '{{ $tab['id'] }}'"
                :class="tab === '{{ $tab['id'] }}' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-600 hover:text-gray-700'"
                class="px-4 py-2 text-sm font-medium whitespace-nowrap transition-colors"
                role="tab"
                :aria-selected="tab === '{{ $tab['id'] }}'"
            >
                @if (isset($tab['icon']))
                    <i data-lucide="{{ $tab['icon'] }}" class="h-4 w-4 inline mr-1.5" aria-hidden="true"></i>
                @endif
                {{ $tab['label'] }}
            </button>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $slot }}
    </div>
</div>
