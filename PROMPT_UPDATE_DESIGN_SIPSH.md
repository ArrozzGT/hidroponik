# PROMPT UPDATE DESAIN — SIPSH (Fresh Produce Theme + 3D Hero)

> Tempel prompt ini ke Cursor / Windsurf / Aider. Referensi visual: screenshot dark plant-shop
> (kartu produk rounded di atas background gelap, heading serif dengan aksen garis hijau,
> tone premium boutique). Tujuan: pertahankan mood premium itu, tapi ganti palet ke nuansa
> "sayur & buah segar" dan tambahkan elemen 3D animasi di hero landing page.

---

## 0. Konteks Proyek (jangan diubah)

- Laravel 12 + Blade, Tailwind CSS 3, Alpine.js 3.4 + Turbo Drive 8, Vite 7, ikon Lucide
- Font: Instrument Sans (heading) + Inter (body)
- Layout: `guest.blade.php`, `app.blade.php`, `admin/petani/pembeli.blade.php`
- Role warna existing: Admin = emerald, Petani = green, Pembeli = teal
- **Jangan** tambahkan framework CSS lain (no Bootstrap/Bulma). Semua tetap Tailwind utility.

Tugas kamu: **redesign visual layer** (warna, hero, kartu produk, dashboard) — bukan
mengubah struktur backend/route/logic Laravel yang sudah ada.

---

## 1. Konsep Warna Baru — "Fresh Produce, Not Just Green"

Masalah palet lama: terlalu monoton emerald/teal. Referensi desain punya kontras dramatis
(background gelap + objek yang menyala). Kita adopsi kontras itu, tapi aksen warnanya
diambil dari warna sayur & buah asli, bukan cuma hijau.

### Base (dark mode, dominan)
```js
// tailwind.config.js — tambahkan token baru, JANGAN hapus emerald/teal lama
colors: {
  // Background gelap ala referensi (bukan hitam pekat, ada undertone hijau tua)
  surface: {
    950: '#0B1710', // bg utama dark mode
    900: '#12241A',
    800: '#1B3226',
    700: '#26452F',
  },
  // Aksen "sayur segar" — dipakai bergantian per konteks, bukan cuma satu warna
  produce: {
    lettuce:  '#7ED957', // hijau segar selada/bayam hidroponik
    tomato:   '#E8543E', // merah tomat — untuk badge diskon, alert, harga spesial
    carrot:   '#F4A340', // oranye wortel — untuk CTA sekunder, rating, highlight
    lemon:    '#F2D53C', // kuning lemon — untuk badge "baru" / promo
    eggplant: '#5B3A6B', // ungu terong — aksen dekoratif, jarang, untuk variasi
    basil:    '#2F6B3A', // hijau tua daun basil — untuk teks/ikon di atas surface terang
  },
}
```

### Aturan pakai
- **Background dark mode** pakai `surface.950/900` (bukan `gray-900` generik) supaya tetap
  terasa "hidroponik" bukan netral.
- **Satu aksen dominan per section**, jangan campur >2 aksen produce dalam satu kartu.
  Contoh: hero pakai `lettuce`, badge diskon pakai `tomato`, rating bintang pakai `carrot`.
- Foto produk (sayur/buah) jadi hero visual utama — background gelap dibuat sengaja polos
  supaya foto/objek 3D yang "pop" keluar, persis seperti referensi.
- Light mode tetap pakai emerald/teal existing supaya konsisten sama role dashboard.
  Dark mode baru ini khusus untuk landing page + shop publik (opsional: toggle dark mode
  di seluruh app sesuai kelemahan #1 di DESIGN_BRIEF).

### Kontras & aksesibilitas
- Teks di atas `surface.950/900` pakai putih `#F5F5F0` atau `produce.lemon` untuk heading,
  jangan pakai `produce.eggplant` untuk teks kecil (kontras kurang).
- Ikuti aturan AA yang sudah ada di DESIGN_BRIEF (4.5:1 teks normal, 3:1 teks besar).

---

## 2. Hero Landing Page — Tambah Objek 3D Animasi

### Konsep
Hero section dengan background `surface.950`, judul serif besar (Instrument Sans), dan
**objek 3D sayur/buah hidroponik yang melayang & berotasi pelan** di sisi kanan — meniru
pot tanaman besar blur di referensi, tapi versi kita: sayuran hidroponik (selada, kangkung,
tomat ceri) mengambang dengan efek parallax mengikuti mouse.

### Pilihan teknis (pilih salah satu, urutan dari termudah)

**Opsi A — Spline (paling cepat, tanpa coding 3D manual)**
1. Buat scene di https://spline.design — model sederhana sayur/pot hidroponik (bisa pakai
   asset gratis dari Spline community + edit warna sesuai palet `produce`).
2. Export sebagai "Code Export" → dapat tag `<spline-viewer>` web component.
3. Install runtime: `npm install @splinetool/viewer`
4. Import di `resources/js/app.js`:
   ```js
   import '@splinetool/viewer';
   ```
5. Pasang di `resources/views/welcome.blade.php` bagian hero:
   ```html
   <spline-viewer
     url="/build/assets/hero-scene.splinecode"
     class="w-full h-[420px] lg:h-[560px]"
     loading="lazy">
   </spline-viewer>
   ```
6. Beri `will-change: transform` dan bungkus dengan `<div class="pointer-events-none lg:pointer-events-auto">`
   agar tidak mengganggu scroll di mobile.

**Opsi B — Three.js custom (kalau mau kontrol penuh & tanpa dependency Spline)**
1. `npm install three`
2. Buat file `resources/js/hero-3d.js`:
   - Scene + PerspectiveCamera + WebGLRenderer transparan (`alpha: true`)
   - Load model GLTF sayur (cari di Sketchfab/Poly Pizza, lisensi CC0) atau bikin primitive
     shape (SphereGeometry + warna `produce.tomato`, `produce.lettuce`) kalau belum ada aset
   - Animasi: rotasi Y lambat (`0.003 rad/frame`) + bobbing naik-turun sinusoidal
   - Parallax: update `camera.position.x/y` berdasarkan `mousemove` (lerp halus, jangan snap)
   - Render loop pakai `requestAnimationFrame`
   - **Wajib**: cek `prefers-reduced-motion` — kalau aktif, hentikan animasi rotasi/parallax
     dan tampilkan objek statis (sesuai poin aksesibilitas #5 di DESIGN_BRIEF)
2. Panggil di Blade:
   ```html
   <canvas id="hero-3d-canvas" class="absolute inset-0 -z-0"></canvas>
   ```
3. Import & init di `resources/js/app.js`, hanya jalan di halaman yang punya elemen ini
   (cek `document.getElementById('hero-3d-canvas')` sebelum init, supaya tidak load Three.js
   di semua halaman).

**Opsi C — Fallback ringan (kalau performa/waktu terbatas)**
- Gunakan Lottie animation (ilustrasi 2.5D sayur berputar) via `lottie-web`, jauh lebih
  ringan dari WebGL, masih terasa "hidup" walau bukan 3D asli.

### Rekomendasi
Untuk timeline cepat dan tim kecil: **pakai Opsi A (Spline)**. Kualitas visual tinggi tanpa
harus menulis shader/animasi manual, dan tetap ringan kalau di-`loading="lazy"`.

---

## 3. Product Card Redesign (Shop & Landing "Produk Unggulan")

Adaptasi langsung dari referensi:
- Card: `bg-surface-900 rounded-3xl shadow-card p-4`, foto produk `aspect-square object-contain`
  dengan sedikit drop-shadow di bawah foto (bukan foto flat menempel background)
- Nama produk: font Instrument Sans, putih/`lemon`
- Harga: bold, warna `produce.carrot` (bukan hijau — biar beda dari nama produk & badge stok)
- Tombol keranjang: icon-only bulat outline (seperti referensi), border `produce.lettuce`,
  hover jadi solid fill
- Badge stok/kategori: pill kecil di pojok, warna sesuai konteks
  (`tomato` = stok menipis, `lettuce` = stok banyak, `lemon` = produk baru)
- Efek hover: scale `1.02` + shadow naik ke `shadow-card-hover`, transisi 200ms — jangan
  hilangkan tilt 3D on mousemove yang sudah ada, cukup diselaraskan ke card baru ini

---

## 4. Section "Testimoni/Ulasan" (meniru "Customer Review" di referensi)

- Card `bg-surface-900/60 backdrop-blur rounded-2xl p-5`
- Avatar bulat + nama + rating bintang warna `produce.carrot`
- Border tipis `border-surface-700` supaya kartu tetap terbaca di atas background gelap

---

## 5. Heading Style (aksen garis seperti referensi "Our Top Selling")

```html
<h2 class="flex items-center gap-3 font-heading text-3xl lg:text-4xl text-white">
  <span class="h-8 w-1 rounded-full bg-produce-lettuce"></span>
  Sayuran Terlaris
  <span class="h-8 w-1 rounded-full bg-produce-lettuce"></span>
</h2>
```
Gunakan pola ini konsisten untuk semua heading section di landing page.

---

## 6. File yang Perlu Disentuh

| File | Perubahan |
|---|---|
| `tailwind.config.js` | Tambah token `surface.*` dan `produce.*` |
| `resources/views/welcome.blade.php` | Hero baru + section produk unggulan + testimoni |
| `resources/views/shop/index.blade.php` | Product card redesign |
| `resources/js/app.js` | Import Spline/Three.js, guard supaya tidak load di semua halaman |
| `resources/css/app.css` | Utility tambahan untuk shadow-card kalau belum ada |
| (baru) `resources/js/hero-3d.js` | Kalau pilih Opsi B |

---

## 7. Kriteria Selesai (Acceptance Criteria)

- [ ] Hero landing page menampilkan objek 3D yang beranimasi halus (rotasi + parallax ringan)
- [ ] Animasi 3D otomatis nonaktif/statis saat `prefers-reduced-motion: reduce`
- [ ] Palet baru (`surface.*`, `produce.*`) dipakai konsisten di landing page & shop, tanpa
      menghapus token emerald/teal yang dipakai dashboard admin/petani/pembeli
- [ ] Kontras teks tetap memenuhi AA (cek pakai devtools contrast checker)
- [ ] Product card & heading section mengikuti pola visual di poin 3 & 5
- [ ] Tidak ada framework CSS baru yang ditambahkan selain Tailwind
- [ ] Performa: 3D asset di-lazy-load, tidak memblok First Contentful Paint halaman lain

---

## 8. Catatan Tambahan untuk Agent

Jangan redesain dashboard admin/petani/pembeli dalam task ini — fokus dulu ke landing page
+ shop publik sesuai prioritas di `DESIGN_BRIEF.md` (Design System > Landing Page > Dashboard
> Shop > Cart/Checkout > Auth). Kalau butuh warna tambahan di luar palet `produce.*` di atas,
tetap turunkan dari warna sayur/buah asli (contoh: `avocado`, `paprika`) — jangan pakai warna
generik dari default Tailwind palette (blue-500, purple-500, dst).
