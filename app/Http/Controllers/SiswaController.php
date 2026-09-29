<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\SchoolSetting;
use App\Models\Announcement;
use App\Models\Feature;
use App\Models\EducationalVideo;
use App\Models\LearningMaterial;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    private function getSettings()
    {
        return SchoolSetting::pluck('value', 'key')->toArray();
    }

    /**
     * Beranda khusus siswa terdaftar (Portal Pembelajaran Digital)
     */
    public function beranda(Request $request)
    {
        $settings = $this->getSettings();
        $user = Auth::user();

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

        return view('siswa.beranda', compact(
            'settings',
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
        ));
    }

    /**
     * Download file materi pembelajaran khusus siswa
     */
    public function downloadMateri(LearningMaterial $material)
    {
        $material->increment('downloads');

        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            return Storage::disk('public')->download($material->file_path, $material->title . '.' . pathinfo($material->file_path, PATHINFO_EXTENSION));
        }

        // Jika file fisik tidak tersedia, buat dokumen teks konfirmasi materi
        $content = "MATERI PEMBELAJARAN SD NEGERI LAMA\n";
        $content .= "======================================\n";
        $content .= "Judul       : " . $material->title . "\n";
        $content .= "Mata Pelajaran: " . $material->subject . "\n";
        $content .= "Tingkat Kelas : " . $material->class_level . "\n";
        $content .= "Pengunggah    : " . ($material->user ? $material->user->name : 'Bapak/Ibu Guru') . "\n";
        $content .= "Keterangan    : " . ($material->description ?: 'Bahan ajar materi pembelajaran mandiri siswa.') . "\n";
        $content .= "======================================\n";
        $content .= "Catatan: File modul fisik sedang diperbarui oleh guru pengampu. Silakan tanyakan kepada guru mata pelajaran Anda.";

        return response($content, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="' . str_replace(' ', '_', $material->title) . '.txt"',
        ]);
    }

    /**
     * Verifikasi & Akses Langsung Siswa dengan NISN Terdaftar
     */
    public function aksesNisn(Request $request)
    {
        $request->validate([
            'nisn' => ['required', 'string'],
        ], [
            'nisn.required' => 'Nomor NISN siswa wajib diisi.',
        ]);

        $nisn = trim($request->nisn);

        // Cari data siswa terdaftar berdasarkan NISN atau nama
        $student = Student::where('nisn', $nisn)
            ->orWhereRaw('LOWER(name) = ?', [strtolower($nisn)])
            ->first();

        if (! $student) {
            return back()->with('error_nisn', 'Nomor NISN "' . $nisn . '" tidak terdaftar sebagai siswa aktif SD Negeri Lama. Silakan periksa kembali.')
                ->withInput();
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
        $request->session()->regenerate();

        return redirect()->route('siswa.beranda')
            ->with('success', 'Verifikasi berhasil! Selamat datang di Ruang Belajar, ' . $student->name . ' (' . $student->class_name . ')!');
    }
}
