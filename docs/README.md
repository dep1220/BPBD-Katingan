# BPBD Katingan - Documentation

Selamat datang di dokumentasi sistem informasi BPBD Katingan!

---

## 📖 Public Documentation (Git Repository)

File-file ini **DI-COMMIT** ke repository dan bisa diakses publik:

### [API Documentation](API_DOCUMENTATION.md)
**Complete API Guide** - Dokumentasi lengkap semua endpoint, authentication, file upload, dan use cases.

### [README.md](README.md)
**This File** - Panduan navigasi dokumentasi.

---

## 🔒 Private Documentation (Local Only)

File-file ini **TIDAK DI-COMMIT** ke repository (protected by `.gitignore`):

- **SECURITY_IMPLEMENTATION.md** - Detail implementasi keamanan (XSS, CSRF, Rate Limiting, Security Headers, dll)
- **DEPLOYMENT_NOTES.md** - Panduan deployment ke production, konfigurasi server, backup strategy
- **CREDENTIALS.md** - Credentials & access information (database, SSH, API keys, passwords)

**⚠️ File-file private hanya ada di local/server, TIDAK akan ter-upload ke GitHub untuk keamanan!**

---

## 🚀 Quick Start

### 1. Generate & Access Swagger UI
```bash
# Generate documentation
php artisan l5-swagger:generate

# Access interactive docs
http://bpbd-1.test/api/documentation
```

### 2. Test Endpoints
```bash
# Public endpoint (no auth)
curl http://bpbd-1.test/api/v1/berita

# Protected endpoint (with auth)
curl http://bpbd-1.test/api/v1/berita \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 📊 API Overview

**Total:** 54 Endpoints across 11 Modules

| Module | Count | Description |
|--------|-------|-------------|
| Authentication | 3 | Login, logout, user |
| Berita | 6 | News & articles |
| Slider | 5 | Homepage banners |
| Panduan Bencana | 5 | Disaster guides |
| Agenda | 5 | Events calendar |
| Struktur Organisasi | 5 | Organization structure |
| Visi Misi | 5 | Vision & mission |
| Galeri | 5 | Photo & video gallery |
| Unduhan | 5 | Document downloads |
| Informasi Kontak | 5 | Contact information |
| Pesan Kontak | 5 | Contact messages |

---

## 🔑 Key Features

- ✅ RESTful API with OpenAPI 3.0 (Swagger)
- ✅ Bearer token authentication (Laravel Sanctum)
- ✅ File upload support (images, documents)
- ✅ Search, filter, and pagination
- ✅ Auto-generate slug, auto-calculate status
- ✅ YouTube integration for videos
- ✅ Public & protected endpoints

---

## 📦 Response Format

```json
{
  "success": true,
  "message": "Operation successful",
  "data": {...}
}
```

---

## 🛠️ Commands

```bash
# Generate Swagger documentation
php artisan l5-swagger:generate

# Clear cache
php artisan optimize:clear

# Check routes
php artisan route:list --path=api
```

---

## 📞 Resources

- **Documentation:** [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- **Swagger UI:** http://bpbd-1.test/api/documentation
- **JSON Spec:** http://bpbd-1.test/docs/api-docs.json

---

**Status:** ✅ Production Ready  
**Version:** 1.0  
**Last Updated:** 2025-11-13
