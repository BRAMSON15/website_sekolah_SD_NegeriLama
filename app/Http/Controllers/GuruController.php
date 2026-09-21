<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LearningMaterial;
use App\Models\EducationalVideo;
use App\Models\Assignment;
use App\Services\GuruService;
use App\Services\WebsiteContentService;

class GuruController extends Controller
{
    public function __construct(
        protected GuruService $guruService,
        protected WebsiteContentService $websiteService
    ) {}

    /* -------------------------------------------------------------
     * 1. DASHBOARD GURU
     * ------------------------------------------------------------- */
    public function dashboard()
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $dashboardData = $this->guruService->getDashboardData($user);

        return view('guru.dashboard', array_merge(['settings' => $settings, 'user' => $user], $dashboardData));
    }

    /* -------------------------------------------------------------
     * 2. KELAS SAYA & PRESENSI SISWA
     * ------------------------------------------------------------- */
    public function kelas(Request $request)
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $kelasData = $this->guruService->getKelasData($request, $user);

        return view('guru.kelas', array_merge(['settings' => $settings, 'user' => $user], $kelasData));
    }

    public function simpanPresensi(Request $request)
    {
        $request->validate([
            'class_name' => ['required', 'string'],
            'date'       => ['required', 'date'],
            'attendance' => ['required', 'array'],
        ]);

        $this->guruService->saveAttendance(Auth::user(), $request->date, $request->attendance);

        return redirect()->route('guru.kelas', ['class' => $request->class_name, 'date' => $request->date])
            ->with('success', 'Presensi ' . $request->class_name . ' tanggal ' . date('d/m/Y', strtotime($request->date)) . ' berhasil disimpan!');
    }

    /* -------------------------------------------------------------
     * 3. MATERI PEMBELAJARAN
     * ------------------------------------------------------------- */
    public function materi(Request $request)
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $materials = $this->guruService->getMaterials($request);

        return view('guru.materi', compact('settings', 'user', 'materials'));
    }

    public function storeMateri(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'subject'     => ['required', 'string', 'max:100'],
            'class_level' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
            'file_type'   => ['nullable', 'string', 'max:50'],
            'materi_file' => ['nullable', 'file', 'max:10240'],
        ]);

        $this->guruService->storeMaterial($validated, $request->file('materi_file'), Auth::id());

        return redirect()->route('guru.materi')->with('success', 'Materi pembelajaran berhasil diunggah!');
    }

    public function downloadMateri(LearningMaterial $material)
    {
        return $this->guruService->downloadMaterial($material);
    }

    public function destroyMateri(LearningMaterial $material)
    {
        $this->guruService->deleteMaterial($material);

        return redirect()->route('guru.materi')->with('success', 'Materi pembelajaran berhasil dihapus.');
    }

    /* -------------------------------------------------------------
     * 4. VIDEO EDUKASI
     * ------------------------------------------------------------- */
    public function video(Request $request)
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $videoData = $this->guruService->getVideoGallery($request);

        return view('guru.video', array_merge(['settings' => $settings, 'user' => $user], $videoData));
    }

    public function storeVideo(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'subject'     => ['required', 'string', 'max:100'],
            'class_level' => ['required', 'string', 'max:50'],
            'youtube_url' => ['required', 'url'],
            'duration'    => ['required', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $video = $this->guruService->storeVideo($validated, Auth::id());

        return redirect()->route('guru.video', ['play' => $video->id])->with('success', 'Video edukasi berhasil ditambahkan!');
    }

    public function destroyVideo(EducationalVideo $video)
    {
        $this->guruService->deleteVideo($video);

        return redirect()->route('guru.video')->with('success', 'Video edukasi berhasil dihapus.');
    }

    /* -------------------------------------------------------------
     * 5. TUGAS & PENILAIAN
     * ------------------------------------------------------------- */
    public function tugas()
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $overview = $this->guruService->getTugasOverview();

        return view('guru.tugas', array_merge(['settings' => $settings, 'user' => $user], $overview));
    }

    public function storeTugas(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'subject'     => ['required', 'string', 'max:100'],
            'class_level' => ['required', 'string', 'max:50'],
            'deadline'    => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
        ]);

        $assignment = $this->guruService->storeTugas($validated, Auth::id());

        return redirect()->route('guru.tugas.detail', $assignment)
            ->with('success', 'Tugas baru berhasil dibuat! Anda dapat menginput nilai pengumpulan siswa di bawah ini.');
    }

    public function detailTugas(Assignment $assignment)
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $detail = $this->guruService->getTugasDetail($assignment);

        return view('guru.tugas-detail', array_merge(['settings' => $settings, 'user' => $user, 'assignment' => $assignment], $detail));
    }

    public function simpanNilai(Request $request, Assignment $assignment)
    {
        $request->validate([
            'grades' => ['required', 'array'],
        ]);

        $this->guruService->saveGrades($assignment, $request->input('grades', []), $request->input('feedbacks', []));

        return redirect()->route('guru.tugas.detail', $assignment)->with('success', 'Nilai tugas siswa berhasil disimpan!');
    }

    public function destroyTugas(Assignment $assignment)
    {
        $this->guruService->deleteTugas($assignment);

        return redirect()->route('guru.tugas')->with('success', 'Tugas berhasil dihapus.');
    }

    /* -------------------------------------------------------------
     * 6. KALENDER AKADEMIK & DOWNLOAD
     * ------------------------------------------------------------- */
    public function kalender()
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $events = $this->guruService->getKalenderEvents();

        return view('guru.kalender', compact('settings', 'user', 'events'));
    }

    public function downloadKaldik()
    {
        $settings = $this->websiteService->getSettings();
        return $this->guruService->downloadKaldik($settings['school_name'] ?? 'SD NEGERI LAMA');
    }

    /* -------------------------------------------------------------
     * 7. PENGUMUMAN GURU
     * ------------------------------------------------------------- */
    public function pengumuman()
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $announcements = $this->guruService->getPengumuman(10);

        return view('guru.pengumuman', compact('settings', 'user', 'announcements'));
    }
}
