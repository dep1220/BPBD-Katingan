# 🚨 BPBD Katingan Website

Website resmi Badan Penanggulangan Bencana Daerah (BPBD) Kabupaten Katingan untuk informasi dan edukasi kebencanaan.

## 📋 Fitur

### Halaman Publik
- **Beranda** - Slider informasi, berita terkini, agenda kegiatan
- **Profil** - Visi/Misi, Struktur Organisasi
- **Berita** - Artikel dengan kategori (berita, informasi, pengumuman)
- **Galeri** - Foto dokumentasi kegiatan
- **Panduan Bencana** - Informasi penanganan berbagai jenis bencana
- **Unduhan** - File dokumen (regulasi, SOP, laporan)
- **Kontak** - Form pesan, informasi kontak, maps

### Panel Admin
- **Dashboard** - Statistik & Activity Log
- **Manajemen Konten** - Slider, Berita, Galeri, Agenda
- **Data Master** - Panduan Bencana, Unduhan, Struktur Organisasi
- **User Management** - Kelola pengguna admin
- **Activity Log** - Log aktivitas dengan auto-cleanup (30 hari)

## 🛠️ Teknologi

- **Laravel 11** - Backend Framework
- **Tailwind CSS** - Styling
- **Alpine.js** - Interaktivitas Frontend
- **MySQL** - Database
- **Blade** - Template Engine

## ⚙️ Instalasi

```bash
# Clone repository
git clone https://github.com/dep1220/BPBD-Katingan.git
cd BPBD-Katingan

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate --seed

# Storage link
php artisan storage:link

# Build assets
npm run build

# Jalankan server
php artisan serve
```

## 👤 Default Login

```
Email: admin@bpbd.com
Password: password
```

## 📁 Struktur Penting

```
app/
├── Console/Commands/
│   ├── CleanOldActivityLogs.php   # Auto cleanup log
│   └── ResetAutoIncrement.php     # Reset ID tabel
├── Models/                         # Eloquent Models
├── Http/Controllers/Admin/         # Admin Controllers
└── Traits/LogsActivity.php        # Activity logging trait

resources/views/
├── public/                         # Halaman publik
└── admin/                          # Halaman admin

routes/
├── web.php                         # Public routes
└── auth.php                        # Auth routes
```

## 🔧 Command Berguna

```bash
# Cleanup activity logs manual
php artisan activitylog:clean --days=30

# Reset auto increment tabel
php artisan db:reset-auto-increment

# Clear cache
php artisan optimize:clear
```

## 📝 Catatan

- Activity log otomatis dihapus setiap hari (>30 hari)
- File upload tersimpan di `storage/app/public/`
- Scheduler memerlukan cron job di production