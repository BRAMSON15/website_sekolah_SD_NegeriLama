<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\LearningMaterial;
use App\Models\EducationalVideo;
use App\Models\Assignment;
use App\Models\AssignmentGrade;
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
            'classes'     => Student::select('class_name')->distinct()->count() ?: 3,
            'materials'   => LearningMaterial::count(),
            'videos'      => EducationalVideo::count(),
            'assignments' => Assignment::count(),
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
     * 2. KELAS SAYA & PRESENSI SISWA
     * ------------------------------------------------------------- */
    public function getKelasData(Request $request, $user): array
    {
        $availableClasses = Student::select('class_name')->distinct()->pluck('class_name')->toArray();
        if (empty($availableClasses)) {
            $availableClasses = ['Kelas 4A', 'Kelas 5A', 'Kelas 6B'];
        }

        $selectedClass = $request->get('class', $availableClasses[1] ?? $availableClasses[0]);
        $date = $request->get('date', date('Y-m-d'));

        $students = Student::where('class_name', $selectedClass)->orderBy('name', 'asc')->get();

        $attendances = Attendance::whereIn('student_id', $students->pluck('id'))
            ->where('date', $date)
            ->pluck('status', 'student_id')
            ->toArray();

        $totalStudents = Student::count();
        $totalInSelectedClass = $students->count();

        $hadirCount = 0;
        foreach ($attendances as $status) {
            if ($status === 'Hadir') {
                $hadirCount++;
            }
        }
        $presentPercentage = $totalInSelectedClass > 0 ? round(($hadirCount / $totalInSelectedClass) * 100, 1) : 100;

        $classes = [
            [
                'id'             => 1,
                'name'           => 'Kelas 4A',
                'badge'          => 'IV',
                'badge_color'    => 'cyan',
                'students_count' => Student::where('class_name', 'Kelas 4A')->count() ?: 8,
                'homeroom'       => 'Siti Rahma, S.Pd',
                'schedule'       => 'Senin & Rabu (08:00 - 09:30)',
                'room'           => 'Ruang 102 (Lantai 1)',
            ],
            [
                'id'             => 2,
                'name'           => 'Kelas 5A',
                'badge'          => 'V',
                'badge_color'    => 'purple',
                'students_count' => Student::where('class_name', 'Kelas 5A')->count() ?: 10,
                'homeroom'       => $user->name,
                'schedule'       => 'Selasa & Kamis (09:45 - 11:15)',
                'room'           => 'Ruang 201 (Lantai 2)',
            ],
            [
                'id'             => 3,
                'name'           => 'Kelas 6B',
                'badge'          => 'VI',
                'badge_color'    => 'orange',
                'students_count' => Student::where('class_name', 'Kelas 6B')->count() ?: 8,
                'homeroom'       => 'Ahmad Syahrir, S.Pd',
                'schedule'       => 'Jumat (08:00 - 10:00)',
                'room'           => 'Ruang 303 (Lantai 3)',
            ],
        ];

        return compact(
            'classes', 'availableClasses', 'selectedClass',
            'students', 'date', 'attendances', 'totalStudents', 'presentPercentage'
        );
    }

    public function saveAttendance($user, string $date, array $attendanceData): void
    {
        foreach ($attendanceData as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date'       => $date,
                ],
                [
                    'user_id' => $user->id,
                    'status'  => in_array($status, ['Hadir', 'Sakit', 'Izin', 'Alpa']) ? $status : 'Hadir',
                ]
            );
        }
    }

    /* -------------------------------------------------------------
     * 3. MATERI PEMBELAJARAN
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
     * 4. VIDEO EDUKASI
     * ------------------------------------------------------------- */
    public function getVideoGallery(Request $request): array
    {
        $videos = EducationalVideo::latest()->get();
        $activeVideoId = $request->get('play');
        $activeVideo = $videos->firstWhere('id', $activeVideoId) ?: $videos->first();

        if ($activeVideo) {
            $activeVideo->increment('views_count');
        }

        return compact('videos', 'activeVideo');
    }

    public function storeVideo(array $data, int $userId): EducationalVideo
    {
        return EducationalVideo::create([
            'user_id'     => $userId,
            'title'       => $data['title'],
            'subject'     => $data['subject'],
            'class_level' => $data['class_level'],
            'youtube_url' => $data['youtube_url'],
            'duration'    => $data['duration'],
            'description' => $data['description'] ?? 'Video edukasi pembelajaran interaktif.',
            'views_count' => 0,
        ]);
    }

    public function deleteVideo(EducationalVideo $video): void
    {
        $video->delete();
    }

    /* -------------------------------------------------------------
     * 5. TUGAS & PENILAIAN
     * ------------------------------------------------------------- */
    public function getTugasOverview(): array
    {
        $assignments = Assignment::withCount('grades')->latest()->get();

        $activeCount = $assignments->where('status', 'Aktif')->count();
        $completedCount = $assignments->where('status', '!=', 'Aktif')->count();
        $totalSubmissions = AssignmentGrade::count();

        return compact('assignments', 'activeCount', 'completedCount', 'totalSubmissions');
    }

    public function storeTugas(array $data, int $userId): Assignment
    {
        $classStudentsCount = Student::where('class_name', $data['class_level'])->count() ?: 10;

        return Assignment::create([
            'user_id'         => $userId,
            'title'           => $data['title'],
            'subject'         => $data['subject'],
            'class_level'     => $data['class_level'],
            'deadline'        => $data['deadline'],
            'description'     => $data['description'],
            'total_students'  => $classStudentsCount,
            'submitted_count' => 0,
            'status'          => 'Aktif',
        ]);
    }

    public function getTugasDetail(Assignment $assignment): array
    {
        $students = Student::where('class_name', $assignment->class_level)->orderBy('name', 'asc')->get();
        if ($students->isEmpty()) {
            $students = Student::take(10)->get();
        }

        $grades = AssignmentGrade::where('assignment_id', $assignment->id)
            ->get()
            ->keyBy('student_id');

        return compact('students', 'grades');
    }

    public function saveGrades(Assignment $assignment, array $grades, array $feedbacks): void
    {
        $submittedCount = 0;

        foreach ($grades as $studentId => $score) {
            if ($score !== null && $score !== '') {
                $submittedCount++;
                AssignmentGrade::updateOrCreate(
                    [
                        'assignment_id' => $assignment->id,
                        'student_id'    => $studentId,
                    ],
                    [
                        'grade'    => (int) $score,
                        'feedback' => $feedbacks[$studentId] ?? null,
                        'status'   => 'Dinilai',
                    ]
                );
            }
        }

        $assignment->update([
            'submitted_count' => $submittedCount,
            'status'          => ($submittedCount >= $assignment->total_students) ? 'Selesai Dinilai' : 'Aktif',
        ]);
    }

    public function deleteTugas(Assignment $assignment): void
    {
        $assignment->delete();
    }

    /* -------------------------------------------------------------
     * 6. KALENDER AKADEMIK & DOWNLOAD
     * ------------------------------------------------------------- */
    public function getKalenderEvents(): array
    {
        return [
            [
                'date'        => '25 September 2026',
                'title'       => 'Penilaian Tengah Semester (PTS) Ganjil',
                'type'        => 'Ujian',
                'badge_color' => '#dc2626',
                'desc'        => 'Pelaksanaan evaluasi pembelajaran tengah semester untuk seluruh jenjang kelas 1-6.'
            ],
            [
                'date'        => '05 Oktober 2026',
                'title'       => 'Rapat Pleno Dewan Guru & Evaluasi Kurikulum Merdeka',
                'type'        => 'Rapat Guru',
                'badge_color' => '#2563eb',
                'desc'        => 'Pembahasan perkembangan capaian pembelajaran dan persiapan projek P5 di ruang guru.'
            ],
            [
                'date'        => '15 Oktober 2026',
                'title'       => 'Pentas Seni & Gelar Karya P5 Siswa',
                'type'        => 'Kegiatan',
                'badge_color' => '#16a34a',
                'desc'        => 'Unjuk bakat dan pameran hasil karya siswa hasil pembelajaran tematik dan kearifan lokal.'
            ],
            [
                'date'        => '28 Oktober 2026',
                'title'       => 'Upacara Peringatan Hari Sumpah Pemuda',
                'type'        => 'Upacara',
                'badge_color' => '#d97706',
                'desc'        => 'Upacara bendera gabungan guru dan seluruh siswa di lapangan utama sekolah.'
            ],
            [
                'date'        => '10 November 2026',
                'title'       => 'Peringatan Hari Pahlawan Nasional',
                'type'        => 'Upacara',
                'badge_color' => '#d97706',
                'desc'        => 'Kegiatan literasi sejarah dan doa bersama mengenang jasa para pahlawan bangsa.'
            ],
            [
                'date'        => '07 Desember 2026',
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
     * 7. PENGUMUMAN GURU
     * ------------------------------------------------------------- */
    public function getPengumuman(int $perPage = 10)
    {
        return Announcement::active()->latest('published_at')->paginate($perPage);
    }
}
