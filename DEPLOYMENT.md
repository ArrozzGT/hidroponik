# 🚀 Deploy SIPSH ke InfinityFree (Gratis)

Hosting PHP gratis + MySQL + subdomain. Cocok buat Laravel.

---

## 1. Daftar InfinityFree

1. Buka [infinityfree.com](https://infinityfree.com)
2. Klik **Get Premium Free Hosting** → **Register**
3. Isi email & password → verifikasi email
4. Login → **Create Account** → isi data hosting

Kamu akan dapat:
- Subdomain: `namakamu.infinityfreeapp.com`
- Akses cPanel
- MySQL database

---

## 2. Buat Database MySQL

1. Login ke **cPanel** InfinityFree
2. Cari **MySQL Databases**
3. Buat database baru:
   - **Database Name:** `if0_xxxx_sipsh` (copy nama lengkapnya)
   - **Username:** `if0_xxxx` (copy username-nya)
   - **Password:** isi password kuat
4. Klik **Create User** lalu **Add User to Database**
5. Centang **ALL PRIVILEGES** → **Make Changes**

Simpan 4 info ini:
```
DB_DATABASE = if0_xxxx_sipsh
DB_USERNAME = if0_xxxx
DB_PASSWORD = (password yang kamu buat)
DB_HOST     = sqlxxx.infinityfree.com (atau lihat di cPanel)
```

---

## 3. Export Database dari Local

Buka **terminal** di folder proyek:

```bash
# Pindah ke MySQL dulu (ganti .env)
# Edit .env → ubah DB_CONNECTION jadi mysql dan isi 4 info di atas

# Jalankan migrasi (tabel akan terbentuk)
php artisan migrate --force

# Export database ke file SQL
php artisan db:export > sipsh-database.sql
```

> Catatan: Kalo `db:export` ga ada, pake phpMyAdmin XAMPP:
> Buka `http://localhost/phpmyadmin` → pilih database → Export → Quick → Go

Atau jalankan ini di terminal:

```bash
# Cek dulu kalo mysqldump ada di XAMPP
"C:\xampp\mysql\bin\mysqldump" -u root sipsh > sipsh-database.sql
```

Simpan file `sipsh-database.sql` — ini yang akan diimport ke InfinityFree.

---

## 4. Siapkan File untuk Upload

```bash
# 1. Hapus node_modules biar zip kecil
rm -rf node_modules

# 2. Buat zip (Windows: klik kanan folder → Send to → Compressed folder)
#    Atau pake perintah:
zip -r sipsh-deploy.zip . -x "node_modules/*" -x ".git/*" -x ".env"

# 3. Zip file siap diupload ~20-30MB
```

---

## 5. Upload ke InfinityFree

1. Login cPanel InfinityFree
2. Buka **File Manager**
3. Masuk ke folder `htdocs`
4. Klik **Upload** → pilih `sipsh-deploy.zip`
5. Setelah upload selesai:
   - Klik kanan file zip → **Extract**
   - Centang **Extract files into current directory**
6. Hapus file `sipsh-deploy.zip` setelah extract

---

## 6. Setting Document Root

Laravel harus diarahkan ke folder `public/`:

1. Di cPanel, cari **Settings** → **Root Domain**
2. Pilih **Redirect URL** → **Manage**
3. **Document Root:** ubah ke `htdocs/public`
4. **Save**

Atau via menu **Laravel** → pilih project → **Setup Laravel** (otomatis set document root).

---

## 7. Konfigurasi .env

1. Di File Manager, buka folder `htdocs/`
2. Copy file `.env.example` → rename jadi `.env`
3. Klik kanan `.env` → **Edit**
4. Isi dengan:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://namakamu.infinityfreeapp.com

DB_CONNECTION=mysql
DB_HOST=sqlxxx.infinityfree.com
DB_PORT=3306
DB_DATABASE=if0_xxxx_sipsh
DB_USERNAME=if0_xxxx
DB_PASSWORD=password_kamu

SESSION_DRIVER=database
CACHE_STORE=database
```

5. **Save**

---

## 8. Import Database

1. Di cPanel, buka **phpMyAdmin**
2. Pilih database kamu (yang tadi dibuat)
3. Klik tab **Import**
4. **Choose File** → pilih file `sipsh-database.sql`
5. Klik **Go**

Tunggu sampai selesai. Semua tabel akan terbuat.

---

## 9. Generate APP_KEY

Buka **PHP Script** di cPanel InfinityFree:

```
php /home/if0_xxxx/htdocs/artisan key:generate --force
php /home/if0_xxxx/htdocs/artisan storage:link
php /home/if0_xxxx/htdocs/artisan config:cache
php /home/if0_xxxx/htdocs/artisan route:cache
php /home/if0_xxxx/htdocs/artisan view:cache
```

Atau kalo ga ada menu PHP Script:

1. Buat file `key.php` di folder `htdocs/`:

```php
<?php
copy('.env.example', '.env');
shell_exec('php artisan key:generate --force');
shell_exec('php artisan storage:link');
echo "Done! Delete this file now.";
```

2. Buka `https://namakamu.infinityfreeapp.com/key.php`
3. Hapus file `key.php` setelah selesai

---

## ✅ Selesai!

Buka `https://namakamu.infinityfreeapp.com` — website live!

---

## Troubleshooting

**Error 500 / Blank page:**
- Cek `.env` — pastikan semua terisi benar
- Cek **Error Logs** di cPanel
- Pastikan PHP versi 8.2 (cPanel → PHP Selector)

**Database connection error:**
- Pastikan DB_HOST benar (cek di cPanel → MySQL Databases)
- Pastikan database user punya ALL PRIVILEGES
- Coba `DB_HOST=localhost` kalo ragu

**File upload tidak muncul:**
- Jalankan ulang `php artisan storage:link`
- Atau buat manual symlink di File Manager

**CSS/Javascript broken:**
- Jalankan `php artisan config:cache` dan `php artisan view:cache`
- Hapus folder `storage/framework/cache/data/`

**APP_KEY invalid:**
- Generate ulang: `php artisan key:generate --force`
- Update `.env` dengan key baru
