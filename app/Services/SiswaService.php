<?php

namespace App\Services;

use App\Models\Student;
use App\Models\EducationalVideo;
use App\Models\LearningMaterial;
use App\Models\Announcement;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SiswaService
{
    /**
     * Mengambil seluruh data konten pembelajaran digital untuk Beranda Siswa Terdaftar.
     */
    public function getBerandaData(Request $request, $user): array
    {
        // Cari profil siswa terdaftar jika ada
        $studentProfile = null;
        if ($user) {
            $studentProfile = Student::where('name', $user->name)
                ->orWhere('nisn', $user->nip)
                ->first();
        }

        $tab = $request->get('tab', 'all'); // 'all', 'video', 'materi'
        $classLevel = $request->get('class_level');
        $search = trim($request->get('search', ''));

        // Query Videos
        $videoQuery = EducationalVideo::with('user');
        if ($classLevel && $classLevel !== 'Semua Kelas') {
            $videoQuery->where('class_level', $classLevel);
        }
        if ($search) {
            $videoQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        $videos = ($tab === 'materi') ? collect() : $videoQuery->latest()->get();

        // Query Materials
        $materialQuery = LearningMaterial::with('user');
        if ($classLevel && $classLevel !== 'Semua Kelas') {
            $materialQuery->where('class_level', $classLevel);
        }
        if ($search) {
            $materialQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        $materials = ($tab === 'video') ? collect() : $materialQuery->latest()->get();

        // Totals & Available Filters
        $totalVideoCount = EducationalVideo::count();
        $totalMaterialCount = LearningMaterial::count();
        $totalCombinedCount = $totalVideoCount + $totalMaterialCount;

        $availableClasses = [
            'Semua Kelas',
            'Kelas I',
            'Kelas II',
            'Kelas III',
            'Kelas IV',
            'Kelas V',
            'Kelas VI'
        ];

        // Unique active subjects for quick filter pills
        $videoSubjects = EducationalVideo::distinct()->pluck('subject')->toArray();
        $materialSubjects = LearningMaterial::distinct()->pluck('subject')->toArray();
        $availableSubjects = array_unique(array_filter(array_merge($videoSubjects, $materialSubjects)));

        $announcements = Announcement::active()->take(4)->get();
        $features = Feature::orderBy('order', 'asc')->get();

        return compact(
            'user',
            'studentProfile',
            'tab',
            'classLevel',
            'search',
            'videos',
            'materials',
            'totalVideoCount',
            'totalMaterialCount',
            'totalCombinedCount',
            'availableClasses',
            'availableSubjects',
            'announcements',
            'features'
        );
    }

    /**
     * Memproses download modul pembelajaran siswa atau menyajikan berkas fallback informasi.
     */
    public function downloadMaterial(LearningMaterial $material): Response
    {
        $material->increment('downloads');

        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            return Storage::disk('public')->download(
                $material->file_path,
                $material->title . '.' . pathinfo($material->file_path, PATHINFO_EXTENSION)
            );
        }

        // Jika file fisik belum tersedia, hasilkan dokumen teks ringkasan materi
        $content = "MATERI PEMBELAJARAN SD NEGERI LAMA\n";
        $content .= "======================================\n";
        $content .= "Judul         : " . $material->title . "\n";
        $content .= "Mata Pelajaran: " . $material->subject . "\n";
        $content .= "Tingkat Kelas : " . $material->class_level . "\n";
        $content .= "Pengunggah    : " . ($material->user ? $material->user->name : 'Bapak/Ibu Guru') . "\n";
        $content .= "Keterangan    : " . ($material->description ?: 'Bahan ajar materi pembelajaran mandiri siswa.') . "\n";
        $content .= "======================================\n";
        $content .= "Catatan: File modul fisik sedang disinkronkan oleh guru pengampu. Silakan tanyakan kepada guru mata pelajaran Anda.";

        return response($content, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="' . str_replace(' ', '_', $material->title) . '.txt"',
        ]);
    }

    /**
     * Memverifikasi NISN siswa terdaftar, menyiapkan akun pengguna, dan mengautentikasi sesi.
     */
    public function authenticateByNisn(string $nisn, Request $request): ?Student
    {
        $student = Student::where('nisn', $nisn)
            ->orWhereRaw('LOWER(name) = ?', [strtolower($nisn)])
            ->first();

        if (! $student) {
            return null;
        }

        // Cari atau buat User untuk siswa ini
        $user = User::where('role', 'siswa')
            ->where(function ($q) use ($student) {
                $q->where('nip', $student->nisn)
                  ->orWhere('name', $student->name)
                  ->orWhere('email', $student->nisn . '@siswa.sdnegerilama.sch.id');
            })
            ->first();

        if (! $user) {
            $user = User::create([
                'name'     => $student->name,
                'email'    => $student->nisn . '@siswa.sdnegerilama.sch.id',
                'nip'      => $student->nisn,
                'role'     => 'siswa',
                'password' => Hash::make($student->nisn),
            ]);
        }

        // Bersihkan sesi sebelumnya jika login sebagai role lain
        if (Auth::check()) {
            Auth::logout();
        }

        Auth::login($user);
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        return $student;
    }
}
