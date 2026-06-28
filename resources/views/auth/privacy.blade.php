<x-guest-layout>
    <div>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                <i data-lucide="shield" class="w-5 h-5 text-emerald-600"></i>
            </div>
            <div>
                <h2 class="text-xl font-heading font-bold text-gray-900">Kebijakan Privasi</h2>
                <p class="text-xs text-gray-500 mt-0.5">Terakhir diperbarui: {{ date('d F Y') }}</p>
            </div>
        </div>

        <div class="max-h-72 overflow-y-auto rounded-xl border border-gray-100 bg-gray-50/80 p-4 mb-5 scrollbar-thin scrollbar-thumb-emerald-200 scrollbar-track-transparent">
            <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1.5 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 text-xs flex items-center justify-center font-bold flex-shrink-0">1</span>
                        Data yang Dikumpulkan
                    </h3>
                    <p class="ml-7">Kami mengumpulkan data pribadi yang Anda berikan saat mendaftar, termasuk nama lengkap, alamat email, nomor telepon, alamat pengiriman, dan informasi akun lainnya. Data ini diperlukan untuk memproses transaksi dan memberikan layanan terbaik.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1.5 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 text-xs flex items-center justify-center font-bold flex-shrink-0">2</span>
                        Penggunaan Data
                    </h3>
                    <p class="ml-7">Data pribadi Anda digunakan untuk:</p>
                    <ul class="ml-7 mt-1 space-y-1 list-disc list-inside marker:text-emerald-400">
                        <li>Memproses dan mengelola pesanan Anda</li>
                        <li>Mengirimkan notifikasi terkait transaksi</li>
                        <li>Meningkatkan kualitas layanan platform</li>
                        <li>Melakukan verifikasi akun pengguna</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1.5 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-green-100 text-green-700 text-xs flex items-center justify-center font-bold flex-shrink-0">3</span>
                        Keamanan Data
                    </h3>
                    <p class="ml-7">Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai untuk melindungi data pribadi Anda dari akses tidak sah, perubahan, pengungkapan, atau penghancuran. Seluruh data disimpan di server yang aman dengan enkripsi yang memadai.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1.5 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-teal-100 text-teal-700 text-xs flex items-center justify-center font-bold flex-shrink-0">4</span>
                        Pembagian Data ke Pihak Ketiga
                    </h3>
                    <p class="ml-7">Kami tidak menjual, menukar, atau menyewakan data pribadi Anda kepada pihak ketiga. Data hanya dibagikan dengan mitra tepercaya yang membantu pengoperasian platform (seperti jasa pengiriman) dan hanya sebatas yang diperlukan untuk layanan tersebut.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1.5 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 text-xs flex items-center justify-center font-bold flex-shrink-0">5</span>
                        Hak Anda
                    </h3>
                    <p class="ml-7">Anda berhak untuk mengakses, memperbarui, atau menghapus data pribadi Anda kapan saja melalui pengaturan akun. Untuk permintaan penghapusan akun secara permanen, silakan hubungi admin melalui halaman dukungan.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1.5 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-700 text-xs flex items-center justify-center font-bold flex-shrink-0">6</span>
                        Perubahan Kebijakan
                    </h3>
                    <p class="ml-7">Kebijakan privasi ini dapat diperbarui sewaktu-waktu. Perubahan signifikan akan diberitahukan melalui email atau pemberitahuan di platform. Dengan terus menggunakan SIPSH setelah perubahan, Anda menyetujui kebijakan yang telah diperbarui.</p>
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

        <a href="{{ url()->previous() }}"
           onclick="if(history.length > 2){ event.preventDefault(); history.back(); }"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-emerald-600 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke halaman sebelumnya
        </a>
    </div>

    <script>
        document.addEventListener('alpine:initialized', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>
</x-guest-layout>
