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
        $studentProfile = $user && $user->role === 'siswa' && $user->nip
            ? Student::where('nisn', $user->nip)->first()
            : null;
        $studentGrade = $this->classGradeNumber($studentProfile?->class_name);

        $tab = $request->get('tab', 'all'); // 'all', 'video', 'materi'
        $classLevel = $studentProfile?->class_name;
        $search = trim($request->get('search', ''));

        $videoQuery = EducationalVideo::with('user');
        if ($search) {
            $videoQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        $videos = ($tab === 'materi' || ! $studentGrade)
            ? collect()
            : $videoQuery->latest()->get()
                ->filter(fn ($video) => $this->isVisibleForGrade($video->class_level, $studentGrade))
                ->values();

        $materialQuery = LearningMaterial::with('user');
        if ($search) {
            $materialQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        $materials = ($tab === 'video' || ! $studentGrade)
            ? collect()
            : $materialQuery->latest()->get()
                ->filter(fn ($material) => $this->isVisibleForGrade($material->class_level, $studentGrade))
                ->values();

        $totalVideoCount = $studentGrade
            ? EducationalVideo::get(['class_level'])->filter(fn ($video) => $this->isVisibleForGrade($video->class_level, $studentGrade))->count()
            : 0;
        $totalMaterialCount = $studentGrade
            ? LearningMaterial::get(['class_level'])->filter(fn ($material) => $this->isVisibleForGrade($material->class_level, $studentGrade))->count()
            : 0;
        $totalCombinedCount = $totalVideoCount + $totalMaterialCount;
        $availableClasses = $classLevel ? [$classLevel] : [];

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

    private function isVisibleForGrade(string $contentClass, int $studentGrade): bool
    {
        return strtolower(trim($contentClass)) === 'semua kelas'
            || $this->classGradeNumber($contentClass) === $studentGrade;
    }

    private function classGradeNumber(?string $className): ?int
    {
        if (! $className || ! preg_match('/^(?:KELAS\s*)?(VI|IV|V|III|II|I|[1-6])(?:\s*[A-Z])?/i', trim($className), $matches)) {
            return null;
        }

        return match (strtoupper($matches[1])) {
            'I' => 1,
            'II' => 2,
            'III' => 3,
            'IV' => 4,
            'V' => 5,
            'VI' => 6,
            default => (int) $matches[1],
        };
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
        } else {
            $user->update([
                'name' => $student->name,
                'nip' => $student->nisn,
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
