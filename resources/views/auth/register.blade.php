<x-guest-layout>
    <div x-data="registerForm()" x-cloak>
        <h2 class="text-lg font-heading font-bold text-gray-900 mb-1">Daftar Akun Baru</h2>
        <p class="text-sm text-gray-600 mb-6">Bergabunglah dengan ribuan pengguna lainnya</p>

        <div class="flex items-center justify-center mb-6">
            <template x-for="(s, i) in steps" :key="i">
                <div class="flex items-center">
                    <div x-text="i + 1"
                        :class="step >= i + 1 ? 'w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold' : 'w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-xs font-bold'">
                    </div>
                    <div x-show="i < steps.length - 1"
                        :class="step > i + 1 ? 'w-12 h-0.5 bg-emerald-600 mx-1' : 'w-12 h-0.5 bg-gray-200 mx-1'">
                    </div>
                </div>
            </template>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="hidden" name="role" x-model="role">

            <div x-show="step === 1">
                <h3 class="font-heading font-semibold text-gray-900 mb-1">Pilih Tipe Akun</h3>
                <p class="text-sm text-gray-600 mb-5">Silakan pilih tipe akun Anda</p>

                <div class="flex flex-col gap-3">
                    <div @click="role = 'pembeli'" :class="role === 'pembeli' ? 'border-2 border-emerald-500 bg-emerald-50' : 'border-2 border-gray-200 hover:border-emerald-300'" class="rounded-xl p-5 cursor-pointer transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                                <i data-lucide="user" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
                            </div>
                            <div>
                                <p class="font-heading font-semibold text-gray-900 text-sm">Pembeli</p>
                                <p class="text-xs text-gray-600">Saya ingin membeli sayuran</p>
                            </div>
                        </div>
                    </div>

                    <div @click="role = 'petani'" :class="role === 'petani' ? 'border-2 border-emerald-500 bg-emerald-50' : 'border-2 border-gray-200 hover:border-emerald-300'" class="rounded-xl p-5 cursor-pointer transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                                <i data-lucide="leaf" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
                            </div>
                            <div>
                                <p class="font-heading font-semibold text-gray-900 text-sm">Petani</p>
                                <p class="text-xs text-gray-600">Saya ingin menjual sayuran</p>
                            </div>
                        </div>
                    </div>
                </div>

                <x-ui.button type="button" @click="nextStep()" class="w-full mt-6" variant="primary">
                    Lanjutkan
                </x-ui.button>
            </div>

            <div x-show="step === 2">
                <h3 class="font-heading font-semibold text-gray-900 mb-1">Informasi Pribadi</h3>
                <p class="text-sm text-gray-600 mb-5">Lengkapi data pribadi Anda</p>

                <div class="space-y-3">
                    <div>
                        <x-ui.input label="Nama Lengkap" type="text" name="name" x-model="name" required placeholder="Nama lengkap Anda" icon="user" />
                        @error('name') <x-input-error :messages="$errors->get('name')" /> @enderror
                    </div>

                    <div>
                        <x-ui.input label="Email" type="email" name="email" x-model="email" required autocomplete="username" placeholder="nama@example.com" icon="mail" />
                        @error('email') <x-input-error :messages="$errors->get('email')" /> @enderror
                    </div>

                    <div>
                        <x-ui.input label="Password" type="password" name="password" x-model="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" icon="lock" toggleable />
                        @error('password') <x-input-error :messages="$errors->get('password')" /> @enderror
                    </div>

                    <div>
                        <x-ui.input label="Konfirmasi Password" type="password" name="password_confirmation" x-model="passwordConfirmation" required autocomplete="new-password" placeholder="Ulangi password" icon="lock" toggleable />
                    </div>

                    <div class="flex gap-3 pt-2">
                        <x-ui.button type="button" @click="prevStep()" class="flex-1" variant="outline">
                            Kembali
                        </x-ui.button>
                        <x-ui.button type="button" @click="nextStep()" class="flex-1" variant="primary">
                            Lanjutkan
                        </x-ui.button>
                    </div>
                </div>
            </div>

            <div x-show="step === 3">
                <h3 class="font-heading font-semibold text-gray-900 mb-1">Informasi Tambahan</h3>
                <p class="text-sm text-gray-600 mb-5">Beberapa informasi tambahan</p>

                <div class="space-y-3">
                    <div>
                        <x-ui.input label="Nomor Telepon" type="text" name="no_hp" x-model="noHp" required placeholder="+62 812-3456-7890" icon="phone" />
                        @error('no_hp') <x-input-error :messages="$errors->get('no_hp')" /> @enderror
                    </div>

                    <div>
                        <x-ui.input label="Alamat" type="text" name="lokasi_kebun" x-model="lokasi" placeholder="Jl. Contoh No. 123, Jakarta" icon="map-pin" />
                    </div>

                    <div x-show="role === 'petani'">
                        <x-ui.input label="Nama Kebun/Usaha" type="text" name="nama_kebun" x-model="namaKebun" placeholder="Kebun Hijau Farm" icon="leaf" />
                        @error('nama_kebun') <x-input-error :messages="$errors->get('nama_kebun')" /> @enderror
                    </div>

                    <div x-show="role === 'petani'">
                        <x-ui.input label="Deskripsi Usaha" type="text" name="deskripsi_kebun" x-model="deskripsiKebun" placeholder="Ceritakan tentang kebun hidroponik Anda..." />
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="terms" required class="mt-0.5 w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer" />
                            <span class="text-xs text-gray-600 leading-relaxed">
                                Saya setuju dengan
                                <a href="{{ route('terms') }}" target="_blank" class="text-emerald-600 font-semibold hover:text-emerald-700 hover:underline transition-colors">
                                    Syarat & Ketentuan
                                </a>
                                dan
                                <a href="{{ route('privacy') }}" target="_blank" class="text-emerald-600 font-semibold hover:text-emerald-700 hover:underline transition-colors">
                                    Kebijakan Privasi
                                </a>
                                SIPSH
                            </span>
                        </label>
                        @error('terms')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1 ml-7">
                                <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex gap-3 pt-2">
                        <x-ui.button type="button" @click="prevStep()" class="flex-1" variant="outline">
                            Kembali
                        </x-ui.button>
                        <x-loading-button class="flex-1 bg-emerald-600 text-white hover:bg-emerald-700">
                            Daftar Sekarang
                        </x-loading-button>
                    </div>
                </div>
            </div>
        </form>

        <div class="mt-5 pt-4 border-t border-gray-200 text-center">
            <p class="text-xs text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-emerald-600 hover:text-emerald-700 transition-colors">Masuk di sini</a>
            </p>
        </div>
    </div>

    <script>
        function registerForm() {
            return {
                step: 1,
                steps: ['Pilih Tipe Akun', 'Informasi Pribadi', 'Informasi Tambahan'],
                role: 'pembeli',
                name: '{{ old('name') }}',
                email: '{{ old('email') }}',
                password: '',
                passwordConfirmation: '',
                noHp: '{{ old('no_hp') }}',
                lokasi: '{{ old('lokasi_kebun') }}',
                namaKebun: '{{ old('nama_kebun') }}',
                deskripsiKebun: '{{ old('deskripsi_kebun') }}',
                nextStep() {
                    if (this.step < 3) this.step++;
                },
                prevStep() {
                    if (this.step > 1) this.step--;
                }
            };
        }
    </script>
</x-guest-layout>
