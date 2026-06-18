<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-[18px] flex items-center justify-center mx-auto mb-4 bg-gradient-to-br from-green-400 to-green-700 shadow-lg shadow-green-600/30">
            <i data-lucide="mail-check" class="w-6 h-6 text-white" aria-hidden="true"></i>
        </div>
        <h2 class="text-xl font-extrabold text-gray-900 mb-1">{{ __('Verifikasi Email') }}</h2>
        <p class="text-sm text-gray-500 leading-relaxed max-w-sm mx-auto">
            {{ __('Terima kasih sudah mendaftar! Silakan verifikasi email Anda dengan mengklik link yang kami kirimkan.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-2xl text-sm text-green-700 font-semibold">
            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
        </div>
    @endif

    <div class="flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                {{ __('Kirim Ulang Email Verifikasi') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-secondary-button type="submit">
                {{ __('Keluar') }}
            </x-secondary-button>
        </form>
    </div>
</x-guest-layout>
