# Activity Log System

## Deskripsi
Sistem Activity Log untuk mencatat semua aktivitas pengguna di BPBD Katingan Dashboard.

## Fitur

### 1. Log Activity Model
**File**: `app/Models/ActivityLog.php`

Model untuk menyimpan semua aktivitas pengguna dengan:
- `user_id`: ID pengguna yang melakukan aktivitas
- `action`: Jenis aktivitas (create, update, delete, login, logout)
- `model`: Model yang dioperasikan (Berita, Slider, Galeri, dll)
- `description`: Deskripsi aktivitas
- `ip_address`: IP address pengguna
- `user_agent`: Browser/device yang digunakan
- `timestamps`: Waktu aktivitas

Helper method:
```php
ActivityLog::log($action, $description, $model);
```

### 2. LogsActivity Trait
**File**: `app/Traits/LogsActivity.php`

Trait yang dapat digunakan di controller untuk mempermudah logging:

```php
use LogsActivity;

// Helper methods
$this->logCreate('Berita', $berita->judul);
$this->logUpdate('Berita', $berita->judul);
$this->logDelete('Berita', $berita->judul);
$this->logActivity('custom_action', 'Custom description', 'ModelName');
```

### 3. Controllers dengan Activity Log

Berikut controller yang sudah mengimplementasikan activity logging:

#### BeritaController
- ✅ Create berita
- ✅ Update berita
- ✅ Delete berita

#### SliderController
- ✅ Create slider
- ✅ Update slider
- ✅ Delete slider

#### GaleriController
- ✅ Create galeri
- ✅ Update galeri
- ✅ Delete galeri

#### UnduhanController
- ✅ Create unduhan
- ✅ Update unduhan
- ✅ Delete unduhan

#### AgendaController
- ✅ Create agenda
- ✅ Update agenda
- ✅ Delete agenda

#### AuthenticatedSessionController
- ✅ Login
- ✅ Logout

### 4. Dashboard Display
**File**: `resources/views/admin/dashboard.blade.php`

Log activity ditampilkan di dashboard dengan:
- Icon berbeda untuk setiap jenis aktivitas (create, update, delete, login, logout)
- Nama user yang melakukan aktivitas
- Deskripsi aktivitas
- Waktu relatif (e.g., "5 minutes ago")
- Menampilkan 10 aktivitas terakhir

## Database

### Migration
**File**: `database/migrations/2025_11_17_145937_create_activity_logs_table.php`

Struktur tabel:
```sql
CREATE TABLE activity_logs (
    id BIGINT PRIMARY KEY,
    user_id BIGINT FOREIGN KEY,
    action VARCHAR(255),
    model VARCHAR(255) NULLABLE,
    description VARCHAR(255),
    ip_address VARCHAR(45) NULLABLE,
    user_agent TEXT NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Seeder (Optional)
**File**: `database/seeders/ActivityLogSeeder.php`

Untuk membuat data sample activity log:
```bash
php artisan db:seed --class=ActivityLogSeeder
```

## Automatic Cleanup

### Command Manual
Untuk menghapus log aktivitas yang lebih dari 30 hari:
```bash
php artisan activitylog:clean
```

Untuk menghapus dengan jumlah hari custom:
```bash
php artisan activitylog:clean --days=60
```

### Scheduled Automatic Cleanup
Log aktivitas akan otomatis dihapus setiap hari untuk data yang lebih dari 30 hari melalui Laravel Scheduler.

Untuk menjalankan scheduler di server production, tambahkan cron job:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Management Panel

### Halaman Activity Log
Akses: `/admin/activity-logs`

Fitur yang tersedia:
1. **Filter Log**
   - Filter berdasarkan user
   - Filter berdasarkan jenis aksi (create, update, delete, login, logout)
   - Filter berdasarkan range tanggal

2. **Hapus Log**
   - Hapus log lebih dari 30 hari
   - Hapus semua log
   - Hapus log individual

3. **View Details**
   - Lihat waktu aktivitas
   - Lihat user yang melakukan
   - Lihat IP address
   - Lihat deskripsi lengkap

## Usage

### Menambahkan Log di Controller Baru

1. Import trait:
```php
use App\Traits\LogsActivity;

class YourController extends Controller
{
    use LogsActivity;
    
    // Your methods...
}
```

2. Tambahkan log di method:
```php
public function store(Request $request)
{
    $item = YourModel::create($data);
    
    // Log activity
    $this->logCreate('YourModel', $item->name);
    
    return redirect()->back();
}

public function update(Request $request, YourModel $item)
{
    $item->update($data);
    
    // Log activity
    $this->logUpdate('YourModel', $item->name);
    
    return redirect()->back();
}

public function destroy(YourModel $item)
{
    $itemName = $item->name;
    $item->delete();
    
    // Log activity
    $this->logDelete('YourModel', $itemName);
    
    return redirect()->back();
}
```

### Custom Log Activity

Untuk aktivitas custom yang tidak menggunakan trait:
```php
use App\Models\ActivityLog;

ActivityLog::log('custom_action', 'Melakukan export data', 'YourModel');
```

## Icon Legend

Di dashboard, setiap aktivitas memiliki icon berbeda:
- 🟢 **Create** (Hijau): Menambah data baru
- 🔵 **Update** (Biru): Mengubah data
- 🔴 **Delete** (Merah): Menghapus data
- 🟣 **Login** (Ungu): Login ke sistem
- ⚫ **Logout** (Abu): Logout dari sistem

## Performance Notes

- Activity log menggunakan eager loading (`with('user')`) untuk menghindari N+1 query
- Hanya 10 aktivitas terakhir yang ditampilkan di dashboard
- Index database pada kolom `user_id` dan `created_at` untuk performa query

## Future Enhancements

Beberapa enhancement yang bisa ditambahkan:
- [ ] Filter activity log berdasarkan user
- [ ] Filter berdasarkan action type
- [ ] Filter berdasarkan date range
- [ ] Export activity log ke PDF/Excel
- [ ] Halaman dedicated untuk full activity log
- [ ] Real-time activity log dengan WebSocket/Livewire
