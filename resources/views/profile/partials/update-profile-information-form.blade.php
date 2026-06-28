<section>
    <header>
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900">{{ __('Profile Information') }}</h2>
                <p class="text-sm text-gray-500">{{ __("Update your account's profile information and email address.") }}</p>
            </div>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="foto" :value="__('Foto Profil')" />
            @if($user->foto)
                <div class="mt-2 mb-3">
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Avatar" class="w-20 h-20 rounded-xl object-cover shadow-elegant" loading="lazy"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <div class="w-20 h-20 rounded-xl shadow-elegant hidden items-center justify-center bg-gray-100">
                        <svg class="w-8 h-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/></svg>
                    </div>
                </div>
            @endif
            <div class="mt-1 flex items-center justify-center px-4 py-5 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/50 hover:bg-gray-100/50 transition-colors cursor-pointer">
                <label for="foto" class="flex flex-col items-center cursor-pointer">
                    <svg class="w-6 h-6 text-gray-500 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316zM16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                    <span class="text-xs text-gray-500 font-medium">Klik untuk upload foto</span>
                </label>
                <input id="foto" name="foto" type="file" class="hidden" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 form-input" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-1.5" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 form-input" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-1.5" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm text-gray-600">
                        {{ __('Email Anda belum diverifikasi.') }}
                        <button form="send-verification" class="text-primary-600 font-semibold hover:underline transition-colors">{{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}</button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-primary-600">{{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="no_hp" :value="__('Nomor HP')" />
            <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 form-input" :value="old('no_hp', $user->no_hp)" required />
            <x-input-error class="mt-1.5" :messages="$errors->get('no_hp')" />
        </div>

        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <textarea id="alamat" name="alamat" class="mt-1 form-input min-h-[80px] resize-none">{{ old('alamat', $user->alamat) }}</textarea>
            <x-input-error class="mt-1.5" :messages="$errors->get('alamat')" />
        </div>

        @if($user->hasRole('petani'))
            <hr class="my-6 border-gray-100">
            <h3 class="text-md font-bold text-gray-900 mb-4">{{ __('Informasi Kebun') }}</h3>

            <div>
                <x-input-label for="nama_kebun" :value="__('Nama Kebun')" />
                <x-text-input id="nama_kebun" name="nama_kebun" type="text" class="mt-1 form-input" :value="old('nama_kebun', $user->petaniProfile->nama_kebun)" />
                <x-input-error class="mt-1.5" :messages="$errors->get('nama_kebun')" />
            </div>

            <div class="mt-4">
                <x-input-label for="lokasi_kebun" :value="__('Lokasi Kebun (Link Google Maps opsional)')" />
                <x-text-input id="lokasi_kebun" name="lokasi_kebun" type="text" class="mt-1 form-input" :value="old('lokasi_kebun', $user->petaniProfile->lokasi_kebun)" />
                <x-input-error class="mt-1.5" :messages="$errors->get('lokasi_kebun')" />
            </div>

            <div class="mt-4">
                <x-input-label for="deskripsi_kebun" :value="__('Deskripsi Kebun')" />
                <textarea id="deskripsi_kebun" name="deskripsi_kebun" class="mt-1 form-input min-h-[80px] resize-none">{{ old('deskripsi_kebun', $user->petaniProfile->deskripsi_kebun) }}</textarea>
                <x-input-error class="mt-1.5" :messages="$errors->get('deskripsi_kebun')" />
            </div>
        @endif

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-primary-600 font-medium">{{ __('Berhasil disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
