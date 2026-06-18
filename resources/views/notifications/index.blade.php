@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : (Auth::user()->role === 'petani' ? 'layouts.petani' : 'layouts.pembeli'))

@section('page', 'Notifikasi')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md" style="background:linear-gradient(135deg,#4ade80,#22c55e);">
            <i data-lucide="bell" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Notifikasi</h2>
            <p class="text-sm text-gray-400 mt-0.5">Pemberitahuan dan informasi sistem</p>
        </div>
    </div>
@endsection

@section(Auth::user()->role === 'admin' ? 'admin-content' : (Auth::user()->role === 'petani' ? 'petani-content' : 'pembeli-content'))
    <div class="py-6 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-50 border border-green-100 text-green-700 px-5 py-3 rounded-2xl mb-6 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <div class="flex justify-end mb-6">
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="btn-secondary text-xs"><i data-lucide="check-check" class="w-4 h-4" aria-hidden="true"></i> Tandai Semua Dibaca</button>
            </form>
        </div>

        <div class="space-y-3">
            @forelse($notifications as $notif)
                <div class="card p-5 {{ !$notif->is_read ? 'border-l-4 border-l-green-500 bg-green-50/40' : '' }}">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ !$notif->is_read ? 'bg-green-100' : 'bg-slate-100' }}">
                            <i data-lucide="{{ $notif->type === 'order' ? 'shopping-cart' : ($notif->type === 'verification' ? 'user-check' : 'info') }}"
                               class="w-5 h-5 {{ !$notif->is_read ? 'text-green-600' : 'text-slate-400' }}" aria-hidden="true"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <h4 class="font-bold text-sm text-gray-900 {{ !$notif->is_read ? '' : '' }}">{{ $notif->title }}</h4>
                                <div class="flex items-center gap-2 shrink-0">
                                    <span class="text-[10px] text-gray-400">{{ $notif->created_at->diffForHumans() }}</span>
                                    @if(!$notif->is_read)
                                        <form action="{{ route('notifications.read', $notif) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-2 h-2 rounded-full bg-green-500 hover:bg-green-600" title="Tandai dibaca"></button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $notif->message }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16">
                    <div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center bg-slate-50">
                        <i data-lucide="bell-off" class="w-8 h-8 text-slate-300" aria-hidden="true"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Tidak ada notifikasi</p>
                    <p class="text-xs text-gray-400 mt-1">Notifikasi akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-5">{{ $notifications->links() }}</div>
    </div>
@endsection
