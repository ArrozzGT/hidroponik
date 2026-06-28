<x-guest-layout>
    <div>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                <i data-lucide="file-text" class="w-5 h-5 text-emerald-600"></i>
            </div>
            <div>
                <h2 class="text-xl font-heading font-bold text-gray-900">Syarat & Ketentuan</h2>
                <p class="text-xs text-gray-500 mt-0.5">Terakhir diperbarui: {{ date('d F Y') }}</p>
            </div>
        </div>

        <div class="max-h-72 overflow-y-auto rounded-xl border border-gray-100 bg-gray-50/80 p-4 mb-5 scrollbar-thin scrollbar-thumb-emerald-200 scrollbar-track-transparent">
            <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1.5 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 text-xs flex items-center justify-center font-bold flex-shrink-0">1</span>
                        Ketentuan Umum
                    </h3>
                    <p class="ml-7">Dengan mendaftar di SIPSH (Sistem Informasi Pasar Sayuran Hidroponik), Anda menyatakan telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan yang berlaku. Seluruh transaksi dilakukan dengan itikad baik dan sesuai hukum Republik Indonesia.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1.5 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 text-xs flex items-center justify-center font-bold flex-shrink-0">2</span>
                        Akun Pengguna
                    </h3>
                    <p class="ml-7">Setiap pengguna bertanggung jawab penuh atas keamanan akun dan kata sandi. Segala aktivitas yang dilakukan melalui akun Anda menjadi tanggung jawab Anda sepenuhnya. Segera hubungi kami jika mendeteksi akses tidak sah.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1.5 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-green-100 text-green-700 text-xs flex items-center justify-center font-bold flex-shrink-0">3</span>
                        Ketentuan Petani (Penjual)
                    </h3>
                    <ul class="ml-7 space-y-1 list-disc list-inside marker:text-emerald-400">
                        <li>Wajib memastikan produk yang dijual segar, aman dikonsumsi, dan merupakan hasil hidroponik</li>
                        <li>Deskripsi, harga, dan foto produk harus akurat dan tidak menyesatkan</li>
                        <li>Wajib memproses pesanan dalam waktu 1x24 jam setelah pembayaran dikonfirmasi</li>
                        <li>Dilarang keras menjual produk yang mengandung bahan berbahaya</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1.5 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-teal-100 text-teal-700 text-xs flex items-center justify-center font-bold flex-shrink-0">4</span>
                        Ketentuan Pembeli
                    </h3>
                    <ul class="ml-7 space-y-1 list-disc list-inside marker:text-teal-400">
                        <li>Wajib memberikan alamat pengiriman yang valid dan lengkap</li>
                        <li>Komplain terkait kualitas produk dapat diajukan maksimal 24 jam setelah barang diterima</li>
                        <li>Pembayaran wajib dilakukan melalui metode yang tersedia di platform</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1.5 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 text-xs flex items-center justify-center font-bold flex-shrink-0">5</span>
                        Privasi & Keamanan Data
                    </h3>
                    <p class="ml-7">Data pribadi Anda (nama, email, alamat, nomor HP) hanya digunakan untuk keperluan transaksi di platform SIPSH dan tidak akan dijual atau disebarkan kepada pihak ketiga tanpa persetujuan Anda.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1.5 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-700 text-xs flex items-center justify-center font-bold flex-shrink-0">6</span>
                        Penyelesaian Sengketa
                    </h3>
                    <p class="ml-7">Setiap perselisihan antara petani dan pembeli akan diselesaikan melalui mediasi admin SIPSH. Keputusan admin bersifat final dan mengikat kedua pihak.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 text-xs text-gray-500 mb-4"
             x-data="{ scrolled: false }"
             x-init="
                 let el = $el.previousElementSibling;
                 el.addEventListener('scroll', () => {
                     scrolled = (el.scrollTop + el.clientHeight) >= el.scrollHeight - 10;
                 });
             ">
            <i data-lucide="info" class="w-3.5 h-3.5 flex-shrink-0"></i>
            <span x-show="!scrolled">Gulir ke bawah untuk membaca seluruh ketentuan</span>
            <span x-show="scrolled" class="text-emerald-600 flex items-center gap-1">
                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                Ketentuan telah dibaca
            </span>
        </div>

        <form method="POST" action="{{ route('terms.accept') }}" x-data="{ checked: false }">
            @csrf
            <label class="flex items-start gap-3 cursor-pointer mb-5 group">
                <input type="checkbox" name="accept" required x-model="checked" class="mt-0.5 w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" />
                <span class="text-sm text-gray-600 leading-relaxed">
                    Saya telah membaca dan <strong class="text-gray-800">menyetujui</strong> seluruh Syarat & Ketentuan di atas dan bersedia mematuhinya
                </span>
            </label>

            <button type="submit"
                    :disabled="!checked"
                    :class="checked ? 'bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-700 hover:to-emerald-600 shadow-lg shadow-emerald-500/25 cursor-pointer' : 'bg-gray-200 text-gray-500 cursor-not-allowed'"
                    class="w-full py-3 px-6 rounded-xl font-semibold text-sm transition-all duration-300 flex items-center justify-center gap-2 text-white active:scale-[0.98]">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                Setuju & Lanjutkan Pendaftaran
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ url()->previous() }}"
               onclick="if(history.length > 2){ event.preventDefault(); history.back(); }"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-emerald-600 transition-colors">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                Kembali ke halaman sebelumnya
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:initialized', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>
</x-guest-layout>
