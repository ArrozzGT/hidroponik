@props(['count' => 8, 'cols' => 4])

<div x-data x-cloak>
    <div x-show="$store.skeleton?.loading ?? false" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ $cols }} xl:grid-cols-{{ $cols }} gap-5 sm:gap-6">
        @for ($i = 0; $i < $count; $i++)
            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">
                <div class="aspect-square bg-gray-100 animate-pulse"></div>
                <div class="p-4 space-y-3">
                    <div class="h-4 bg-gray-100 rounded animate-pulse w-3/4"></div>
                    <div class="h-3 bg-gray-100 rounded animate-pulse w-1/2"></div>
                    <div class="h-5 bg-gray-100 rounded animate-pulse w-1/3"></div>
                    <div class="h-8 bg-gray-100 rounded-lg animate-pulse w-full"></div>
                </div>
            </div>
        @endfor
    </div>
</div>