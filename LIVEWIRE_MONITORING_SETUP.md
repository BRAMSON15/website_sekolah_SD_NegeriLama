# Sistem Livewire Polling untuk Monitoring Guru

## 📋 Daftar Isi
1. [Pengenalan Sistem](#pengenalan-sistem)
2. [Arsitektur & Komponen](#arsitektur--komponen)
3. [Instalasi & Setup](#instalasi--setup)
4. [Penggunaan](#penggunaan)
5. [API Endpoints](#api-endpoints)
6. [Recording Aktivitas](#recording-aktivitas)
7. [Troubleshooting](#troubleshooting)

---

## Pengenalan Sistem

Sistem Livewire Polling adalah solusi real-time untuk monitoring aktivitas dan performa guru oleh role **Kepala Sekolah (Kepsek)**. Sistem ini menggunakan teknologi polling Livewire v4 untuk memberikan update data real-time dengan interval yang dapat dikonfigurasi.

### Fitur Utama:
- ✅ **Real-time Activity Monitoring**: Pantau aktivitas input/output guru secara live
- ✅ **Performance Analytics**: Analitik performa guru dengan scoring 0-100
- ✅ **Smart Filtering**: Filter berdasarkan status, tipe aktivitas, dan search
- ✅ **Status Detection**: Otomatis mendeteksi status guru (Active/Pending/Inactive)
- ✅ **Export Data**: Export aktivitas ke CSV
- ✅ **Responsive UI**: Dashboard yang responsif dengan Bootstrap 5
- ✅ **Event Broadcasting**: Support untuk broadcasting events

---

## Arsitektur & Komponen

### 1. **Models**
```
App\Models\Monitoring\
├── TeacherActivity.php       # Track semua aktivitas guru
└── TeacherPerformance.php    # Track performa & scoring guru
```

**TeacherActivity** - Menyimpan:
- `user_id`: ID guru
- `activity_type`: Tipe aktivitas (material_upload, video_upload, assignment_create)
- `description`: Deskripsi aktivitas
- `related_model`: Model yang berhubungan
- `related_model_id`: ID dari model yang berhubungan
- `metadata`: Data tambahan dalam JSON

**TeacherPerformance** - Menyimpan:
- `user_id`: ID guru (unique)
- `materials_count`: Jumlah materi yang diupload
- `videos_count`: Jumlah video yang diupload
- `assignments_count`: Jumlah tugas yang dibuat
- `last_activity_at`: Waktu aktivitas terakhir
- `activity_score`: Skor aktivitas (0-100)
- `status`: Status guru (active/pending/inactive)

### 2. **Livewire Components**
```
App\Livewire\
├── TeacherActivityMonitor.php    # Component untuk monitoring aktivitas
└── TeacherPerformanceStats.php   # Component untuk monitoring performa
```

**Fitur TeacherActivityMonitor:**
- Real-time activity list dengan polling 3 detik
- Search, filter by status & activity type
- Pagination support
- Statistics cards (active/pending/inactive/total)
- Top 5 guru paling aktif

**Fitur TeacherPerformanceStats:**
- Tabel semua guru dengan sorting
- Statistik keseluruhan (average score, total materials, dll)
- Distribusi status dalam bentuk progress bar
- Top 3 performers
- Daftar guru yang perlu perhatian (inactive > 7 hari)

### 3. **Controller**
```
App\Http\Controllers\TeacherMonitoringController.php
```

Endpoints utama:
- `activityDashboard()` - View dashboard aktivitas
- `performanceDashboard()` - View dashboard performa
- `getActivitiesData()` - API untuk data aktivitas
- `recordActivity()` - Record aktivitas baru
- `updatePerformance()` - Update performa guru
- `exportActivities()` - Export ke CSV

### 4. **Routes**
```
Route::prefix('/kepsek/monitoring')->middleware(['auth', 'role:kepala_sekolah,kepsek,admin'])->group(function () {
    Route::get('/aktivitas', 'TeacherMonitoringController@activityDashboard');
    Route::get('/performa', 'TeacherMonitoringController@performanceDashboard');
    Route::get('/api/activities', 'TeacherMonitoringController@getActivitiesData');
    Route::post('/api/activities/record', 'TeacherMonitoringController@recordActivity');
    Route::get('/export/activities', 'TeacherMonitoringController@exportActivities');
});
```

### 5. **Views & Components**
```
resources/views/
├── livewire/
│   ├── teacher-activity-monitor.blade.php
│   └── teacher-performance-stats.blade.php
├── kepsek/monitoring/
│   ├── activity.blade.php
│   └── performance.blade.php
└── components/kepsek/
    ├── ⚡teacher-activity-monitor/
    │   └── teacher-activity-monitor.blade.php
    └── ⚡teacher-performance-stats/
        └── teacher-performance-stats.blade.php
```

---

## Instalasi & Setup

### Step 1: Verifikasi Requirements
```bash
# Pastikan Livewire sudah terinstall
composer require livewire/livewire:^4.4

# Di file HTML/layout, pastikan sudah include:
@livewireStyles
@livewireScripts
```

### Step 2: Run Migrations
```bash
php artisan migrate
```

Ini akan membuat 2 tabel:
- `teacher_activities`
- `teacher_performances`

### Step 3: (Optional) Seed Data Testing
```bash
php artisan db:seed --class=TeacherMonitoringSeeder
```

### Step 4: Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## Penggunaan

### Akses Dashboard Monitoring

**Dashboard Aktivitas Guru (Real-time):**
```
/kepsek/monitoring/aktivitas
```

**Dashboard Performa Guru (Real-time):**
```
/kepsek/monitoring/performa
```

### Fitur-Fitur Utama

#### 1. Activity Monitor
- **Live Updates**: Update otomatis setiap 3 detik
- **Search**: Cari berdasarkan nama, NIP, email guru
- **Filters**: 
  - Status: All, Active, Pending, Inactive
  - Activity Type: All, Material Upload, Video Upload, Assignment Create
- **Statistics**: Kartu statistik menampilkan total guru aktif, pending, inactive
- **Top Teachers**: 5 guru dengan aktivitas tertinggi
- **Activity Log**: List lengkap aktivitas dengan timestamp

#### 2. Performance Stats
- **Metrics Cards**: Tampilkan average score, total materials, videos, assignments
- **Status Distribution**: Progress bar untuk distribusi status guru
- **Top Performers**: 3 guru terbaik berdasarkan activity score
- **Needs Attention**: Guru yang inactive > 7 hari
- **Sortable Table**: Tabel semua guru yang bisa di-sort berdasarkan:
  - Activity Score
  - Last Activity Time
  - Materials Count
  - Videos Count

---

## API Endpoints

### 1. Get Activities Data
```bash
GET /kepsek/monitoring/api/activities?search=&status=all&activity_type=all&per_page=10
```

Response:
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "user_id": 2,
      "activity_type": "material_upload",
      "description": "Guru mengunggah materi pembelajaran",
      "created_at": "2026-10-14T15:30:00Z",
      "teacher": {
        "id": 2,
        "name": "Budi Santoso",
        "nip": "123456789",
        "subject": "Matematika"
      }
    }
  ],
  "pagination": {
    "current_page": 1,
    "last_page": 1,
    "total": 5,
    "per_page": 10
  }
}
```

### 2. Get Activity Stats
```bash
GET /kepsek/monitoring/api/activities/stats
```

Response:
```json
{
  "success": true,
  "stats": {
    "total_active": 5,
    "total_pending": 2,
    "total_inactive": 3,
    "total_all": 10,
    "recent_activity_count": 15
  },
  "top_teachers": [...]
}
```

### 3. Get Performance Data
```bash
GET /kepsek/monitoring/api/performance?sort_by=activity_score&sort_order=desc
```

### 4. Record Activity
```bash
POST /kepsek/monitoring/api/activities/record
Content-Type: application/json

{
  "user_id": 2,
  "activity_type": "material_upload",
  "description": "Guru mengunggah materi Matematika Kelas 5",
  "related_model": "LearningMaterial",
  "related_model_id": 1,
  "metadata": {
    "file_size": "2.5MB",
    "file_name": "materi.pdf"
  }
}
```

### 5. Update Performance
```bash
PUT /kepsek/monitoring/api/performance/{userId}
```

### 6. Export Activities
```bash
GET /kepsek/monitoring/export/activities?date_from=2026-10-01&date_to=2026-10-14
```

---

## Recording Aktivitas

### Menggunakan Trait RecordsTeacherActivity

Di dalam controller guru, tambahkan trait:

```php
use App\Traits\RecordsTeacherActivity;

class GuruController extends Controller
{
    use RecordsTeacherActivity;

    public function storeMateri(Request $request)
    {
        // ... validation & storage logic ...
        
        $material = LearningMaterial::create($validated);
        
        // Record aktivitas
        $this->recordMaterialUpload($material->id, $material->title);
        
        return redirect()->route('guru.materi')->with('success', 'Material berhasil diupload!');
    }
}
```

### Helper Methods dalam Trait

```php
// Record material upload
$this->recordMaterialUpload($materialId, $title);

// Record video upload
$this->recordVideoUpload($videoId, $title);

// Record assignment creation
$this->recordAssignmentCreate($assignmentId, $title);

// Record custom activity
$this->recordActivity(
    'custom_type',
    'Custom description',
    'RelatedModel',
    $relatedId,
    ['custom' => 'metadata']
);
```

### Manual Recording

Jika tidak menggunakan trait, gunakan model secara langsung:

```php
use App\Models\Monitoring\TeacherActivity;
use App\Models\Monitoring\TeacherPerformance;

TeacherActivity::recordActivity(
    auth()->id(),
    'material_upload',
    'Guru mengunggah materi pembelajaran',
    'LearningMaterial',
    $material->id
);

TeacherPerformance::updateOrCreateForTeacher(auth()->id());
```

---

## Konfigurasi Polling

### Mengubah Interval Polling

Di blade view, ubah parameter `pollingInterval`:

```blade
@livewire('teacher-activity-monitor', ['pollingInterval' => 5000])
```

Satuan: **milidetik**
- 3000 = 3 detik (default untuk activity)
- 5000 = 5 detik (default untuk performance)
- 10000 = 10 detik

### Disable Polling

Untuk disable polling, tambahkan `wire:poll` di template:

```blade
<div wire:poll.remove>
    <!-- content -->
</div>
```

---

## Middleware & Security

### Role-Based Access Control

Routes dilindungi dengan middleware:

```php
middleware(['auth', 'role:kepala_sekolah,kepsek,admin'])
```

Middleware ini mengecek apakah user memiliki role:
- `kepala_sekolah` (alias: `kepsek`)
- `kepsek`
- `admin`

### Register Middleware di app/Http/Kernel.php

```php
protected $routeMiddleware = [
    'role' => \App\Http\Middleware\CheckRole::class,
];
```

---

## Computed Properties & Reactivity

Livewire components menggunakan **Computed Properties** untuk reactivity:

```php
#[Computed]
public function teacherActivities()
{
    // Query otomatis di-cache & di-refresh saat ada perubahan
    return TeacherActivity::with('teacher')->latest('created_at')->get();
}
```

### Trigger Manual Refresh

Dari JavaScript:
```javascript
Livewire.dispatch('activity-refreshed');
```

### Event Listeners

```php
#[On('teacher-activity-created')]
public function onActivityCreated($userId, $activityType, $description)
{
    $this->dispatch('activity-refreshed');
}
```

---

## Status Determination

### Status Logic

| Kondisi | Status |
|---------|--------|
| Last activity dalam 24 jam | **Active** |
| Last activity 1-7 hari | **Pending** |
| Last activity > 7 hari atau tidak ada | **Inactive** |

### Activity Score (0-100)

```
Score = (materials_count × 10) + (videos_count × 15) + (assignments_count × 5)

Max: 100 (di-cap)
```

---

## Troubleshooting

### 1. Polling Tidak Berjalan

**Solusi:**
- Pastikan Livewire sudah include di layout: `@livewireScripts`
- Check browser console untuk error
- Verifikasi route `/livewire/update` accessible

### 2. Data Tidak Update

**Solusi:**
- Clear cache: `php artisan cache:clear`
- Check database connection
- Verifikasi table `teacher_activities` dan `teacher_performances` ada

### 3. Activity Tidak Ter-record

**Solusi:**
- Pastikan `recordActivity()` dipanggil di controller
- Check user authenticated dengan `Auth::check()`
- Verifikasi user memiliki role 'guru'

### 4. Permission Denied

**Solusi:**
- Pastikan user memiliki role `kepsek`, `kepala_sekolah`, atau `admin`
- Check middleware di routes
- Update role di database jika perlu

### 5. Broadcast Event Error

**Solusi:**
- Broadcasting opsional, jika error boleh di-ignore
- Untuk enable real-time events, setup Pusher/Redis
- Check `config/broadcasting.php`

---

## Performance Tips

### 1. Query Optimization
- Gunakan pagination untuk activity list
- Add index pada kolom `user_id`, `activity_type`, `created_at`
- Eager load relasi dengan `with()`

### 2. Caching
- Cache computed properties yang expensive
- Use `#[Computed]` untuk automatic caching
- Clear cache setelah batch operations

### 3. Polling Interval
- Activity Monitor: 3 detik (cepat)
- Performance Stats: 5 detik (balanced)
- Adjust sesuai server capacity

### 4. Database Maintenance
- Regular cleanup old activities (> 90 hari)
- Monitor table growth
- Add database indexes

---

## Deployment Checklist

- [ ] Run migrations: `php artisan migrate`
- [ ] Seed test data (optional): `php artisan db:seed --class=TeacherMonitoringSeeder`
- [ ] Clear cache: `php artisan cache:clear`
- [ ] Update routes: `php artisan route:clear`
- [ ] Check Livewire included in layout
- [ ] Verify middleware registered
- [ ] Test role-based access control
- [ ] Monitor performance metrics
- [ ] Setup backup strategy

---

## File Structure

```
app/
├── Events/
│   └── TeacherActivityCreated.php
├── Http/
│   ├── Controllers/
│   │   └── TeacherMonitoringController.php
│   └── Middleware/
│       └── CheckRole.php
├── Livewire/
│   ├── TeacherActivityMonitor.php
│   └── TeacherPerformanceStats.php
├── Models/
│   ├── Monitoring/
│   │   ├── TeacherActivity.php
│   │   └── TeacherPerformance.php
│   └── User.php (updated)
├── Traits/
│   └── RecordsTeacherActivity.php
└── Services/
    └── KepalaSekolahService.php (existing)

database/
├── migrations/
│   ├── 2026_10_14_000000_create_teacher_activities_table.php
│   └── 2026_10_14_000001_create_teacher_performances_table.php
└── seeders/
    └── TeacherMonitoringSeeder.php

resources/views/
├── livewire/
│   ├── teacher-activity-monitor.blade.php
│   └── teacher-performance-stats.blade.php
├── kepsek/monitoring/
│   ├── activity.blade.php
│   └── performance.blade.php
└── components/kepsek/
    ├── ⚡teacher-activity-monitor/
    │   └── teacher-activity-monitor.blade.php
    └── ⚡teacher-performance-stats/
        └── teacher-performance-stats.blade.php

routes/
└── web.php (updated)
```

---

## Support & Kontribusi

Untuk masalah atau pertanyaan, silakan buat issue atau hubungi tim development.

**Last Updated:** October 14, 2026
**Version:** 1.0.0
