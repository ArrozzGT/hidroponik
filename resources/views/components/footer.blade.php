<footer class="bg-gradient-to-br from-green-900 to-green-800 text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 backdrop-blur-sm">
                        <i data-lucide="leaf" class="h-6 w-6 text-green-200" aria-hidden="true"></i>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold text-white">{{ config('app.name', 'SIPSH') }}</span>
                        <p class="text-xs text-green-200 -mt-0.5">Sayuran Hidroponik</p>
                    </div>
                </div>
                <p class="text-green-100 text-sm mb-4">
                    Platform marketplace sayuran hidroponik segar, organik, dan berkualitas langsung dari petani.
                </p>
                <div class="flex gap-3">
                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-colors backdrop-blur-sm">
                        <i data-lucide="facebook" class="h-4 w-4" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-colors backdrop-blur-sm">
                        <i data-lucide="instagram" class="h-4 w-4" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-colors backdrop-blur-sm">
                        <i data-lucide="twitter" class="h-4 w-4" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="font-bold mb-4">Tautan Cepat</h4>
                <ul class="space-y-2 text-sm text-green-100">
                    <li><a href="/" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="/shop" class="hover:text-white transition-colors">Belanja</a></li>
                    <li><a href="/petani/dashboard" class="hover:text-white transition-colors">Dashboard Petani</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                </ul>
            </div>

            {{-- Customer Service --}}
            <div>
                <h4 class="font-bold mb-4">Layanan Pelanggan</h4>
                <ul class="space-y-2 text-sm text-green-100">
                    <li><a href="#" class="hover:text-white transition-colors">Pusat Bantuan</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Cara Berbelanja</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Kebijakan Pengembalian</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="font-bold mb-4">Hubungi Kami</h4>
                <ul class="space-y-3 text-sm text-green-100">
                    <li class="flex items-start gap-2">
                        <i data-lucide="map-pin" class="h-4 w-4 mt-0.5 flex-shrink-0" aria-hidden="true"></i>
                        <span>Jl. Pertanian No. 123, Jakarta, Indonesia</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="phone" class="h-4 w-4 flex-shrink-0" aria-hidden="true"></i>
                        <span>+62 812-3456-7890</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="mail" class="h-4 w-4 flex-shrink-0" aria-hidden="true"></i>
                        <span>info@sipsh.co.id</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-8 pt-8 text-center text-sm text-green-100">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'SIPSH') }}. All rights reserved.</p>
        </div>
    </div>
</footer>
