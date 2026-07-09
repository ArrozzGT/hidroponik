# 🚀 Deploy SIPSH ke Railway.app (Gratis)

## Apa yang kamu dapat
- **Hosting** Laravel gratis (dengan Railway $5 credit/bulan)
- **Database** PostgreSQL gratis otomatis
- **Auto-deploy** dari GitHub — tinggal push, langsung live
- **Domain** `*.up.railway.app` gratis (atau custom domain nanti)

---

## 1. Setup GitHub Repository

Buka [github.com/new](https://github.com/new), buat repo baru (public/private bebas).
Jalankan ini di terminal proyek:

```bash
git remote add origin https://github.com/username/nama-repo.git
git branch -M main
git push -u origin main
```

---

## 2. Setup Railway

1. Buka [railway.app](https://railway.app)
2. Login dengan GitHub
3. Klik **New Project** → **Deploy from GitHub repo**
4. Pilih repo SIPSH kamu
5. Railway otomatis mendeteksi Laravel dan mulai deploy

⏳ Tunggu ~3-5 menit sampai build selesai.

---

## 3. Setup Database PostgreSQL

Setelah deploy pertama selesai:

1. Di dashboard Railway project kamu, klik **+ New** → **Database** → **PostgreSQL**
2. Tunggu sampai PostgreSQL terprovisi (lingkaran hijau)
3. Klik PostgreSQL → tab **Variables**
4. Akan ada variabel `DATABASE_URL` dan `PG*` — kita perlui detail koneksinya

Sekarang set environment variables untuk Laravel:

1. Klik project **SIPSH** (bukan database)
2. Tab **Variables**
3. Tambahkan variabel berikut:

| Key | Value |
|-----|-------|
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | Host dari PostgreSQL (contoh: `roundhouse.proxy.rlwy.net`) |
| `DB_PORT` | `5432` |
| `DB_DATABASE` | `railway` |
| `DB_USERNAME` | `postgres` |
| `DB_PASSWORD` | Password dari PostgreSQL variable |
| `DB_SSLMODE` | `require` |
| `APP_KEY` | Generate dulu (lihat langkah 4) |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | Domain Railway kamu (contoh: `https://sipsh.up.railway.app`) |
| `SESSION_DRIVER` | `database` |
| `CACHE_STORE` | `database` |

> Semua nilai `DB_*` bisa kamu lihat dari PostgreSQL service → Variables.
> `APP_KEY` bisa kamu generate via langkah berikut.

---

## 4. Generate APP_KEY untuk Railway

Jalankan:

```bash
php artisan key:generate --show
```

> Outputnya seperti `base64:abc123...` — copy dan paste sebagai nilai `APP_KEY` di Railway Variables.

---

## 5. Deploy Ulang & Migrate

Setelah variabel terisi:

1. Tab **Deployments**
2. Klik **Redeploy** (tombol ⋮ → Redeploy)
3. Tunggu build selesai

Jalankan migrasi di Railway console:

```bash
railway run php artisan migrate --force
```

Atau pake tombol **Connect** → **Railway CLI**:

```powershell
# Install Railway CLI
npm install -g @railway/cli

# Login (browser akan terbuka)
railway login

# Link ke project
railway link

# Jalankan migrasi
railway run php artisan migrate --force
railway run php artisan storage:link
railway run php artisan config:cache
railway run php artisan route:cache
railway run php artisan view:cache
```

---

## 6. Setup Email (Mailtrap)

Buat akun gratis di [mailtrap.io](https://mailtrap.io):

1. Masuk → **Email Testing** → **Inbox** → pilih **SMTP Settings**
2. Pilih **Laravel 9+** di tab Integration
3. Copy credentials → tambahkan ke Railway Variables:

| Key | Value |
|-----|-------|
| `MAIL_MAILER` | `smtp` |
| `MAIL_HOST` | `smtp.mailtrap.io` |
| `MAIL_PORT` | `587` |
| `MAIL_USERNAME` | dari Mailtrap |
| `MAIL_PASSWORD` | dari Mailtrap |
| `MAIL_ENCRYPTION` | `tls` |
| `MAIL_FROM_ADDRESS` | `noreply@sipsh.local` |

---

## 7. Auto-Deploy (Push = Deploy)

Setelah semua setup, setiap kali kamu push ke `main`:

```bash
git add -A
git commit -m "update fitur"
git push origin main
```

Railway otomatis:
1. Detect perubahan
2. Build ulang
3. Deploy versi baru
4. PostgreSQL database tetap aman

---

## Yang perlu diingat

| Hal | Catatan |
|-----|---------|
| **Railway free tier** | $5/bulan — cukup buat app kecil. Jangan upgrade tanpa perlu. |
| **Database** | PostgreSQL Railway — jangan hapus! Data ilang. |
| **File upload** | Upload user disimpan di `storage/app/public` — Railway storage ini **ephemeral**. Buat production sungguhan, pindah ke S3/MinIO. |
| **Custom domain** | Bisa pasang domain `.com` kalo udah ready. Settings → Domain. |
| **Sleep policy** | Railway akan "tidurkan" app gratis setelah ~30 menit idle. Kunjungan berikutnya agak lambat (cold start ~5 detik). |

---

## Troubleshooting

**App error 500 setelah deploy:**
- Cek Railway tab **Deployments** → logs
- Pastikan `.env.example` di-root repo (dipakai Railway untuk fallback)
- Generate APP_KEY, pastikan diset di Railway Variables

**Database connection error:**
- Pastikan PostgreSQL variables udah bener
- `DB_CONNECTION` harus `pgsql`
- `DB_SSLMODE=require`

**File upload tidak muncul:**
- Jalankan `railway run php artisan storage:link` setelah deploy
- Atau untuk production serius: setup AWS S3 di `config/filesystems.php`
