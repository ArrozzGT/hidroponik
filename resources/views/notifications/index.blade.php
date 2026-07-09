@extends(Auth::user()->hasRole('admin') ? 'layouts.admin' : (Auth::user()->hasRole('petani') ? 'layouts.petani' : 'layouts.pembeli'))

@section('page', 'Notifikasi')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
            <i data-lucide="bell" style="width:20px;height:20px;color:#059669;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-heading font-bold text-xl text-gray-900 leading-tight">Notifikasi</h2>
            <p class="text-sm text-gray-500 mt-0.5">Pemberitahuan dan informasi sistem</p>
        </div>
    </div>
@endsection

@section(Auth::user()->hasRole('admin') ? 'admin-content' : (Auth::user()->hasRole('petani') ? 'petani-content' : 'pembeli-content'))
    <div class="py-6 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :crumbs="[['label' => 'Notifikasi']]" />

        @php
            $grouped = $notifications->groupBy(fn($n) => $n->created_at->format('Y-m-d'));
        @endphp

        <div class="flex justify-end mb-6">
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-1.5">
                    <i data-lucide="check-check" class="w-4 h-4" aria-hidden="true"></i>
                    Tandai Semua Dibaca
                </button>
            </form>
        </div>

        @forelse($grouped as $date => $items)
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                {{ \Carbon\Carbon::parse($date)->isToday() ? 'Hari Ini' : (\Carbon\Carbon::parse($date)->isYesterday() ? 'Kemarin' : \Carbon\Carbon::parse($date)->format('d M Y')) }}
            </p>
            <div class="space-y-2 mb-6">
                @foreach($items as $notif)
                    <div class="bg-white border border-gray-100 rounded-xl p-5 transition-all cursor-pointer hover:border-gray-200
                        {{ !$notif->is_read ? 'border-l-4 border-l-emerald-500 bg-emerald-50/40' : '' }}"
                        @if(!$notif->is_read)
                            onclick="fetch('{{ route('notifications.read', $notif) }}', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}}).then(() => { this.classList.remove('border-l-emerald-500', 'bg-emerald-50/40') }).catch(() => {})"
                        @endif>
                        <div class="flex items-start gap-4">
                            <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0 {{ !$notif->is_read ? 'bg-emerald-500' : 'bg-gray-300' }}"></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <h4 class="font-heading font-semibold text-sm text-gray-900 truncate">{{ $notif->title }}</h4>
                                    <span class="text-[10px] text-gray-500 shrink-0">{{ $notif->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $notif->message }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <x-empty-state icon="bell-off" title="Tidak ada notifikasi" description="Notifikasi akan muncul di sini." />
        @endforelse

        <div class="mt-5">{{ $notifications->links() }}</div>
    </div>
@endsection
