<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-[18px] flex items-center justify-center mx-auto mb-4 bg-gradient-to-br from-green-400 to-green-700 shadow-lg shadow-green-600/30">
            <i data-lucide="mail" class="w-6 h-6 text-white" aria-hidden="true"></i>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900 mb-1">{{ __('Lupa Password?') }}</h2>
        <p class="text-xs text-gray-500 max-w-xs mx-auto leading-relaxed">{{ __('Masukkan email Anda dan kami akan mengirimkan link untuk reset password.') }}</p>
    </div>

    @if (session('status'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-2xl text-sm text-green-700 font-semibold flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 shrink-0" aria-hidden="true"></i>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-5">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <x-primary-button class="w-full justify-center">
            <i data-lucide="send" class="w-4 h-4" aria-hidden="true"></i>
            {{ __('Kirim Link Reset') }}
        </x-primary-button>
    </form>

    <div class="mt-5 text-center">
        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-400 no-underline inline-flex items-center gap-1.5">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5" aria-hidden="true"></i>
            Kembali ke halaman masuk
        </a>
    </div>
</x-guest-layout>
