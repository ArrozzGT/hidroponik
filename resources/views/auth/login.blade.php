<x-guest-layout>
    <h2 class="text-lg font-heading font-bold text-gray-900 mb-1">Masuk ke Akun</h2>
    <p class="text-sm text-gray-500 mb-6">Masukkan email dan password untuk melanjutkan</p>

    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-ui.input label="Email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@example.com" icon="mail" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-ui.input label="Password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" icon="lock" toggleable />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center justify-between">
            <x-ui.checkbox name="remember" id="remember_me">
                <span class="text-sm text-gray-600">Ingat saya</span>
            </x-ui.checkbox>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 transition-colors">
                    Lupa password?
                </a>
            @endif
        </div>

        <x-loading-button class="w-full bg-emerald-600 text-white hover:bg-emerald-700">
            Masuk
        </x-loading-button>
    </form>

    <div class="mt-5 pt-5 border-t border-gray-200 text-center">
        <p class="text-xs text-gray-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium text-emerald-600 hover:text-emerald-700 transition-colors">Daftar Sekarang</a>
        </p>
    </div>
</x-guest-layout>
