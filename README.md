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

## 📦 Requirements (Server/Hosting)

### Software yang Harus Diinstall:
- **PHP** >= PHP 8.3.24
- **Composer** >= 2.0
- **Node.js** >= 18.x & **NPM** >= 9.x
- **MySQL** >= 8.0 / **MariaDB** >= 10.3
- **Web Server**: Apache / Nginx

### PHP Extensions:
```
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- PDO_MySQL
- Tokenizer
- XML
- ZIP
- GD (untuk manipulasi gambar)
```

## ⚙️ Instalasi

```bash
# Clone repository
git clone https://github.com/dep1220/BPBD-Katingan.git
cd BPBD-Katingan

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Konfigurasi .env
# Sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD, APP_URL

# Database setup
php artisan migrate --seed

# Storage link
php artisan storage:link

# Build assets
npm run build

# Set permissions (Linux/Unix)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Clear & optimize cache
php artisan optimize
```

### Setup Cron Job (untuk auto-cleanup Activity Log)

Tambahkan ke crontab:
```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
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

## 🔌 Package Dependencies

### Backend (Composer)
- **laravel/breeze** - Authentication scaffolding
- **mews/purifier** - HTML sanitization (XSS protection)
- **phpoffice/phpword** - Generate Word documents
- **smalot/pdfparser** - Parse PDF files
- **darkaonline/l5-swagger** - API documentation (optional)

### Frontend (NPM)
- **alpinejs** - Lightweight JavaScript framework
- **tailwindcss** - Utility-first CSS framework
- **@tailwindcss/forms** - Form styling
- **@tailwindcss/typography** - Typography plugin
- **vite** - Build tool & asset bundler

## 📝 Catatan

- Activity log otomatis dihapus setiap hari (>30 hari)
- File upload tersimpan di `storage/app/public/`
- Scheduler memerlukan cron job di production
- Max upload size default: 2MB (sesuaikan di `php.ini`)
- Pastikan folder `storage` & `bootstrap/cache` writable