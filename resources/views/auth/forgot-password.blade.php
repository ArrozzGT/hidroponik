<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4 bg-emerald-100">
            <i data-lucide="mail" class="w-6 h-6 text-emerald-600" aria-hidden="true"></i>
        </div>
        <h2 class="text-lg font-heading font-bold text-gray-900 mb-1">Lupa Password?</h2>
        <p class="text-xs text-gray-600 max-w-xs mx-auto leading-relaxed">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>
    </div>

    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <x-ui.input label="Email" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@example.com" icon="mail" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <x-loading-button class="w-full bg-emerald-600 text-white hover:bg-emerald-700" icon="send">
            Kirim Link Reset
        </x-loading-button>
    </form>

    <div class="mt-5 text-center">
        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 inline-flex items-center gap-1.5 hover:text-gray-600 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5" aria-hidden="true"></i>
            Kembali ke halaman masuk
        </a>
    </div>
</x-guest-layout>
