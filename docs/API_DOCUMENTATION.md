# BPBD Katingan - API Documentation

**Base URL:** `http://bpbd-1.test/api/v1`  
**Swagger UI:** `http://bpbd-1.test/api/documentation`  
**Version:** 1.0  
**Last Updated:** 2025-11-13

---

## 🚀 Quick Start

### 1. Generate Swagger Documentation
```bash
php artisan l5-swagger:generate
```

### 2. Access Interactive Docs
```
http://bpbd-1.test/api/documentation
```

### 3. Authentication Flow
```bash
# Login
POST /api/v1/auth/login
Body: {"email":"kominfo@katingankab.go.id","password":"your_password"}

# Response: {"data":{"token":"1|xxxxx"}}

# Use token in headers
Authorization: Bearer 1|xxxxx
```

---

## 📊 API Modules (11 Total)

| # | Module | Endpoints | Public | Protected |
|---|--------|-----------|--------|-----------|
| 1 | Authentication | 3 | 1 | 2 |
| 2 | Berita | 6 | 3 | 3 |
| 3 | Slider | 5 | 2 | 3 |
| 4 | Panduan Bencana | 5 | 2 | 3 |
| 5 | Agenda | 5 | 2 | 3 |
| 6 | Struktur Organisasi | 5 | 2 | 3 |
| 7 | Visi Misi | 5 | 2 | 3 |
| 8 | Galeri | 5 | 2 | 3 |
| 9 | Unduhan | 5 | 2 | 3 |
| 10 | Informasi Kontak | 5 | 2 | 3 |
| 11 | Pesan Kontak | 5 | 1 | 4 |
| **TOTAL** | **54** | **21** | **33** |

---

## 🔐 1. Authentication

### Login
```http
POST /api/v1/auth/login
Content-Type: application/json

{"email":"user@example.com","password":"password"}
```

### Logout
```http
POST /api/v1/auth/logout
Authorization: Bearer {token}
```

### Get User Info
```http
GET /api/v1/auth/user
Authorization: Bearer {token}
```

---

## 📰 2. Berita (News/Articles)

**Features:** Auto-slug, image upload, kategori, search, pagination

### Public Endpoints
```http
GET  /api/v1/berita/kategori          # List categories
GET  /api/v1/berita                   # List news
GET  /api/v1/berita/{slug}            # Detail by slug
```

**Query Parameters:**
- `?kategori=KEGIATAN` - Filter by category
- `?search=keyword` - Search in title/content
- `?page=1&per_page=10` - Pagination

### Protected Endpoints
```http
POST   /api/v1/berita                 # Create (multipart/form-data)
PUT    /api/v1/berita/{id}            # Update
DELETE /api/v1/berita/{id}            # Delete
```

**Upload:** `gambar` (jpeg,jpg,png, max 2MB)

---

## 🖼️ 3. Slider

**Features:** Homepage banners, image upload, ordering

### Public Endpoints
```http
GET  /api/v1/sliders                  # List active sliders
GET  /api/v1/sliders/{id}             # Detail
```

### Protected Endpoints
```http
POST   /api/v1/sliders                # Create
PATCH  /api/v1/sliders/{id}           # Update
DELETE /api/v1/sliders/{id}           # Delete
```

**Upload:** `gambar` (jpeg,jpg,png, max 2MB)

---

## 📋 4. Panduan Bencana

**Features:** Disaster guides with steps (JSON array), icon upload

### Public Endpoints
```http
GET  /api/v1/panduan-bencana          # List guides
GET  /api/v1/panduan-bencana/{id}     # Detail
```

### Protected Endpoints
```http
POST   /api/v1/panduan-bencana        # Create
PATCH  /api/v1/panduan-bencana/{id}   # Update
DELETE /api/v1/panduan-bencana/{id}   # Delete
```

**Upload:** `icon` (jpeg,jpg,png,svg, max 1MB)  
**Steps:** `items` field as JSON array

---

## 📅 5. Agenda

**Features:** Events with auto-status (akan_datang, sedang_berlangsung, selesai)

### Public Endpoints
```http
GET  /api/v1/agenda                   # List events
GET  /api/v1/agenda/{id}              # Detail
```

**Query:** `?status=akan_datang`

### Protected Endpoints
```http
POST   /api/v1/agenda                 # Create
PATCH  /api/v1/agenda/{id}            # Update
DELETE /api/v1/agenda/{id}            # Delete
```

---

## 👥 6. Struktur Organisasi

**Features:** Organization structure with photos, chairman flag

### Public Endpoints
```http
GET  /api/v1/struktur-organisasi      # List (ordered by is_ketua)
GET  /api/v1/struktur-organisasi/{id} # Detail
```

### Protected Endpoints
```http
POST   /api/v1/struktur-organisasi    # Create
PATCH  /api/v1/struktur-organisasi/{id} # Update
DELETE /api/v1/struktur-organisasi/{id} # Delete
```

**Upload:** `foto` (jpeg,jpg,png, max 2MB)

---

## 🎯 7. Visi Misi

**Features:** Single active record, misi as JSON array

### Public Endpoints
```http
GET  /api/v1/visi-misi                # Get active (single object)
GET  /api/v1/visi-misi/{id}           # Detail by ID
```

### Protected Endpoints
```http
POST   /api/v1/visi-misi              # Create
PATCH  /api/v1/visi-misi/{id}         # Update
DELETE /api/v1/visi-misi/{id}         # Delete
```

**Note:** Only one active record allowed

---

## 📸 8. Galeri

**Features:** Photo & video (YouTube), dual-type support

### Public Endpoints
```http
GET  /api/v1/galeri                   # List gallery
GET  /api/v1/galeri/{id}              # Detail
```

**Query:** `?tipe=gambar` or `?tipe=video`

### Protected Endpoints
```http
POST   /api/v1/galeri                 # Create
PATCH  /api/v1/galeri/{id}            # Update
DELETE /api/v1/galeri/{id}            # Delete
```

**Upload:** `gambar` (if tipe=gambar) OR `video_url` (if tipe=video)

---

## 📥 9. Unduhan

**Features:** Document repository, multiple file types

### Public Endpoints
```http
GET  /api/v1/unduhan                  # List documents
GET  /api/v1/unduhan/{id}             # Detail
```

**Query:** `?kategori=Laporan`

### Protected Endpoints
```http
POST   /api/v1/unduhan                # Upload document
PATCH  /api/v1/unduhan/{id}           # Update
DELETE /api/v1/unduhan/{id}           # Delete
```

**Upload:** pdf,doc,docx,xls,xlsx,ppt,pptx (max 10MB)

---

## 📍 10. Informasi Kontak

**Features:** BPBD contact info (single record pattern)

### Public Endpoints
```http
GET  /api/v1/informasi-kontak         # Get contact info
GET  /api/v1/informasi-kontak/{id}    # Detail
```

### Protected Endpoints
```http
POST   /api/v1/informasi-kontak       # Create (only if not exists)
PATCH  /api/v1/informasi-kontak/{id}  # Update
DELETE /api/v1/informasi-kontak/{id}  # Delete
```

**Fields:** alamat, telepon, email, whatsapp, facebook, instagram, maps_url, etc.

---

## 📧 11. Pesan Kontak

**Features:** Contact form messages, read/unread tracking

### Public Endpoint (No Auth!)
```http
POST /api/v1/pesan                    # Submit message (PUBLIC)
Body: {"name","email","phone","category","subject","message"}
```

### Protected Endpoints (Admin)
```http
GET    /api/v1/pesan                  # List messages
GET    /api/v1/pesan/{id}             # Detail
PATCH  /api/v1/pesan/{id}/mark-as-read # Mark as read
DELETE /api/v1/pesan/{id}             # Delete
```

**Query:** `?is_read=false` or `?category=Pengaduan`

---

## 📦 Response Format

### Success
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {...}
}
```

### Error (Validation)
```json
{
  "success": false,
  "message": "Validasi gagal",
  "errors": {
    "field": ["Error message"]
  }
}
```

### Error (Not Found)
```json
{
  "success": false,
  "message": "Resource tidak ditemukan",
  "data": null
}
```

---

## 🔑 Authentication Pattern

### Public Endpoints (No Token Required)
```
GET  /berita, /sliders, /agenda, /galeri, /unduhan
GET  /visi-misi, /struktur-organisasi, /panduan-bencana
GET  /informasi-kontak
POST /pesan (contact form - special case)
```

### Protected Endpoints (Token Required)
```
All POST, PUT, PATCH, DELETE (except POST /pesan)
GET /pesan (admin only)
```

**Header Format:**
```
Authorization: Bearer 1|xxxxxxxxxxxxx
```

---

## 📁 File Upload Endpoints

| Module | Field | Types | Max Size |
|--------|-------|-------|----------|
| Berita | gambar | jpeg,jpg,png | 2MB |
| Slider | gambar | jpeg,jpg,png | 2MB |
| Panduan Bencana | icon | jpeg,jpg,png,svg | 1MB |
| Struktur Organisasi | foto | jpeg,jpg,png | 2MB |
| Galeri | gambar | jpeg,jpg,png | 2MB |
| Unduhan | file | pdf,doc,docx,xls,xlsx,ppt,pptx | 10MB |

**Method:** Use `multipart/form-data` with POST

**Update with file:** Use POST with `_method=PUT` field

---

## 🎯 Common Use Cases

### Frontend: Display Sliders
```javascript
fetch('http://bpbd-1.test/api/v1/sliders')
  .then(res => res.json())
  .then(data => {
    data.data.forEach(slider => {
      // Display slider.gambar_url, slider.judul
    });
  });
```

### Frontend: Contact Form
```javascript
fetch('http://bpbd-1.test/api/v1/pesan', {
  method: 'POST',
  headers: {'Content-Type': 'application/json'},
  body: JSON.stringify({
    name: 'John Doe',
    email: 'john@example.com',
    category: 'Pertanyaan',
    subject: 'Test',
    message: 'Hello'
  })
});
```

### Admin: Create News with Image
```javascript
const formData = new FormData();
formData.append('judul', 'Berita Baru');
formData.append('konten', 'Isi berita...');
formData.append('kategori', 'KEGIATAN');
formData.append('gambar', fileInput.files[0]);

fetch('http://bpbd-1.test/api/v1/berita', {
  method: 'POST',
  headers: {'Authorization': 'Bearer ' + token},
  body: formData
});
```

### Admin: Get Unread Messages
```javascript
fetch('http://bpbd-1.test/api/v1/pesan?is_read=false', {
  headers: {'Authorization': 'Bearer ' + token}
})
  .then(res => res.json())
  .then(data => console.log(data.data.length + ' unread'));
```

---

## 🛠️ Development Commands

```bash
# Generate Swagger documentation
php artisan l5-swagger:generate

# Clear cache
php artisan optimize:clear

# Check routes
php artisan route:list --path=api

# Run migrations
php artisan migrate

# Run tests
php artisan test
```

---

## 🐛 Troubleshooting

### Swagger UI not loading (404)
```bash
php artisan route:clear
php artisan config:clear
php artisan l5-swagger:generate
```

### CORS errors
Update `config/cors.php` with allowed origins

### File upload fails
- Check max upload size in `php.ini`
- Verify storage link: `php artisan storage:link`
- Check folder permissions

### 401 Unauthorized
- Verify token is valid
- Check Authorization header format: `Bearer {token}`
- Token may have expired

---

## 📚 Key Differences

### Informasi Kontak vs Pesan Kontak

| Feature | Informasi Kontak | Pesan Kontak |
|---------|------------------|--------------|
| Purpose | BPBD contact data | Visitor messages |
| Records | Single (1) | Multiple (many) |
| Public POST | ❌ No | ✅ Yes |
| Public GET | ✅ Yes | ❌ No (admin only) |
| Use Case | Footer, contact page | Admin inbox |

### PUT vs PATCH

**Current Implementation:** Only PATCH documented in Swagger  
**Reason:** Partial updates (send only changed fields)  
**Routes:** Both PUT and PATCH available for compatibility

---

## 📞 Support

- **Swagger Documentation:** `http://bpbd-1.test/api/documentation`
- **JSON Spec:** `http://bpbd-1.test/docs/api-docs.json`
- **Test with:** Swagger UI, Postman, cURL, or any HTTP client

---

## ✅ Checklist

Before deployment:
- [ ] Run `php artisan l5-swagger:generate`
- [ ] Test all public endpoints without auth
- [ ] Test protected endpoints with valid token
- [ ] Verify file uploads work
- [ ] Check CORS configuration
- [ ] Test contact form submission (public POST)
- [ ] Verify error responses (404, 422, 401)

---

**Status:** ✅ Production Ready  
**Total Endpoints:** 54  
**Total Modules:** 11  
**Documentation:** Auto-generated with OpenAPI 3.0
