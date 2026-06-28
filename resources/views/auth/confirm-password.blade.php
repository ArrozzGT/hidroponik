<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4 bg-emerald-100">
            <i data-lucide="shield" class="w-6 h-6 text-emerald-600" aria-hidden="true"></i>
        </div>
        <h2 class="text-lg font-heading font-bold text-gray-900 mb-1">Konfirmasi Password</h2>
        <p class="text-sm text-gray-600 leading-relaxed">
            Ini adalah area aman. Silakan konfirmasi password Anda sebelum melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <div>
            <x-ui.input label="Password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda" icon="lock" toggleable />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <x-loading-button class="w-full bg-emerald-600 text-white hover:bg-emerald-700">
            Konfirmasi
        </x-loading-button>
    </form>
</x-guest-layout>
