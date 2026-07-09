#!/usr/bin/env bash
set -euo pipefail

echo "=== SIPSH - Railway Database Migration ==="
echo ""

# Cek Railway CLI
if ! command -v railway &>/dev/null; then
    echo "⚠️  Railway CLI tidak terinstall."
    echo "Install dulu: npm install -g @railway/cli"
    exit 1
fi

# Cek login
if ! railway whoami &>/dev/null; then
    echo "🔑 Login dulu..."
    railway login
fi

# Jalankan migrasi
echo "🔄 Menjalankan migrasi database..."
railway run php artisan migrate --force
echo "✅ Migrasi selesai"

# Seed jika perlu
read -rp "Jalankan database seed? (y/n) " seed
if [ "$seed" = "y" ]; then
    echo "🌱 Seeding database..."
    railway run php artisan db:seed --force
    echo "✅ Seeding selesai"
fi

# Cache
echo "🔧 Caching config..."
railway run php artisan config:cache
railway run php artisan route:cache
railway run php artisan view:cache
echo "✅ Caching selesai"

# Storage link
echo "🔗 Storage link..."
railway run php artisan storage:link
echo "✅ Storage link selesai"

echo ""
echo "=== ✅ Semua berhasil! ==="
