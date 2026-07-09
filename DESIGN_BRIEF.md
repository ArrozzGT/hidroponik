# Design Brief — SIPSH

**Proyek:** Sistem Informasi Penjualan Sayuran Hidroponik (SIPSH)
**Untuk:** Stitch (Designer)
**Tanggal:** Juli 2026

---

## 1. Ringkasan Proyek

Marketplace multi-role untuk jual-beli sayuran hidroponik di Sambas, Kalimantan Barat.
Ada 3 tipe pengguna dengan tampilan dashboard masing-masing.

### Role Pengguna

| Role | Warna | Icon |
|---|---|---|
| **Admin** | Emerald | leaf |
| **Petani** (penjual) | Green | sprout |
| **Pembeli** (pembeli) | Teal | shopping-bag |

---

## 2. Tech Stack

| Lapisan | Teknologi |
|---|---|
| Backend | Laravel 12 (Blade templating) |
| CSS Framework | Tailwind CSS 3 (utility-first) |
| Frontend JS | Alpine.js 3.4 + Turbo Drive 8 |
| Icons | Lucide |
| Build | Vite 7 |
| Font | Inter (body) + Instrument Sans (heading) |

> **Penting:** Semua desain harus kompatibel dengan Tailwind CSS utility classes. Tidak boleh menggunakan CSS framework lain (Bootstrap, Bulma, dll).

---

## 3. Layout Hierarchy

| Layout | Digunakan Untuk |
|---|---|
| `guest.blade.php` | Login, Register, Lupa Password |
| `app.blade.php` | Shop, Cart, Checkout, Orders, Profile |
| `admin.blade.php` | Dashboard admin, manajemen user/kategori/laporan |
| `petani.blade.php` | Dashboard petani, produk, panen, stok nutrisi |
| `pembeli.blade.php` | Dashboard pembeli |

### Struktur Layout

```
guest layout:
┌─────────────────────┬──────────────────┐
│   Left Panel        │  Right Panel     │
│   (green gradient)  │  (white form)    │
│   - brand           │  - form          │
│   - features        │  - link          │
│   - decorative      │                  │
│   circles           │                  │
└─────────────────────┴──────────────────┘

app layout:
┌──────────────────────────────────────┐
│  Navbar (sticky, responsive)         │
├──────────────────────────────────────┤
│  @yield('header') — optional header  │
├──────────────────────────────────────┤
│  @yield('content') / {{ $slot }}     │
├──────────────────────────────────────┤
│  Footer                              │
└──────────────────────────────────────┘

dashboard layout (admin/petani/pembeli):
┌──────────────┬───────────────────────────┐
│  Sidebar     │  Topbar                   │
│  (fixed)     │  (breadcrumb + user menu) │
│              ├───────────────────────────┤
│  - brand     │  Main Content             │
│  - nav       │                           │
│  - user      │                           │
│  - logout    │                           │
└──────────────┴───────────────────────────┘
```

---

## 4. Current Design Analysis

### ✅ Kekuatan (Pertahankan)

1. **Warna hijau/emerald** — sangat cocok untuk tema agrikultur/hidroponik
2. **Role-based theming** — admin (emerald), petani (green), pembeli (teal) memberi identitas visual berbeda
3. **Component library** — 14 reusable UI components (card, button, badge, input, dll)
4. **Micro-interactions** — scroll reveal, tilt 3D, magnetic button, fly-to-cart, ripple
5. **Loading states** — skeleton loader, animated count-up, loading button spinner
6. **Empty states** — setiap halaman kosong punya ilustrasi + CTA

### ❌ Kelemahan (Perlu Diperbaiki)

1. **Tidak ada dark mode**
2. **Guest/login layout** — split-screen standar, kurang menarik
3. **Product card** — fungsional tapi belum premium
4. **Dashboard** — agak generik, bisa lebih modern
5. **Cart & Checkout** — layout fungsional, kurang engaging
6. **Footer** — belum menonjol
7. **Mobile experience** — ok tapi bisa diimprove
8. **Aksesibilitas** — beberapa kontras warna perlu diperbaiki

---

## 5. Halaman yang Perlu Didesain

### 5.1 Design System (Prioritas Tertinggi)

Buat component library di Figma dengan:

#### Colors
- Primary scale (emerald 50-950, sudah ada)
- Secondary (teal/water, lime/leaf)
- Neutral (gray scale)
- Semantic (success, warning, danger, info)
- Dark mode colors

#### Typography
- Heading: Instrument Sans (400-700)
- Body: Inter (300-700)
- Mono: JetBrains Mono
- Size scale: xs/sm/base/lg/xl/2xl/3xl/4xl/5xl/6xl/7xl
- Line height & letter spacing

#### Komponen
- **Button** — 5 varian (primary, secondary, outline, ghost, danger), 4 ukuran (sm/md/lg/xl), icon support, loading state
- **Card** — 4 varian (default, bordered, flat, hover), padding variabel
- **Input** — text, password (toggle), search, icon prefix, error state, disabled
- **Badge** — 7 varian (default, primary, success, warning, danger, info, outline)
- **Select** — native styled
- **Checkbox/Radio** — custom styled
- **Modal** — sizes (sm/md/lg/full), close button, backdrop
- **Tabs** — horizontal, underline style
- **Sheet** — slide-out panel (kanan/kiri)
- **Pagination** — numbered dengan prev/next
- **Avatar** — dengan fallback initial
- **Separator** — horizontal/vertical
- **Slider** — range input
- **Breadcrumb** — dengan separator icon
- **Toast** — success/error/warning/info
- **Skeleton** — loading placeholder

### 5.2 Halaman Public

#### a. Landing Page (welcome)
- Hero section (gradient emerald, headline, CTA, stats counter)
- Floating decorative bubbles (animasi float)
- Features section (3 kolom, icon + title + desc)
- How It Works (4 langkah, numbered)
- Testimonials (card based)
- CTA section (background solid emerald)

#### b. Shop (Daftar Produk)
- Hero kecil (emerald, search bar, breadcrumb)
- Sticky filter bar (category pills horizontal scroll, sort dropdown)
- Product grid (1-4 kolom responsive)
- Product card (image aspect-square, category tag, stock badge, price, add-to-cart)
- Pagination
- Empty state
- Skeleton loading

#### c. Shop Detail
- Image galeri + product info (2/3 + 1/3 grid)
- Price, unit, stock indicator
- Quantity stepper
- Add to cart button
- Seller info card
- Category & tags

#### d. Cart
- Daftar item (image, name, price, qty, subtotal, delete)
- Coupon input
- Cart summary (subtotal, shipping, total)
- Checkout button
- Empty cart state

#### e. Checkout
- 3 sections: Alamat, Pengiriman, Pembayaran
- Order summary sidebar
- Confirmation checkbox
- Place order button

#### f. Auth Pages (Login, Register, Lupa Password)
- Split-screen layout
- Left panel: brand, feature list, decorative elements
- Right panel: form dengan social login option

### 5.3 Halaman Dashboard

#### a. Admin Dashboard
- Stats cards (users, products, orders, petani)
- Revenue chart (bar/mini)
- Recent orders table
- Quick actions grid
- Activity log

#### b. Petani Dashboard
- Revenue stat + progress bar
- Produk terbaru list
- Pesanan masuk
- Quick action cards (add product, harvest, nutrition stock)
- Alert verification (jika belum verifikasi)

#### c. Pembeli Dashboard
- Welcome banner dengan CTA
- Order status cards (unpaid, processing, shipped, completed)
- Recent orders list
- Notifikasi terbaru

### 5.4 Halaman CRUD (Index, Create, Edit)

- Data table dengan search & filter
- Form layout (create/edit)
- Delete confirmation modal
- Export buttons

---

## 6. Design Spesifikasi

### Layout Grid
- Max width konten: **1280px** (`max-w-7xl`)
- Padding horizontal: `px-4 sm:px-6 lg:px-8`
- Padding section: `py-8 sm:py-12 lg:py-16`
- Gap system: `gap-4`, `gap-6`, `gap-8`

### Breakpoints
| Prefix | Min Width |
|---|---|
| `sm` | 640px |
| `md` | 768px |
| `lg` | 1024px |
| `xl` | 1280px |

### Border Radius
| Level | Value | Kelas |
|---|---|---|
| Small | 6px | `rounded-md` |
| Default | 8px | `rounded-lg` |
| Large | 12px | `rounded-xl` |
| Extra Large | 32px | `rounded-4xl` |
| Full | 999px | `rounded-full` |

### Shadow (Custom)
| Nama | Penggunaan |
|---|---|
| `shadow-soft` | Navbar scroll |
| `shadow-soft-md` | Card hover |
| `shadow-soft-lg` | Modal, dropdown |
| `shadow-elegant` | Card default |
| `shadow-card` | Product card |
| `shadow-card-hover` | Product card hover |
| `shadow-glow-em` | Highlight, emerald glow |

### Animasi (Existing)
| Nama | Durasi | Penggunaan |
|---|---|---|
| `gradient-x` | 3s linear infinite | Hero bg |
| `float` | 6-10s ease-in-out infinite | Bubbles |
| `pulse-soft` | 2s ease-in-out infinite | Notifikasi |
| `bounce-soft` | 2s ease-in-out infinite | Sosial media |
| `shimmer-sweep` | 1.5s linear infinite | Skeleton |
| `fade-up` | 0.5s ease-out | Scroll reveal |
| `fade-in` | 0.25s ease-out | Page transition |
| `fly-to-cart` | 0.6s ease-in | Add to cart |
| tilt 3D | Mousemove | Product card |

### Responsive Behavior per Layout

**Dashboard (Admin/Petani/Pembeli):**
| Elemen | Mobile (< lg) | Desktop (>= lg) |
|---|---|---|
| Sidebar | Hidden, toggle with hamburger + overlay | Fixed visible, `w-64 xl:w-72` |
| Main content | Full width | `ml-64 xl:ml-72` |
| Topbar | Bisa scroll, hamburger visible | Breadcrumb visible, full width |
| Stats grid | 1 col `->` 2 col | 4 col |

**Public (App Layout):**
| Halaman | Mobile | Desktop |
|---|---|---|
| Shop | 1 col | 4 col (xl:grid-cols-4) |
| Cart | Stack vertical | Side-by-side (list + summary) |
| Checkout | Single column | 3 column grid |
| Footer | 1 col | 4 col |

---

## 7. Aksesibilitas (Harus Diperhatikan)

1. **Color contrast** — minimal AA (4.5:1 untuk normal text, 3:1 untuk large text)
   - Hindari `text-emerald-300` di atas `bg-emerald-800`
   - Hindari `text-teal-200` di atas `bg-teal-700`
2. **Focus indicators** — setiap interactive element harus punya visible focus ring
3. **Touch targets** — minimal 44x44px untuk elemen yang bisa diklik
4. **Dark mode** — sediakan color token untuk tema gelap
5. **Reduced motion** — semua animasi harus bisa dimatikan via `prefers-reduced-motion`
6. **Skip navigation** — tambahkan skip link di setiap layout

---

## 8. Output yang Dibutuhkan Developer

1. **Figma file** dengan:
   - Design system / component library
   - Semantic colors (light + dark mode tokens)
   - Typography scale
   - All pages (desktop + mobile)
   - Component states (hover, focus, active, disabled, error, loading)

2. **Spesifikasi teknis** (dokumentasi atau auto-layout di Figma):
   - Padding, margin, gap values
   - Font sizes, line heights
   - Shadow values (x, y, blur, spread, color + opacity)
   - Border radius values
   - Animation timing & easing
   - Grid column definitions

3. **Asset export**:
   - Ilustrasi custom (hero, empty states, 404)
   - Favicon & app icon
   - Logo variants (full, icon-only, light, dark)
   - Icon set tambahan (jika perlu di luar Lucide)
   - Background patterns / textures

4. **Color tokens** (Tailwind format):
```js
// contoh format
colors: {
  primary: {
    50: '#...',
    100: '#...',
    // ... hingga 950
  }
}
```

---

## 9. Catatan untuk Stitch

- **Style reference:** Modern SaaS (Linear, Vercel, Stripe) dengan sentuhan earthy/agricultural
- **Platform target:** Desktop-first, mobile-responsive
- **Browser support:** Chrome, Firefox, Safari, Edge (2 versi terakhir)
- **Timeline:** Sesuai kesepakatan
- **Prioritas:** Design System > Landing Page > Dashboard > Shop > Cart/Checkout > Auth

Jika ada pertanyaan atau perlu klarifikasi, silakan tanyakan. Terima kasih!
