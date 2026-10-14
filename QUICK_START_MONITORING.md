# Quick Start Guide - Monitoring Guru Real-time

## 🚀 Mulai dalam 5 Menit

### Step 1: Verifikasi Database ✅
Database sudah berisi data test:
- **19 teacher activities** (sudah di-seed)
- **3 teacher performances** (sudah di-seed)

### Step 2: Login sebagai Kepala Sekolah/Admin
```
URL: http://localhost/login/kepsek
Role: kepala_sekolah atau admin
```

### Step 3: Akses Dashboard Monitoring

#### Dashboard Aktivitas Guru (Real-time)
```
http://localhost/kepsek/monitoring/aktivitas
```
**Fitur:**
- Live monitoring aktivitas guru setiap 3 detik
- Search by nama, NIP, email
- Filter by status (Active/Pending/Inactive)
- Filter by tipe aktivitas (Material/Video/Assignment)
- Statistics cards
- Top 5 guru paling aktif
- Pagination

#### Dashboard Performa Guru (Real-time)
```
http://localhost/kepsek/monitoring/performa
```
**Fitur:**
- Metrics cards (average score, total materials, etc)
- Status distribution chart
- Top 3 performers
- Guru yang perlu perhatian
- Sortable table
- Update setiap 5 detik

---

## 📊 Data yang Tersedia

### TeacherActivity Table
```
19 aktivitas dari 5 guru dalam 7 hari terakhir:
- Material uploads: ~7
- Video uploads: ~6
- Assignment creates: ~6
```

### TeacherPerformance Table
```
3 guru dengan performa terbaru:
- Activity scores: 15, 25, 30
- Status: active/pending/inactive
- Last activity timestamps
```

---

## 🔧 Integrasi dengan Existing Code

### 1. Record Activity saat Guru Upload Material

Di file `app/Http/Controllers/GuruController.php`, tambahkan:

```php
<?php

namespace App\Http\Controllers;

use App\Traits\RecordsTeacherActivity;

class GuruController extends Controller
{
    use RecordsTeacherActivity;  // ← Add this trait
    
    public function storeMateri(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            // ... other validations ...
        ]);

        $material = LearningMaterial::create($validated);
        
        // ← Add this line to record activity
        $this->recordMaterialUpload($material->id, $material->title);

        return redirect()->route('guru.materi')->with('success', 'Material uploaded!');
    }
    
    public function storeVideo(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            // ... validations ...
        ]);

        $video = EducationalVideo::create($validated);
        
        // ← Add this line to record activity
        $this->recordVideoUpload($video->id, $video->title);

        return redirect()->route('guru.video')->with('success', 'Video uploaded!');
    }
}
```

### 2. Di Other Controllers

```php
// Record custom activity
$this->recordActivity(
    'activity_type',
    'Description here',
    'RelatedModel',
    $modelId
);
```

---

## 🔍 Testing API Endpoints

### Test 1: Get Activities
```bash
curl "http://localhost/kepsek/monitoring/api/activities?per_page=5"
```

Expected response:
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "activity_type": "material_upload",
      "description": "Guru mengunggah materi pembelajaran",
      "created_at": "2026-10-14T15:30:00Z"
    }
  ],
  "pagination": {
    "current_page": 1,
    "total": 19
  }
}
```

### Test 2: Get Stats
```bash
curl "http://localhost/kepsek/monitoring/api/activities/stats"
```

### Test 3: Get Performance
```bash
curl "http://localhost/kepsek/monitoring/api/performance?sort_by=activity_score"
```

### Test 4: Record New Activity
```bash
curl -X POST "http://localhost/kepsek/monitoring/api/activities/record" \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 2,
    "activity_type": "material_upload",
    "description": "Test material upload",
    "metadata": {"test": true}
  }'
```

---

## 📲 Mobile Access

Sistem ini fully responsive dan bisa diakses dari mobile:
```
https://your-domain.com/kepsek/monitoring/aktivitas
https://your-domain.com/kepsek/monitoring/performa
```

---

## ⚙️ Customization

### Ubah Polling Interval

Edit di `resources/views/kepsek/monitoring/activity.blade.php`:

```blade
@livewire('teacher-activity-monitor', ['pollingInterval' => 5000])  // 5 detik
```

### Ubah Pagination Per Page

Edit di `app/Livewire/TeacherActivityMonitor.php`:

```php
public int $perPage = 20;  // Changed from 10
```

### Ubah Activity Score Formula

Edit di `app/Models/Monitoring/TeacherPerformance.php`:

```php
$activityScore = min(
    100,
    ($materialsCount * 10) +      // Weight: 10
    ($videosCount * 15) +         // Weight: 15
    ($assignmentsCount * 5)       // Weight: 5
);
```

---

## 🆘 Common Issues & Solutions

### Issue: Dashboard tidak menampilkan data

**Solution:**
1. Refresh browser
2. Clear cache: `php artisan cache:clear`
3. Check user role: kepsek/kepala_sekolah/admin
4. Verify tables exist: `php artisan tinker`

### Issue: Livewire polling tidak berjalan

**Solution:**
1. Check browser console untuk errors
2. Verify layout includes: `@livewireScripts`
3. Check Livewire route `/livewire/update` working

### Issue: Activity tidak terupdate real-time

**Solution:**
1. Verify data inserted to database
2. Check polling interval (shouldn't be too long)
3. Refresh component manually with browser refresh

---

## 📚 Full Documentation

Untuk dokumentasi lengkap, baca:
- **LIVEWIRE_MONITORING_SETUP.md** - Setup guide & API docs
- **MONITORING_IMPLEMENTATION_SUMMARY.md** - Implementation details

---

## 📝 File Locations

### Key Files
```
app/
├── Livewire/
│   ├── TeacherActivityMonitor.php
│   └── TeacherPerformanceStats.php
├── Http/Controllers/
│   └── TeacherMonitoringController.php
├── Models/Monitoring/
│   ├── TeacherActivity.php
│   └── TeacherPerformance.php
└── Traits/
    └── RecordsTeacherActivity.php

resources/views/
├── livewire/
│   ├── teacher-activity-monitor.blade.php
│   └── teacher-performance-stats.blade.php
└── kepsek/monitoring/
    ├── activity.blade.php
    └── performance.blade.php

routes/
└── web.php (monitoring routes added)
```

---

## ✅ Verification Checklist

- [x] Database migrations executed
- [x] Test data seeded (19 activities, 3 performances)
- [x] Routes registered
- [x] Livewire components created
- [x] Views rendered correctly
- [x] API endpoints working
- [x] Real-time polling functional
- [x] Role-based access control implemented

---

## 🎯 Next Steps

1. **Integrate with Existing Code**
   - Add `RecordsTeacherActivity` trait to GuruController
   - Record activities saat material/video/assignment upload

2. **Customize for Your Needs**
   - Adjust polling intervals
   - Modify score calculation
   - Add additional filters

3. **Monitor in Production**
   - Track dashboard usage
   - Monitor database growth
   - Optimize queries if needed

4. **Optional Enhancements**
   - Email alerts untuk inactive teachers
   - SMS notifications
   - Performance reports
   - Advanced analytics

---

## 🚨 Production Checklist

Before going live:

- [ ] Run migrations on production database
- [ ] Update existing controllers dengan RecordsTeacherActivity
- [ ] Configure email/SMS alerts (if needed)
- [ ] Setup database backups
- [ ] Monitor performance metrics
- [ ] Test with actual users
- [ ] Document custom configurations
- [ ] Setup error monitoring (Sentry/etc)

---

**Happy monitoring! 🎉**

For questions or issues, refer to the full documentation files.
