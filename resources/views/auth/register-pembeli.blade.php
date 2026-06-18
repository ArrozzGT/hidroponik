<x-guest-layout>
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 bg-gradient-to-br from-green-400 to-green-700 shadow-lg shadow-green-600/30 animate-pop">
                <i data-lucide="shopping-bag" class="w-5 h-5 text-white" aria-hidden="true"></i>
            </div>
            <div>
                <h2 class="text-lg font-extrabold text-gray-900">Daftar Pembeli</h2>
                <p class="text-xs text-gray-400">Buat akun pembeli untuk mulai berbelanja</p>
            </div>
        </div>

        {{-- Info Banner --}}
        <div class="bg-green-50 border border-green-200 rounded-2xl px-4 py-3 text-xs text-green-700 leading-relaxed flex items-start gap-2">
            <i data-lucide="leaf" class="w-4 h-4 shrink-0 mt-0.5" aria-hidden="true"></i>
            <span>{{ __('Daftar sebagai Pembeli untuk mulai berbelanja sayuran hidroponik segar langsung dari petani.') }}</span>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="role" value="pembeli">

        {{-- Section: Informasi Akun --}}
        <div>
            <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                Informasi Akun
            </h3>
            <div class="space-y-3">
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lengkap Anda" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="contoh@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="no_hp" :value="__('Nomor HP' )" />
                    <x-text-input id="no_hp" type="text" name="no_hp" :value="old('no_hp')" required placeholder="0812-3456-7890" />
                    <x-input-error :messages="$errors->get('no_hp')" class="mt-1" />
                </div>
            </div>
        </div>

        {{-- Section: Keamanan --}}
        <div>
            <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                Keamanan
            </h3>
            <div class="space-y-3">
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-500 no-underline hover:text-slate-700 transition-colors inline-flex items-center gap-1.5">
                <i data-lucide="arrow-left" class="w-4 h-4" aria-hidden="true"></i>
                Kembali
            </a>
            <x-primary-button>
                <i data-lucide="user-check" class="w-4 h-4" aria-hidden="true"></i>
                {{ __('Daftar Pembeli') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
