<?php

namespace App\Services;

use App\Models\Student;
use App\Models\LearningMaterial;
use App\Models\EducationalVideo;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruService
{
    /* -------------------------------------------------------------
     * 1. DASHBOARD GURU
     * ------------------------------------------------------------- */
    public function getDashboardData($user): array
    {
        $stats = [
            'classes'       => Student::select('class_name')->distinct()->count() ?: 3,
            'materials'     => LearningMaterial::count(),
            'videos'        => EducationalVideo::count(),
            'announcements' => Announcement::active()->count(),
        ];

        $featuredVideo = EducationalVideo::latest()->first();
        $recentMaterials = LearningMaterial::latest()->take(3)->get();

        $classesList = Student::select('class_name')
            ->distinct()
            ->get()
            ->map(function ($item) use ($user) {
                $count = Student::where('class_name', $item->class_name)->count();
                $badge = str_replace('Kelas ', '', $item->class_name);
                $badgeColor = str_contains($badge, '4') ? 'cyan' : (str_contains($badge, '5') ? 'purple' : 'orange');

                return [
                    'name'           => $item->class_name,
                    'badge'          => $badge,
                    'badge_color'    => $badgeColor,
                    'students_count' => $count,
                    'subject'        => $user->subject ?: 'Guru Pengajar',
                ];
            });

        return compact('stats', 'featuredVideo', 'recentMaterials', 'classesList');
    }

    /* -------------------------------------------------------------
     * 2. MATERI PEMBELAJARAN
     * ------------------------------------------------------------- */
    public function getMaterials(Request $request)
    {
        $query = LearningMaterial::query();

        if ($request->filled('class')) {
            $query->where('class_level', $request->class);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        return $query->latest()->get();
    }

    public function storeMaterial(array $data, $file, int $userId): LearningMaterial
    {
        $filePath = null;
        $fileSize = '1.2 MB';
        $fileType = $data['file_type'] ?? 'PDF Dokumen';

        if ($file) {
            $filePath = $file->store('materi', 'public');
            $fileSize = round($file->getSize() / 1024 / 1024, 1) . ' MB';
            $ext = strtolower($file->getClientOriginalExtension());
            if ($ext === 'pdf') {
                $fileType = 'PDF Dokumen';
            } elseif (in_array($ext, ['doc', 'docx'])) {
                $fileType = 'DOCX Lembar Kerja';
            } elseif (in_array($ext, ['ppt', 'pptx'])) {
                $fileType = 'PPTX Presentasi';
            } else {
                $fileType = strtoupper($ext) . ' Berkas';
            }
        }

        return LearningMaterial::create([
            'user_id'     => $userId,
            'title'       => $data['title'],
            'subject'     => $data['subject'],
            'class_level' => $data['class_level'],
            'description' => $data['description'] ?? 'Materi pembelajaran mandiri peserta didik.',
            'file_path'   => $filePath,
            'file_type'   => $fileType,
            'file_size'   => $fileSize,
            'downloads'   => 0,
        ]);
    }

    public function downloadMaterial(LearningMaterial $material)
    {
        $material->increment('downloads');

        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            return Storage::disk('public')->download($material->file_path);
        }

        return response($material->title . "\n\nMateri Pembelajaran " . $material->subject . "\n" . $material->class_level . "\n\n" . $material->description)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . str()->slug($material->title) . '.txt"');
    }

    public function deleteMaterial(LearningMaterial $material): void
    {
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();
    }

    /* -------------------------------------------------------------
     * 3. VIDEO EDUKASI (YOUTUBE & GOOGLE DRIVE)
     * ------------------------------------------------------------- */
    public function getVideoGallery(Request $request): array
    {
        $query = EducationalVideo::query();

        if ($request->filled('search')) {
            $keyword = trim($request->get('search'));
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('subject', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('class_level') && $request->get('class_level') !== 'Semua Kelas') {
            $query->where('class_level', $request->get('class_level'));
        }

        if ($request->filled('source_type') && in_array($request->get('source_type'), ['youtube', 'google_drive'])) {
            $query->where('source_type', $request->get('source_type'));
        }

        $videos = $query->latest()->get();

        $activeVideoId = $request->get('play');
        $activeVideo = $videos->firstWhere('id', $activeVideoId) ?: ($videos->first() ?: EducationalVideo::latest()->first());

        if ($activeVideo && $request->has('play')) {
            $activeVideo->increment('views_count');
        }

        $allVideos = EducationalVideo::all();
        $stats = [
            'total'        => $allVideos->count(),
            'youtube'      => $allVideos->where('source_type', 'youtube')->count(),
            'google_drive' => $allVideos->where('source_type', 'google_drive')->count(),
            'views'        => $allVideos->sum('views_count'),
        ];

        return compact('videos', 'activeVideo', 'stats');
    }

    public function sanitizeVideoUrl(string $url): string
    {
        $url = trim($url);
        if (preg_match('/src=["\']([^"\']+)["\']/', $url, $matches)) {
            $url = $matches[1];
        }

        return $url;
    }

    public function detectSourceType(string $url, ?string $selectedType = null): string
    {
        if ($selectedType && in_array($selectedType, ['youtube', 'google_drive'])) {
            return $selectedType;
        }

        if (str_contains($url, 'drive.google.com') || str_contains($url, 'docs.google.com')) {
            return 'google_drive';
        }

        return 'youtube';
    }

    public function storeVideo(array $data, int $userId): EducationalVideo
    {
        $rawUrl = $this->sanitizeVideoUrl($data['video_url'] ?? $data['youtube_url'] ?? '');
        $sourceType = $this->detectSourceType($rawUrl, $data['source_type'] ?? null);

        return EducationalVideo::create([
            'user_id'     => $userId,
            'title'       => $data['title'],
            'subject'     => $data['subject'],
            'class_level' => $data['class_level'],
            'source_type' => $sourceType,
            'video_url'   => $rawUrl,
            'youtube_url' => $rawUrl,
            'duration'    => $data['duration'],
            'description' => $data['description'] ?? 'Video edukasi pembelajaran interaktif.',
            'views_count' => 0,
        ]);
    }

    public function updateVideo(EducationalVideo $video, array $data): EducationalVideo
    {
        $rawUrl = $this->sanitizeVideoUrl($data['video_url'] ?? $data['youtube_url'] ?? $video->effective_url);
        $sourceType = $this->detectSourceType($rawUrl, $data['source_type'] ?? null);

        $video->update([
            'title'       => $data['title'],
            'subject'     => $data['subject'],
            'class_level' => $data['class_level'],
            'source_type' => $sourceType,
            'video_url'   => $rawUrl,
            'youtube_url' => $rawUrl,
            'duration'    => $data['duration'],
            'description' => $data['description'] ?? $video->description,
        ]);

        return $video;
    }

    public function deleteVideo(EducationalVideo $video): void
    {
        $video->delete();
    }

    /* -------------------------------------------------------------
     * 4. KALENDER AKADEMIK & DOWNLOAD
     * ------------------------------------------------------------- */
    public function getKalenderEvents(): array
    {
        return [
            [
                'raw_date'    => '2026-09-25',
                'date'        => '25 September 2026',
                'day'         => '25',
                'month_year'  => 'Sep 2026',
                'title'       => 'Penilaian Tengah Semester (PTS) Ganjil',
                'type'        => 'Ujian',
                'badge_color' => '#dc2626',
                'desc'        => 'Pelaksanaan evaluasi pembelajaran tengah semester untuk seluruh jenjang kelas 1-6.'
            ],
            [
                'raw_date'    => '2026-10-05',
                'date'        => '05 Oktober 2026',
                'day'         => '05',
                'month_year'  => 'Okt 2026',
                'title'       => 'Rapat Pleno Dewan Guru & Evaluasi Kurikulum Merdeka',
                'type'        => 'Rapat Guru',
                'badge_color' => '#2563eb',
                'desc'        => 'Pembahasan perkembangan capaian pembelajaran dan persiapan projek P5 di ruang guru.'
            ],
            [
                'raw_date'    => '2026-10-15',
                'date'        => '15 Oktober 2026',
                'day'         => '15',
                'month_year'  => 'Okt 2026',
                'title'       => 'Pentas Seni & Gelar Karya P5 Siswa',
                'type'        => 'Kegiatan',
                'badge_color' => '#16a34a',
                'desc'        => 'Unjuk bakat dan pameran hasil karya siswa hasil pembelajaran tematik dan kearifan lokal.'
            ],
            [
                'raw_date'    => '2026-10-28',
                'date'        => '28 Oktober 2026',
                'day'         => '28',
                'month_year'  => 'Okt 2026',
                'title'       => 'Upacara Peringatan Hari Sumpah Pemuda',
                'type'        => 'Upacara',
                'badge_color' => '#d97706',
                'desc'        => 'Upacara bendera gabungan guru dan seluruh siswa di lapangan utama sekolah.'
            ],
            [
                'raw_date'    => '2026-11-10',
                'date'        => '10 November 2026',
                'day'         => '10',
                'month_year'  => 'Nov 2026',
                'title'       => 'Peringatan Hari Pahlawan Nasional',
                'type'        => 'Upacara',
                'badge_color' => '#d97706',
                'desc'        => 'Kegiatan literasi sejarah dan doa bersama mengenang jasa para pahlawan bangsa.'
            ],
            [
                'raw_date'    => '2026-12-07',
                'date'        => '07 Desember 2026',
                'day'         => '07',
                'month_year'  => 'Des 2026',
                'title'       => 'Penilaian Akhir Semester (PAS) Ganjil',
                'type'        => 'Ujian',
                'badge_color' => '#dc2626',
                'desc'        => 'Ujian semester ganjil serentak seluruh muatan mata pelajaran.'
            ],
        ];
    }

    public function downloadKaldik(string $schoolName)
    {
        $content = "=========================================================\n" .
                   "KALENDER PENDIDIKAN TAHUN AJARAN " . date('Y') . "/" . (date('Y') + 1) . "\n" .
                   $schoolName . "\n" .
                   "=========================================================\n\n" .
                   "SEMESTER GANJIL:\n" .
                   "1. 25 Sep " . date('Y') . " : Penilaian Tengah Semester (PTS) Ganjil\n" .
                   "2. 05 Okt " . date('Y') . " : Rapat Pleno Dewan Guru & Evaluasi P5\n" .
                   "3. 15 Okt " . date('Y') . " : Pentas Seni & Gelar Karya Pelajar Pancasila\n" .
                   "4. 28 Okt " . date('Y') . " : Upacara Hari Sumpah Pemuda\n" .
                   "5. 10 Nov " . date('Y') . " : Hari Pahlawan Nasional\n" .
                   "6. 07 Des " . date('Y') . " : Penilaian Akhir Semester (PAS) Ganjil\n" .
                   "7. 18 Des " . date('Y') . " : Pembagian Buku Rapor Semester Ganjil\n" .
                   "8. 21 Des - 02 Jan : Libur Semester Ganjil\n\n" .
                   "Dicetak dari Portal Guru " . $schoolName . " pada " . date('d F Y, H:i') . " WIT.\n";

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="Kalender_Pendidikan_' . date('Y') . '_' . (date('Y') + 1) . '.txt"');
    }

    /* -------------------------------------------------------------
     * 5. PENGUMUMAN GURU
     * ------------------------------------------------------------- */
    public function getPengumuman(int $perPage = 10)
    {
        return Announcement::active()->latest('published_at')->paginate($perPage);
    }
}
