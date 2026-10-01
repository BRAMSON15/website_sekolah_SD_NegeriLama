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
     * 4. PENGUMUMAN GURU
     * ------------------------------------------------------------- */
    public function getPengumuman(int $perPage = 10)
    {
        return Announcement::active()->latest('published_at')->paginate($perPage);
    }
}
