# Progres Hidroponik — 18 Juni 2026

## Apa yang sudah dikerjakan

### Figma Design Adoption — SELESAI
- Design tokens (`app.css`): CSS variables Figma
- 13 Blade components: button (5 varian), card, input, badge (7 varian), select, checkbox, label, separator, avatar (4 size), pagination, sheet, tabs, slider
- Redesain: Login (split layout), Register (3-step stepper), Landing page (hero + features + cara kerja + testimonial + CTA)
- Creative effects: `effects.js` (3D tilt, magnetic buttons, parallax orbs, scroll reveal)
- Navbar component (`components/navbar.blade.php`) — simple, pakai Auth logic

### Code Audit & Bug Fixes — SELESAI
- 5 critical bugs: branding column login, CDN Alpine conflict, guest footer contrast, duplicate bell, inline scroll reveal
- 7 high-priority: 277 aria-hidden, effects.js optimization, dead CSS removal, font dedup, admin dashboard fix
- 3 medium: `<main>` landmarks, navbar Alpine menu, duplicate keyframes

## Yang BELUM selesai
- Shop, product detail, cart — belum di-redesign
- `layouts/navigation.blade.php` — navbar lama masih dipake di app layout
- Guest layout — masih desain lama
- `scrollbar-hide` class undefined di `shop/index.blade.php`
- Konflik Tailwind v3/v4 di `package.json`

## Perubahan navbar landing page (terakhir)
- Link Belanja dihapus — sudah ada tombol "Mulai Belanja" di hero
- Cuma Masuk/Daftar + logo (guest) atau Dashboard/Keluar (auth)
- Link Petani/Admin dihapus dari public navbar (route-nya auth protected)
- Auth-aware: guest lihat Masuk/Daftar, user login lihat Dashboard + Keluar

## Live Search — BARU
- Route: `GET /api/products/search?q=...` → ShopController@suggestions
- Method: ShopController.php suggestions() — return JSON (id, name, slug, price, unit, image)
- Frontend: Alpine.js di shop/index.blade.php — `x-model="query"`, `@input.debounce.300ms`, dropdown hasil
- Tes: "to" → muncul Tomat Cherry & Tomat Beef

## Database Migrations Baru (17 Juni 2026)
- **Tabel baru:** `laporan`, `rekomendasi`, `notifications`, `stok_nutrisi`, `panen`, `transaksi`, `log_transaksi`
- **Kolom baru:** `lama_tanam_hari`, `tanggal_tanam` di `products`; `metode_pengiriman` di `orders`; `verified_by` di `petani_profiles`

## Guest Layout — SUDAH DI-REDESIGN (berbeda dgn catatan sebelumnya)
- Green gradient bg, animated decorative orbs (`guest-orb`), floating leaf/sprout icons (Lucide)
- Logo + subtitle "Sistem Informasi Penjualan Sayuran Hidroponik"
- Guest card slot + footer
- CSS: `resources/css/guest.css`

## Shop, Product Detail, Cart — SUDAH IMPLEMENT (tapi blm diverifikasi Figma)
- **Shop index** (`shop/index.blade.php`, 318 baris): Hero section, live search Alpine (`x-model`, `@input.debounce.300ms`), category filter pills, sort dropdown, 4-col grid, pagination
- **Product detail** (`shop/show.blade.php`, 221 baris): Breadcrumb, gallery, info, qty selector + add-to-cart, farmer box, related products
- **Cart** (`cart/index.blade.php`, 188 baris): Empty state, produk list dgn +/- controls, subtotal, ringkasan pesanan, kupon (placeholder), GRATIS ongkir

## Bug & Issues — full audit 18 Juni 2026

### CRITICAL (1)
| Issue | File | Detail |
|-------|------|--------|
| `$avgRating` undefined di petani dashboard | `DashboardController.php:62` | `$avgRating` tidak didefinisikan di controller, tapi direferensi di `petani/dashboard.blade.php:105,114` |

### HIGH (4)
| Issue | File | Detail |
|-------|------|--------|
| `Order::petani()` — relasi broken | `Order.php:45` | `whereHas('products')` — Order model tidak punya `products()` relationship |
| Tailwind v3/v4 conflict | `package.json` | `tailwindcss ^3.1.0` vs `@tailwindcss/vite ^4.0.0` — dua versi, dua approach (postcss vs vite plugin) |
| Dual role system | `User.php`, `web.php` | Kolom `role` manual + Spatie `HasRoles` — auth redirect pakai `$user->role`, berpotensi inkonsisten |
| `alamat` user tidak diisi saat register | `RegisteredUserController.php:59-66` | Register hanya set `no_hp`, tidak set `alamat` — field `alamat` di users selalu null |

### MEDIUM (6)
| Issue | File | Detail |
|-------|------|--------|
| `metode_pengiriman` tidak ada UI | `orders/checkout.blade.php` | Kolom sudah di migration, tapi form checkout tidak punya shipping method selector |
| Kupon placeholder no-op | `cart/index.blade.php:156-161` | Input kupon + tombol "Pakai" tidak melakukan apa-apa |
| `scrollbar-hide` undefined | `shop/index.blade.php:108` | Utility class tidak terdefinisi di Tailwind/CSS |
| Navbar lama masih dipakai | `layouts/app.blade.php:20` | Masih `@include('layouts.navigation')` — `components/navbar.blade.php` tidak dipakai |
| Inline styles massif | `auth/login.blade.php`, `auth/register.blade.php` | Login (214 baris) & Register (334 baris) pakai inline styles, bukan Blade components |
| Dual registration flow | `routes/auth.php:18-22`, `auth/register.blade.php` | Ada route `register/petani` + `register/pembeli` tapi juga Alpine step form — dua path |

### LOW (7)
| Issue | File | Detail |
|-------|------|--------|
| Lucide via CDN di setiap halaman | Semua layout | `unpkg.com/lucide@0.468.0` — seharusnya via Vite import |
| `NotifikasiController::send()` static | `Admin/UserController.php:45` | Dipanggil sebagai static method — unconventional Laravel pattern |
| `register-petani.blade.php` & `register-pembeli.blade.php` | `views/auth/` | Dua view terpisah yang mungkin outdated |
| Cart count query inline di navbar lama | `layouts/navigation.blade.php:~191` | `\App\Models\Cart::where(...)->count()` — seharusnya pakai `$cartCount` dari `LayoutComposer` |
| `$pendingPetani` fallback collect() | `admin/dashboard.blade.php:212` | `$pendingPetani ?? collect()` — sudah passing dari controller, fallback ga perlu |
| Duplicate keyframes di guest.css | `guest.css:98` | `/* keyframes fadeIn, slideUp, orbFloat defined in app.css */` — comment aja sih |
| Chart bar hardcoded | `admin/dashboard.blade.php:100-101` | Data pendapatan bulanan dummy (`$values = [35,48,...]`) — bukan dari DB |

## Layout Architecture
| Layout | Navbar | Status |
|--------|--------|--------|
| `layouts/app.blade.php` | `@include('layouts.navigation')` (lama, 233 baris) | **Perlu migrasi** ke component |
| `layouts/guest.blade.php` | Inline (logo + subtitle) | ✅ Redesigned |
| `layouts/admin.blade.php` | Sidebar (dark green, 239 baris) | ✅ OK |
| `layouts/petani.blade.php` | Sidebar (green, 241 baris) | ✅ OK |
| `layouts/pembeli.blade.php` | Sidebar (teal, 245 baris) | ✅ OK |
| `components/navbar.blade.php` | Component style | ✅ Ada tapi **tidak dipakai** |

## Codebase Stats
| Metric | Count |
|--------|-------|
| Models | 16 |
| Controllers | 26 |
| Blade views | 80+ |
| Migrations | 22 |
| CSS files | 3 (`app.css`, `guest.css`) |
| JS files | 3 (`app.js`, `bootstrap.js`, `effects.js`) |
| Packages (composer) | Laravel 12, Spatie Permission, DomPDF, Maatwebsite Excel |
| Packages (npm) | Tailwind v3/v4, Alpine.js, Vite 7, Lucide |

## Full Feature Map
| Feature | Status | Middleware |
|---------|--------|------------|
| Landing page (welcome) | ✅ | guest |
| Shop (index + show) | ✅ | public |
| Live search API | ✅ | public |
| Cart (CRUD) | ✅ | auth |
| Checkout + Order | ✅ | auth |
| Payment upload | ✅ | auth |
| Dashboard redirect (role-based) | ✅ | auth, verified |
| Admin: users, categories, orders | ✅ | auth, role:admin |
| Admin: transaksi, reports, logs | ✅ | auth, role:admin |
| Petani: products, orders, panen, nutrisi | ✅ | auth, role:petani |
| Pembeli: dashboard | ✅ | auth, role:pembeli |
| Profile (edit, password, delete) | ✅ | auth |
| Notifications | ✅ | auth |
| Auth (login, register, reset, verify) | ✅ | guest/auth |

## Sudah diperbaiki (18 Juni 2026)
| # | Issue | Fix |
|---|-------|-----|
| 1 | `$avgRating` undefined | `DashboardController.php:62` — ditambah `$avgRating = 0` + di-pass ke view |
| 2 | `Order::petani()` broken | `Order.php:45` — method dihapus (dead code, tidak dipanggil) |
| 3 | Tailwind v3/v4 conflict | `package.json` — `@tailwindcss/vite` dihapus, pake v3 via PostCSS |
| 4 | Navbar lama di app layout | `layouts/app.blade.php` — ganti `@include('layouts.navigation')` ke `<x-navbar />` |
| 5 | `scrollbar-hide` undefined | `app.css` — ditambah utility `scrollbar-hide` |
| 6 | `alamat` user tidak diisi | `RegisteredUserController.php` — simpan `lokasi_kebun` ke `alamat` user |
| 7 | `lokasi_kebun` validasi pembeli | Ditambah rule `nullable|string|max:255` untuk role pembeli |

## Todo — masih perlu
1. 🟠 Implementasi `metode_pengiriman` di checkout
2. 🟡 Implementasi kupon atau hapus placeholder
3. 🟡 Seeder / data dummy untuk testing
4. 🟡 Git init + first commit

## Notes
- Jangan `php artisan route:cache` atau `optimize` tanpa `--except=routes` (bug 405 di route `/`)
- `npm run build` — selalu sukses
- Font: Plus Jakarta Sans via HTML `<link>`, override `font-sans` di tailwind.config.js
- Server test: `php artisan serve --port=8080`
- Belum ada git repo — `git init` dulu kalau mulai tracking
