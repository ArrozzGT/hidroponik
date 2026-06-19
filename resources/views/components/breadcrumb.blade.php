<nav aria-label="Breadcrumb" class="flex items-center gap-1.5 text-sm text-gray-400 mb-5">
    <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition-colors">
        <i data-lucide="layout-dashboard" class="w-4 h-4" aria-hidden="true"></i>
    </a>
    @foreach($crumbs as $crumb)
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 shrink-0" aria-hidden="true"></i>
        @if($crumb['url'] ?? false)
            <a href="{{ $crumb['url'] }}" class="hover:text-gray-600 transition-colors truncate">
                {{ $crumb['label'] }}
            </a>
        @else
            <span class="text-gray-600 font-medium truncate">{{ $crumb['label'] }}</span>
        @endif
    @endforeach
</nav>
