<div class="flex flex-col items-center justify-center py-24 text-center">
    <div class="w-20 h-20 rounded-xl flex items-center justify-center mx-auto mb-5 bg-gray-50">
        <i data-lucide="{{ $icon ?? 'package-open' }}" class="w-9 h-9 text-gray-500" aria-hidden="true"></i>
    </div>
    <h3 class="text-xl font-heading font-semibold text-gray-600 mb-2">{{ $title }}</h3>
    @if($description ?? false)
        <p class="text-gray-500 mb-6 max-w-sm text-sm">{{ $description }}</p>
    @endif
    @if($slot ?? false)
        <div>{{ $slot }}</div>
    @endif
</div>
