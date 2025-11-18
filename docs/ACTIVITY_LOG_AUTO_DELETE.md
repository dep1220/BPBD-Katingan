# Activity Log - Auto Delete & Management Panel

## ✅ Fitur yang Sudah Dibuat

### 1. Automatic Cleanup Command
**File**: `app/Console/Commands/CleanOldActivityLogs.php`

Command untuk menghapus log aktivitas yang sudah lama:
```bash
# Hapus log lebih dari 30 hari (default)
php artisan activitylog:clean

# Hapus log dengan custom days
php artisan activitylog:clean --days=60
```

### 2. Scheduled Task
**File**: `routes/console.php`

Log aktivitas akan otomatis dihapus setiap hari (untuk data lebih dari 30 hari).

Untuk menjalankan scheduler di development:
```bash
php artisan schedule:work
```

Untuk production, tambahkan cron job:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

### 3. Activity Log Controller
**File**: `app/Http/Controllers/Admin/ActivityLogController.php`

Endpoints yang tersedia:
- `GET /admin/activity-logs` - Lihat semua log dengan filter
- `POST /admin/activity-logs/clean-old` - Hapus log lebih dari 30 hari
- `DELETE /admin/activity-logs/delete-all` - Hapus semua log
- `DELETE /admin/activity-logs/{id}` - Hapus log tertentu

### 4. Management Panel UI
**File**: `resources/views/admin/activity-logs/index.blade.php`

Panel management dengan fitur:
- ✅ Filter berdasarkan user
- ✅ Filter berdasarkan jenis aksi
- ✅ Filter berdasarkan tanggal
- ✅ Hapus log lebih dari 30 hari (dengan konfirmasi)
- ✅ Hapus semua log (dengan konfirmasi)
- ✅ Hapus log individual
- ✅ Pagination
- ✅ Tampilan table yang lengkap (waktu, user, aksi, deskripsi, IP)

### 5. Dashboard Integration
**File**: `resources/views/admin/dashboard.blade.php`

- ✅ Link "Lihat Semua" di card Log Activity
- ✅ Scroll otomatis jika log banyak (max-height: 384px)

## 📋 Routes yang Ditambahkan

```php
Route::prefix('activity-logs')->name('activity-logs.')->group(function () {
    Route::get('/', [ActivityLogController::class, 'index'])->name('index');
    Route::post('/clean-old', [ActivityLogController::class, 'cleanOld'])->name('clean-old');
    Route::delete('/delete-all', [ActivityLogController::class, 'deleteAll'])->name('delete-all');
    Route::delete('/{activityLog}', [ActivityLogController::class, 'destroy'])->name('destroy');
});
```

## 🎯 Cara Menggunakan

### Dari Dashboard Admin
1. Login ke dashboard admin
2. Scroll ke bagian "Log Activity User"
3. Klik "Lihat Semua" di pojok kanan atas

### Dari Menu (Opsional - bisa ditambahkan ke navigation)
Akses langsung ke: `/admin/activity-logs`

### Automatic Cleanup
Log otomatis terhapus setiap hari untuk data lebih dari 30 hari.
Tidak perlu action manual!

### Manual Cleanup
Di halaman Activity Logs, klik tombol:
- **"Hapus Log Lebih dari 30 Hari"** (tombol kuning) - untuk hapus log lama
- **"Hapus Semua Log"** (tombol merah) - untuk hapus semua (hati-hati!)

## 🔐 Security Notes

- Semua endpoint dilindungi dengan middleware `auth`
- Tombol delete memiliki konfirmasi JavaScript
- Action logging tetap berjalan untuk audit trail

## 📊 Database Impact

### Before Cleanup
Log aktivitas akan terus bertambah seiring waktu.

### After Automatic Cleanup
- Data lebih dari 30 hari otomatis terhapus setiap hari
- Database tetap ringan
- Performa tetap optimal

### Manual Management
Admin bisa custom cleanup sesuai kebutuhan via panel.

## 🚀 Testing

1. **Test Command**:
   ```bash
   php artisan activitylog:clean --days=1
   ```

2. **Test Panel**:
   - Buka `/admin/activity-logs`
   - Coba semua filter
   - Coba hapus individual log
   - Coba hapus log lama
   
3. **Test Scheduler** (development):
   ```bash
   php artisan schedule:work
   # Akan run setiap hari
   ```

## 📝 Notes

- Log yang dihapus TIDAK BISA dikembalikan
- Pastikan backup database sebelum mass delete
- Recommended: keep log 30-90 hari untuk audit
- Untuk compliance yang ketat, pertimbangkan archive ke file/external storage sebelum delete
