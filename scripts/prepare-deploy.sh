#!/usr/bin/env bash
set -euo pipefail

echo "=== SIPSH - Persiapan Deploy ke Railway ==="
echo ""

# 1. Cek git status
if [ -n "$(git status --porcelain)" ]; then
    echo "⚠️  Ada perubahan yang belum di-commit."
    git status --short
    echo ""
    read -rp "Commit semua perubahan? (y/n) " yn
    if [ "$yn" = "y" ]; then
        git add -A
        read -rp "Pesan commit: " msg
        git commit -m "${msg:-"chore: persiapan deploy"}"
    else
        echo "❌ Commit dulu sebelum deploy."
        exit 1
    fi
fi

# 2. Pastikan di branch main
BRANCH=$(git branch --show-current)
if [ "$BRANCH" != "main" ] && [ "$BRANCH" != "master" ]; then
    echo "⚠️  Kamu sedang di branch '$BRANCH', bukan main/master."
    read -rp "Push dari branch ini? (y/n) " yn
    if [ "$yn" != "y" ]; then
        echo "❌ Switch ke main dulu: git checkout main"
        exit 1
    fi
fi

# 3. Build verification
echo "🔨 Verifikasi build..."
npm run build
echo "✅ Build sukses"

# 4. Test config cache
echo "🔧 Test config cache..."
cp .env.example .env.test
php artisan key:generate --force --quiet 2>/dev/null || true
php artisan config:cache 2>/dev/null && echo "✅ Config cache OK" || echo "⚠️  Config cache gagal (wajar di local)")
rm -f .env.test bootstrap/cache/config.php

# 5. Push
echo ""
echo "🚀 Push ke GitHub..."
git push origin "$BRANCH"

echo ""
echo "=== ✅ Selesai! ==="
echo "Pipeline CI akan berjalan otomatis di GitHub."
echo "Cek status: https://github.com/$(git config --get remote.origin.url | sed 's/.*github.com[:/]//;s/\.git$//')/actions"
echo ""
echo "📦 Railway akan auto-deploy dari branch $BRANCH"
