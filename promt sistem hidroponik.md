# Prompt: Penyesuaian Web Sistem Informasi Penjualan Sayuran Hidroponik

> Gunakan prompt ini di Hermes/Claude dan arahkan ke folder project web kamu.

---

## Instruksi Utama

Saya memiliki sistem web **Sistem Informasi Penjualan Sayuran Hidroponik** yang sudah dibuat.
Tolong sesuaikan dan lengkapi sistem ini berdasarkan dokumentasi desain berikut.

---

## 1. Arsitektur Sistem

Sistem memiliki **3 aktor utama**:

| Aktor | Kemampuan |
|-------|-----------|
| **PETANI** (Penjual) | Register dengan verifikasi admin, CRUD produk, lihat pesanan masuk, update status pesanan |
| **PEMBELI** | Browse & search produk, keranjang belanja, checkout, lihat histori pesanan |
| **ADMIN** | Verifikasi petani, kelola kategori, kelola user, generate & export laporan |

---

## 2. Struktur Database (ERD)

### Tabel Pengguna

```sql
PETANI: id_petani, username, password, nama_lengkap, email, no_telepon, 
        alamat, tanggal_bergabung, status_verifikasi, id_admin_verifikasi

PEMBELI: id_pembeli, username, password, nama_lengkap, email, no_telepon, 
         alamat, tanggal_daftar, status_aktif

ADMIN: id_admin, username, password, nama_lengkap, email, role, created_at
```

### Tabel Produk & Stok

```sql
TANAMAN: id_tanaman, nama_tanaman, jenis, deskripsi, lama_tanam_hari, 
         harga_jual, tanggal_tanam, id_petani

STOK_SAYURAN: id_stok_sayur, id_tanaman, stok_tersedia_kg, 
              stok_minimum_kg, last_update

STOK_NUTRISI: id_stok_nutrisi, nama_nutrisi, stok_tersedia_liter, 
              stok_minimum_liter, last_update, id_petani

PANEN: id_panen, id_tanaman, id_petani, jumlah_panen_kg, 
       tanggal_panen, kualitas, keterangan
```

### Tabel Transaksi

```sql
PESANAN: id_pesanan, id_pembeli, tanggal_pesanan, status_pesanan, 
         total_harga, alamat_pengiriman, metode_pengiriman

DETAIL_PESANAN: id_detail, id_pesanan, id_tanaman, quantity_kg, 
                harga_satuan, subtotal

TRANSAKSI: id_transaksi, id_pesanan, tanggal_transaksi, metode_pembayaran, 
           status_pembayaran, bukti_pembayaran, tanggal_konfirmasi, id_admin_konfirmasi
```

### Tabel Notifikasi & Laporan

```sql
NOTIFIKASI: id_notifikasi, id_petani, id_pembeli, jenis_notifikasi, 
            judul, pesan, tanggal_kirim, status_baca

REKOMENDASI: id_rekomendasi, id_petani, jenis_rekomendasi, deskripsi, 
             tanggal_diberikan, status_diterapkan

LAPORAN: id_laporan, jenis_laporan, periode_awal, periode_akhir, 
         file_path, tanggal_dibuat, id_admin_pembuat

LOG_AKTIVITAS: id_log, id_user, tipe_user, aktivitas, detail, 
               waktu_aktivitas, ip_address

LOG_TRANSAKSI: id_log_transaksi, id_transaksi, aksi, detail_perubahan, 
               waktu_aksi, id_admin
```

---

## 3. Fitur Per Modul (DFD)

### 1.0 Kelola Data Master

| Sub-Modul | Deskripsi | Aktor |
|-----------|-----------|-------|
| 1.1 Kelola Data Tanaman | Input / edit / hapus tanaman | Petani |
| 1.2 Kelola Data Panen | Input hasil panen | Petani |
| 1.3 Kelola Stok Nutrisi | Input / pengurangan nutrisi | Petani |
| 1.4 Kelola Data User | Tambah / edit / hapus user | Admin |
| 1.5 Verifikasi & Role | Verifikasi akun petani, set role | Admin |

### 2.0 Proses Transaksi Penjualan

- Pencarian produk by name & kategori
- Tambah ke keranjang, manage cart
- Checkout → buat order → proses pembayaran
- Update status pesanan oleh Petani / Admin
- Kirim notifikasi ke pembeli setelah status update

### 3.0 Pemantauan & Notifikasi

- Monitoring stok sayuran & nutrisi
- Kirim notifikasi & rekomendasi ke petani
- Admin monitoring semua aktivitas

### 4.0 Pelaporan & Logging

- Generate laporan (jenis: penjualan / stok / aktivitas, periode custom)
- Export laporan ke **PDF / Excel**
- Log semua transaksi dan aktivitas user

---

## 4. Alur Sequence Diagram

### Admin — Generate Report
```
buka halaman laporan
→ pilih jenis laporan
→ pilih periode
→ klik "Generate"
→ query data sesuai jenis & periode ke DB
→ olah data jadi laporan
→ tampilkan laporan
→ klik "Export"
→ konversi ke format PDF/Excel
→ file siap download
```

### Admin — Kelola Kategori
```
buka halaman kategori
→ select all categories dari DB
→ tampilkan daftar
→ klik "Tambah" → tampilkan form → input nama → klik Simpan → insert category
→ "Kategori ditambahkan"
→ pilih kategori → klik "Hapus" → delete category
→ "Kategori dihapus"
```

### Admin — Manage Users
```
buka halaman kelola user
→ select all users dari DB
→ tampilkan daftar user
→ pilih user → ubah data (nama/email/role) → klik Simpan → update user
→ "User berhasil diupdate"
→ klik "Hapus" → konfirmasi → konfirmasi hapus → delete user
→ "User dihapus"
```

### Admin — Verifikasi Petani
```
login sebagai admin
→ select farmers(status='pending') dari DB
→ tampilkan daftar petani
→ pilih petani → select detail petani (detail + dokumen)
→ tampilkan detail
→ klik "Setujui"
→ update status farmer='verified'
→ kirimNotifikasi('Akun disetujui') ke petani
→ "Petani berhasil diverifikasi"
```

### Pembeli — Browse & Search
```
buka halaman produk
→ select products(status='active') dari DB
→ tampilkan produk
→ pilih kategori tertentu → select products by category → tampilkan hasil filter
→ input kata kunci → klik "Cari"
→ search products by name
→ tampilkan hasil pencarian
```

### Pembeli — Checkout
```
buka halaman produk
→ pilih produk & tambah ke keranjang
→ addToCart(productId, quantity) → simpan cart item ke DB
→ "item ditambahkan"
→ buka keranjang → getCart() → select cart items
→ tampilkan keranjang
→ klik Checkout → createOrder(cartData)
→ insert order → proses pembayaran
→ "order sukses"
→ tampilkan invoice
```

### Penjual — Tambah Produk
```
buka halaman kelola produk
→ select products by farmerId dari DB
→ tampilkan daftar produk
→ klik "Tambah Produk" → tampilkan form
→ input nama, harga, stok, kategori
→ upload gambar
→ klik Simpan → insert product → productId
→ "Produk berhasil ditambahkan"
```

### Penjual — Update Order Status
```
login & buka dashboard
→ getIncomingOrders() → select orders(status='pending') dari DB
→ tampilkan daftar pesanan
→ pilih pesanan → klik "Proses"
→ updateStatus(orderId, 'Diproses')
→ update order status di DB
→ kirimNotifikasi(pembeli)
→ "status terupdate" → sukses
```

---

## 5. Class Diagram

### User (Abstract)
```
- id: int
- name: string
- email: string
- password: string
- phone: string
- address: string
- role: string
- status: string
- createdAt: datetime
- updatedAt: datetime
+ login(email, password): boolean
+ logout(): void
+ updateProfile(): void
+ resetPassword(): void
```

### Farmer extends User
```
- farmName: string
- farmLocation: string
- verificationDoc: string
- isVerified: boolean
+ register(data, doc): void
+ addProduct(productData): void
+ editProduct(productId, productData): void
+ deleteProduct(productId): void
+ viewIncomingOrders(): Order[]
+ updateOrderStatus(orderId, status): void
+ viewDashboard(): DashboardData
```

### Buyer extends User
```
- cartId: int
+ browseProducts(): Product[]
+ searchProducts(keyword): Product[]
+ addToCart(productId, quantity): void
+ manageCart(cartItemId, action): void
+ checkout(orderData): Order
+ viewOrderHistory(): Order[]
+ updateProfile(): void
```

### Admin extends User
```
- adminLevel: string
+ manageUsers(userId, action): void
+ verifyFarmer(farmerId, isApproved, reason): void
+ addCategory(categoryData): void
+ editCategory(categoryId, categoryData): void
+ deleteCategory(categoryId): void
+ generateReport(reportType, period): Report
+ exportReport(reportId, format): File
+ viewDashboard(): DashboardData
```

### Product
```
- id: int
- farmerId: int
- categoryId: int
- name: string
- description: string
- price: double
- stock: int
- image: string
- unit: string
- status: string
- createdAt: datetime
+ getProductDetails(): void
+ updateStock(quantity): void
+ checkAvailability(): boolean
```

### Order
```
- id: int
- buyerId: int
- farmerId: int
- orderDate: datetime
- totalAmount: double
- shippingAddress: string
- paymentMethod: string
- paymentStatus: string
- orderStatus: string
- trackingNumber: string
- createdAt: datetime
+ calculateTotal(): double
+ updateStatus(status): void
```

### Cart
```
- id: int
- buyerId: int
- createdAt: datetime
- updatedAt: datetime
+ calculateTotal(): double
+ clearCart(): void
```

### CartItem
```
- id: int
- cartId: int
- productId: int
- quantity: int
- price: double
+ updateQuantity(quantity): void
+ getSubtotal(): double
```

### OrderItem
```
- id: int
- orderId: int
- productId: int
- quantity: int
- price: double
+ getSubtotal(): double
```

### Payment
```
- id: int
- orderId: int
- amount: double
- paymentMethod: string
- paymentDate: datetime
- transactionId: string
- status: string
+ processPayment(): boolean
+ refund(): boolean
```

### Category
```
- id: int
- name: string
- description: string
- createdAt: datetime
+ addCategory(): void
+ editCategory(): void
+ deleteCategory(): void
```

### Report
```
- id: int
- reportType: string
- generatedBy: int
- period: string
- data: text
- format: string
- createdAt: datetime
+ generate(): void
+ export(): File
```

### DashboardData
```
- totalUsers: int
- totalProducts: int
- totalOrders: int
- totalRevenue: double
- recentOrders: Order[]
- lowStockProducts: Product[]
+ refresh(): void
```

---

## 6. Prioritas Implementasi

1. ✅ Pastikan **struktur database** sesuai ERD di atas
2. ✅ Implementasi semua **alur sequence diagram** (8 alur)
3. ✅ Pastikan setiap **aktor hanya bisa akses fitur sesuai role**-nya
4. ✅ Implementasi **notifikasi** antar aktor
5. ✅ Implementasi **export laporan** PDF/Excel

---

> **Catatan:** Periksa kode yang sudah ada terlebih dahulu, lalu sesuaikan dan lengkapi bagian yang belum terimplementasi. Jangan timpa fungsi yang sudah berjalan dengan benar.