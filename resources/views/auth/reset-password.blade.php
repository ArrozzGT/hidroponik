<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4 bg-emerald-100">
            <i data-lucide="key-round" class="w-6 h-6 text-emerald-600" aria-hidden="true"></i>
        </div>
        <h2 class="text-lg font-heading font-bold text-gray-900 mb-1">Reset Password</h2>
        <p class="text-sm text-gray-600">Buat password baru untuk akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-ui.input label="Email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="nama@example.com" icon="mail" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-ui.input label="Password Baru" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" icon="lock" toggleable />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <x-ui.input label="Konfirmasi Password" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" icon="lock" toggleable />
        </div>

        <x-loading-button class="w-full bg-emerald-600 text-white hover:bg-emerald-700" icon="shield-check">
            Reset Password
        </x-loading-button>
    </form>

    <div class="mt-5 text-center">
        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 inline-flex items-center gap-1.5 hover:text-gray-600 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5" aria-hidden="true"></i>
            Kembali ke halaman masuk
        </a>
    </div>
</x-guest-layout>
