# 🐾 PatiCare Veteriner Kliniği

Sıcak, sevimli ama profesyonel bir **veteriner kliniği** web sitesi — evcil hayvan profili,
online randevu ve tam donanımlı yönetim paneli ile.

**Stack:** Laravel 12 · Filament 3 · Livewire 3 · Tailwind CSS v4 · Alpine.js

---

## ✨ Özellikler

### Public site
- **Ana Sayfa** — hero, hizmet grid'i, neden biz (animasyonlu sayaçlar), hekimler, galeri, yorumlar, blog, CTA
- **Hizmetler** — genel muayene, aşı, cerrahi, diş, 7/24 acil, pet kuaför, petshop (+ detay sayfaları)
- **Veteriner Hekimler** — uzmanlık ve deneyim kartları
- **Galeri** — lightbox'lı masonry galeri
- **Blog** — bakım rehberi yazıları (kategori, ilgili yazılar)
- **İletişim** — form + harita + acil hat
- **JSON-LD** — `VeterinaryCare` yapısal verisi

### Dinamik / üyelik
- **Online Randevu** — Livewire sihirbazı: hizmet → hekim → tarih → uygun saat → dost & bilgi → onay
- **Evcil Hayvan Sahibi Paneli** — giriş/kayıt, evcil hayvan profilleri, **aşı takvimi & hatırlatmaları** (gecikti / yaklaşıyor), randevu geçmişi

### Yönetim Paneli (Filament — `/admin`)
- Randevu yönetimi (onay aksiyonu, durum rozetleri, bekleyen sayacı)
- Evcil hayvan kayıtları + **aşı kayıtları (relation manager)**
- Sahip (kullanıcı) yönetimi, aşı takvimi
- Hizmet / Hekim / Blog / Galeri / Yorum CRUD'ları
- Dashboard istatistik widget'ı

---

## 🔑 Demo Girişleri

| Rol | E-posta | Şifre |
|-----|---------|-------|
| Yönetici (`/admin`) | `admin@paticare.com` | `password` |
| Evcil hayvan sahibi (`/giris`) | `demo@paticare.com` | `password` |

Demo sahibinin **Pamuk** (kedi) ve **Boncuk** (köpek) adlı dostları, aşı kayıtları ve randevuları hazırdır.

---

## 🚀 Yerel Kurulum

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm run build        # veya: npm run dev
php artisan serve
```

---

## ☁️ Coolify ile Deploy

Bu repo **Dockerfile** ile gelir (serversideup/php · nginx + php-fpm, `:8080`).

1. Coolify'da yeni bir **Application** → kaynak: bu GitHub reposu, branch `demo/veteriner`.
2. Build pack: **Dockerfile**.
3. Domain: `veteriner.demo.dijifa.com`.
4. Environment değişkenleri:
   ```
   APP_NAME=PatiCare Veteriner Kliniği
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:...        # php artisan key:generate --show
   APP_URL=https://veteriner.demo.dijifa.com
   APP_LOCALE=tr
   DB_CONNECTION=sqlite
   DB_DATABASE=/var/www/html/database/database.sqlite
   LOG_CHANNEL=stderr
   ```
5. Deploy. Konteyner açılışında migrasyon + seed + cache otomatik çalışır
   (`docker/entrypoint.d/50-laravel-init.sh`).

> Not: SQLite konteyner içindedir; kalıcılık için `database/` dizinine bir volume bağlanabilir.
