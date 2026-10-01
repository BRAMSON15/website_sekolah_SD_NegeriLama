<?php

namespace App\Services;

use App\Models\User;
use App\Models\Student;
use App\Models\EducationalVideo;
use App\Models\LearningMaterial;
use App\Models\PpdbRegistration;
use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KepalaSekolahService
{
    /**
     * Mengambil seluruh data agregasi dan metrik untuk Dashboard Eksekutif Kepala Sekolah.
     */
    public function getDashboardData($user): array
    {
        // 1. Metrik Utama Sekolah
        $totalGuru = User::where('role', 'guru')->count();
        $totalSiswa = Student::count();
        $totalVideo = EducationalVideo::count();
        $totalMateri = LearningMaterial::count();
        $totalPpdb = PpdbRegistration::count();
        $totalPpdbPending = PpdbRegistration::where('status', 'menunggu')->count();
        $totalPpdbDiterima = PpdbRegistration::where('status', 'diterima')->count();

        // 2. Performa Guru Pengajar (Keaktifan Konten Digital)
        $teachers = User::where('role', 'guru')
            ->withCount(['materials', 'videos'])
            ->get();

        // 3. Aktivitas Terkini
        $recentVideos = EducationalVideo::with('user')->latest()->take(4)->get();
        $recentMaterials = LearningMaterial::with('user')->latest()->take(4)->get();
        $recentPpdb = PpdbRegistration::latest()->take(5)->get();
        $announcements = Announcement::active()->latest('published_at')->take(4)->get();

        return compact(
            'user',
            'totalGuru',
            'totalSiswa',
            'totalVideo',
            'totalMateri',
            'totalPpdb',
            'totalPpdbPending',
            'totalPpdbDiterima',
            'teachers',
            'recentVideos',
            'recentMaterials',
            'recentPpdb',
            'announcements'
        );
    }

    /**
     * Mengambil data pemantauan dewan guru & keaktifan pengajaran digital.
     */
    public function getMonitoringGuruData(Request $request): array
    {
        $search = trim($request->get('search', ''));

        $query = User::where('role', 'guru')
            ->withCount(['materials', 'videos']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $teachers = $query->get();

        $totalTeachers = User::where('role', 'guru')->count();
        $totalVideosUploaded = EducationalVideo::count();
        $totalMaterialsUploaded = LearningMaterial::count();

        return compact(
            'teachers',
            'search',
            'totalTeachers',
            'totalVideosUploaded',
            'totalMaterialsUploaded'
        );
    }

    /**
     * Mengambil data supervisi media pembelajaran (video & modul materi).
     */
    public function getMonitoringPembelajaranData(Request $request): array
    {
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

        $totalVideoCount = EducationalVideo::count();
        $totalMaterialCount = LearningMaterial::count();
        $totalDownloads = LearningMaterial::sum('downloads');
        $totalCombined = $totalVideoCount + $totalMaterialCount;

        $availableClasses = [
            'Semua Kelas',
            'Kelas I',
            'Kelas II',
            'Kelas III',
            'Kelas IV',
            'Kelas V',
            'Kelas VI'
        ];

        return compact(
            'tab',
            'classLevel',
            'search',
            'videos',
            'materials',
            'totalVideoCount',
            'totalMaterialCount',
            'totalDownloads',
            'totalCombined',
            'availableClasses'
        );
    }

    /**
     * Mengambil data pemantauan pendaftaran PPDB Online.
     */
    public function getMonitoringPpdbData(Request $request): array
    {
        $status = $request->get('status', 'all');
        $track = $request->get('track', 'all');
        $search = trim($request->get('search', ''));
        $isPrint = $request->boolean('print', false);

        $query = PpdbRegistration::query();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        if ($track && $track !== 'all') {
            $query->where('registration_track', $track);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%")
                  ->orWhere('previous_school', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->get();

        $totalAll = PpdbRegistration::count();
        $totalPending = PpdbRegistration::where('status', 'menunggu')->count();
        $totalApproved = PpdbRegistration::where('status', 'diterima')->count();
        $totalRejected = PpdbRegistration::where('status', 'ditolak')->count();

        $totalLaki = PpdbRegistration::where('gender', 'L')->count();
        $totalPerempuan = PpdbRegistration::where('gender', 'P')->count();

        return compact(
            'registrations',
            'status',
            'track',
            'search',
            'isPrint',
            'totalAll',
            'totalPending',
            'totalApproved',
            'totalRejected',
            'totalLaki',
            'totalPerempuan'
        );
    }

    /**
     * Mengambil metrik sistem & parameter server untuk supervisi teknis.
     */
    public function getMonitoringSistemData(): array
    {
        $stats = [
            'users_total'         => User::count(),
            'guru_count'          => User::where('role', 'guru')->count(),
            'admin_count'         => User::where('role', 'admin')->count(),
            'kepsek_count'        => User::whereIn('role', ['kepala_sekolah', 'kepsek'])->count(),
            'students_count'      => Student::count(),
            'videos_count'        => EducationalVideo::count(),
            'materials_count'     => LearningMaterial::count(),
            'ppdb_count'          => PpdbRegistration::count(),
            'announcements_count' => Announcement::count(),
            'active_announcements'=> Announcement::active()->count(),
        ];

        $serverInfo = [
            'php_version'    => PHP_VERSION,
            'laravel_version'=> app()->version(),
            'database'       => config('database.default'),
            'app_env'        => config('app.env'),
            'app_url'        => config('app.url'),
            'timezone'       => config('app.timezone'),
        ];

        return compact('stats', 'serverInfo');
    }
}
