<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4 bg-emerald-100">
            <i data-lucide="mail-check" class="w-6 h-6 text-emerald-600" aria-hidden="true"></i>
        </div>
        <h2 class="text-lg font-heading font-bold text-gray-900 mb-1">Verifikasi Email</h2>
        <p class="text-sm text-gray-600 leading-relaxed max-w-sm mx-auto">
            Terima kasih sudah mendaftar! Silakan verifikasi email Anda dengan mengklik link yang kami kirimkan.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 font-semibold flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 shrink-0" aria-hidden="true"></i>
            Link verifikasi baru telah dikirim ke alamat email Anda.
        </div>
    @endif

    <div class="flex flex-col gap-4" x-data="{ cooldown: 0 }">
        <form method="POST" action="{{ route('verification.send') }}"
              @submit="if(cooldown > 0) { $event.preventDefault(); return; } cooldown = 60; setInterval(() => { if(cooldown > 0) cooldown--; }, 1000)">
            @csrf
            <x-loading-button class="w-full bg-emerald-600 text-white hover:bg-emerald-700">
                <span x-show="cooldown === 0">Kirim Ulang Email Verifikasi</span>
                <span x-show="cooldown > 0" x-text="`Kirim Ulang (${cooldown}s)`"></span>
            </x-loading-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-ui.button type="submit" class="w-full" variant="ghost">
                Keluar
            </x-ui.button>
        </form>
    </div>
</x-guest-layout>
