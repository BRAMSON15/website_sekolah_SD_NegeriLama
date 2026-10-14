# Diagnosis 500 Error pada Form PPDB

## 📋 Gejala
- Form PPDB submit menunjukkan 500 Server Error
- Error terjadi saat mengirim data ke hosting
- Form validation mungkin tampil tapi submit gagal

---

## 🔍 Kemungkinan Penyebab (Prioritas)

### 1. **File Storage Path Issue** 🔴 HIGH PRIORITY
**Lokasi**: `PpdbController::store()`
```php
// Line 47-52
$validated['supporting_file_kk'] = $request->file('supporting_file_kk')->store('ppdb/supporting-files', 'public');
```

**Masalah Potensial**:
- ❌ Folder `storage/app/public/ppdb/supporting-files` tidak ada
- ❌ Permission folder tidak correct
- ❌ Disk 'public' tidak ter-config dengan benar di hosting
- ❌ Symlink tidak ada antara `public/storage` dan `storage/app/public`

**Cara Cek di Hosting**:
```bash
# SSH ke hosting
ls -la storage/app/public/
ls -la public/storage
php artisan storage:link  # Jika belum dibuat
mkdir -p storage/app/public/ppdb/supporting-files
chmod 755 storage/app/public/ppdb
chmod 755 storage/app/public/ppdb/supporting-files
```

---

### 2. **Missing Column di Database** 🟠 MEDIUM PRIORITY
**Lokasi**: Database migration

**Masalah**:
- Migration `2026_10_11_000000_add_supporting_files_to_ppdb_registrations_table.php` belum di-run di hosting
- Table `ppdb_registrations` masih tidak memiliki kolom `supporting_file_kk`, `supporting_file_akte`, `supporting_file_rapor`

**Cara Cek**:
```bash
# SSH ke hosting
php artisan migrate:status
php artisan migrate  # Run all pending migrations
```

**Atau langsung check di database**:
```sql
DESCRIBE ppdb_registrations;
```

---

### 3. **File Upload Validation Issue** 🟠 MEDIUM PRIORITY
**Lokasi**: `PpdbController::store()` line 24-35

**Masalah Potensial**:
- ❌ File size limit di server lebih kecil (php.ini: upload_max_filesize, post_max_size)
- ❌ MIME type detection error di hosting
- ❌ File tidak terdeteksi sebagai file valid

**Debugging Steps**:
```php
// Add di controller temporary
dd($request->all());  // Lihat apa yang dikirim
dd($request->files);  // Lihat file yang dikirim
```

---

### 4. **Error Handling & Logging** 🟠 MEDIUM PRIORITY
**Masalah**:
- Error tidak di-log dengan proper
- 500 error generic tanpa detail

**Lokasi untuk improvement**: 
- `app/Exceptions/Handler.php` - Tidak ada custom error logging untuk file uploads

---

### 5. **Environment Configuration** 🟡 LOW PRIORITY
**Lokasi**: `.env` file

**Masalah Potensial**:
```env
# Tidak proper di-set di hosting
APP_DEBUG=false  # Menyembunyikan error detail
FILESYSTEM_DISK=local  # Mungkin perlu 'public'
```

---

## 🛠️ Solusi (Priority Order)

### URGENT FIX #1: Run Migration di Hosting
```bash
ssh user@hosting
cd /path/to/SDNegeriLama
php artisan migrate --force
```

**Verify**:
```bash
php artisan tinker
>>> \App\Models\PpdbRegistration::first();
```

---

### URGENT FIX #2: Create Storage Link & Folders
```bash
ssh user@hosting
cd /path/to/SDNegeriLama

# Buat symlink jika belum ada
php artisan storage:link

# Buat folder untuk file
mkdir -p storage/app/public/ppdb/supporting-files
chmod -R 755 storage/app/public
chmod -R 755 public/storage
```

---

### IMPORTANT FIX #3: Improve Error Handling
**File**: `app/Http/Controllers/PpdbController.php`

**Tambahkan try-catch**:
```php
public function store(Request $request)
{
    try {
        $validated = $request->validate([...]);
        
        // Handle file uploads dengan error checking
        if ($request->hasFile('supporting_file_kk')) {
            if (!$request->file('supporting_file_kk')->isValid()) {
                throw new \Exception('File KK tidak valid');
            }
            $validated['supporting_file_kk'] = $request->file('supporting_file_kk')
                ->store('ppdb/supporting-files', 'public');
        }
        
        if ($request->hasFile('supporting_file_akte')) {
            if ($request->file('supporting_file_akte')->isValid()) {
                $validated['supporting_file_akte'] = $request->file('supporting_file_akte')
                    ->store('ppdb/supporting-files', 'public');
            }
        }
        
        if ($request->hasFile('supporting_file_rapor')) {
            if ($request->file('supporting_file_rapor')->isValid()) {
                $validated['supporting_file_rapor'] = $request->file('supporting_file_rapor')
                    ->store('ppdb/supporting-files', 'public');
            }
        }

        $registration = $this->ppdbService->register($validated);

        return redirect()->route('ppdb.success', $registration)
            ->with('success', 'Pendaftaran PPDB berhasil dikirim.');
            
    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        \Log::error('PPDB Registration Error', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
        
        return back()
            ->with('error', 'Terjadi kesalahan saat memproses pendaftaran. Silakan coba lagi.')
            ->withInput();
    }
}
```

---

### GOOD PRACTICE FIX #4: Add Logging
**File**: `app/Services/PpdbService.php`

```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class PpdbService
{
    public function register(array $data): PpdbRegistration
    {
        try {
            $data['registration_number'] = $this->generateRegistrationNumber();
            $data['status'] = 'pending';

            $registration = PpdbRegistration::create($data);
            
            Log::info('PPDB Registration Created', [
                'registration_id' => $registration->id,
                'registration_number' => $registration->registration_number,
                'student_name' => $registration->student_name,
            ]);

            return $registration;
        } catch (\Exception $e) {
            Log::error('PPDB Registration Failed', [
                'message' => $e->getMessage(),
                'data' => $data,
            ]);
            throw $e;
        }
    }
}
```

---

## 📊 Checklist untuk Debugging di Hosting

- [ ] SSH ke hosting server
- [ ] Cek folder `storage/app/public/ppdb/supporting-files` ada
- [ ] Cek file permissions: `chmod 755`
- [ ] Run migration: `php artisan migrate`
- [ ] Verify symlink: `ls -la public/storage`
- [ ] Check `php artisan storage:link` executed
- [ ] Cek `.env` file setting: `FILESYSTEM_DISK=public`
- [ ] Cek `php.ini` settings:
  - `upload_max_filesize = 20M`
  - `post_max_size = 30M`
- [ ] Cek Laravel cache: `php artisan cache:clear`
- [ ] Cek Laravel config: `php artisan config:clear`
- [ ] Test form submit dengan file kecil (< 100KB)
- [ ] Check error log: `tail -f storage/logs/laravel.log`

---

## 🔧 Quick Fix Commands

Run ini di hosting via SSH:

```bash
#!/bin/bash
# Navigate to project
cd /path/to/SDNegeriLama

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Run pending migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Ensure proper permissions
mkdir -p storage/app/public/ppdb/supporting-files
chmod -R 755 storage
chmod -R 755 public/storage

# Test if everything works
php artisan tinker
>>> \App\Models\PpdbRegistration::count();
```

---

## 🧪 Test di Local Terlebih Dahulu

Sebelum deploy ke hosting:

```bash
# Local testing
php artisan migrate
php artisan storage:link
mkdir -p storage/app/public/ppdb/supporting-files

# Test form submit dengan file
# Cek storage/app/public/ppdb/supporting-files sudah punya file
# Cek public/storage/ppdb/supporting-files accessible via browser
```

---

## 📝 Log File Location

Cek error details di:
```
storage/logs/laravel.log
```

Command untuk lihat real-time:
```bash
tail -f storage/logs/laravel.log
```

---

## 🎯 Summary

**Most Likely Cause**: Database migration belum di-run di hosting, atau storage symlink tidak ada.

**Quick Fix**: 
1. SSH ke hosting
2. Run: `php artisan migrate`
3. Run: `php artisan storage:link`
4. Test form submit lagi

**If Still Error**:
1. Check `storage/logs/laravel.log` untuk detail error
2. Verify file upload size limits di php.ini
3. Ensure folder permissions 755
4. Apply error handling improvements di controller

---

**Last Updated**: October 14, 2026
