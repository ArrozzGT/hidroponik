<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-[18px] flex items-center justify-center mx-auto mb-4 bg-gradient-to-br from-green-400 to-green-700 shadow-lg shadow-green-600/30">
            <i data-lucide="shield" class="w-6 h-6 text-white" aria-hidden="true"></i>
        </div>
        <h2 class="text-xl font-extrabold text-gray-900 mb-1">{{ __('Konfirmasi Password') }}</h2>
        <p class="text-sm text-gray-500 leading-relaxed">
            {{ __('Ini adalah area aman. Silakan konfirmasi password Anda sebelum melanjutkan.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-5">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 form-input"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex justify-end">
            <x-primary-button>
                {{ __('Konfirmasi') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
