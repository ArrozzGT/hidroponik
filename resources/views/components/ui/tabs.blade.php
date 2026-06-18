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
    {{-- Tab List --}}
    <div class="flex border-b border-[var(--border)] overflow-x-auto" role="tablist">
        @foreach ($tabs as $tab)
            <button
                @click="tab = '{{ $tab['id'] }}'"
                :class="tab === '{{ $tab['id'] }}' ? 'border-b-2 border-[var(--primary)] text-[var(--primary)]' : 'text-[var(--muted-foreground)] hover:text-[var(--foreground)]'"
                class="px-4 py-3 text-sm font-semibold whitespace-nowrap transition-colors"
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

    {{-- Tab Panels --}}
    <div class="mt-4">
        {{ $slot }}
    </div>
</div>
