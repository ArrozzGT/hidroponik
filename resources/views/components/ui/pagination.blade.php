@props([
    'current' => 1,
    'total' => 1,
])

@if ($total > 1)
    <nav {{ $attributes->merge(['class' => 'flex items-center justify-center gap-1']) }}>
        {{-- Previous --}}
        <a href="#"
            data-page="{{ $current - 1 }}"
            class="inline-flex items-center justify-center h-10 w-10 rounded-xl border border-[var(--border)] text-sm transition-colors {{ $current <= 1 ? 'opacity-50 pointer-events-none' : 'hover:bg-green-50' }}"
            onclick="event.preventDefault(); window.dispatchEvent(new CustomEvent('page-change', {detail: {page: {{ $current - 1 }}}}))"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

        {{-- Pages --}}
        @for ($i = 1; $i <= $total; $i++)
            <a href="#"
                data-page="{{ $i }}"
                class="inline-flex items-center justify-center h-10 w-10 rounded-xl text-sm font-semibold transition-all {{ $i === $current ? 'bg-[var(--primary)] text-white shadow-lg shadow-green-600/30' : 'border border-[var(--border)] hover:bg-green-50' }}"
                onclick="event.preventDefault(); window.dispatchEvent(new CustomEvent('page-change', {detail: {page: {{ $i }}}}))"
            >
                {{ $i }}
            </a>
        @endfor

        {{-- Next --}}
        <a href="#"
            data-page="{{ $current + 1 }}"
            class="inline-flex items-center justify-center h-10 w-10 rounded-xl border border-[var(--border)] text-sm transition-colors {{ $current >= $total ? 'opacity-50 pointer-events-none' : 'hover:bg-green-50' }}"
            onclick="event.preventDefault(); window.dispatchEvent(new CustomEvent('page-change', {detail: {page: {{ $current + 1 }}}}))"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </nav>
@endif
