<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-[18px] flex items-center justify-center mx-auto mb-4 bg-gradient-to-br from-green-400 to-green-700 shadow-lg shadow-green-600/30">
            <i data-lucide="key-round" class="w-6 h-6 text-white" aria-hidden="true"></i>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Reset Password</h2>
        <p class="text-sm text-gray-500">Buat password baru untuk akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="mb-4">
            <x-input-label for="password" :value="__('Password Baru')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="mb-5">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <x-primary-button class="w-full justify-center">
            <i data-lucide="shield-check" class="w-4 h-4" aria-hidden="true"></i>
            {{ __('Reset Password') }}
        </x-primary-button>
    </form>
</x-guest-layout>
