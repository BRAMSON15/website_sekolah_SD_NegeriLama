<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\EducationalVideo;
use App\Models\LearningMaterial;
use App\Models\Student;
use App\Services\GuruService;
use App\Services\WebsiteContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
     * 3. MATERI PEMBELAJARAN
     * ------------------------------------------------------------- */
    public function materi(Request $request)
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $materials = $this->guruService->getMaterials($request);
       $classOptions = $this->guruService->getClassOptions($user->id);

        return view('guru.materi', compact('settings', 'user', 'materials', 'classOptions'));
    }

    public function storeMateri(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'subject' => ['required', 'string', 'max:100'],
            'class_level' => ['required', 'string', 'max:100', Rule::in($this->guruService->getClassOptions()->push('Semua Kelas')->all())],
            'description' => ['nullable', 'string', 'max:500'],
            'file_type' => ['nullable', 'string', 'max:50'],
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

    public function kelas()
    {
        $this->ensureGuru();
        $settings = $this->websiteService->getSettings();
        $classrooms = Classroom::where('teacher_id', Auth::id())
            ->withCount('students')
            ->orderBy('name')
            ->get();

        return view('guru.kelas.index', compact('settings', 'classrooms'));
    }

    public function createKelas()
    {
        $this->ensureGuru();

        return view('guru.kelas.form', [
            'settings' => $this->websiteService->getSettings(),
            'classroom' => new Classroom,
        ]);
    }

    public function storeKelas(Request $request)
    {
        $this->ensureGuru();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:classrooms,name'],
            'room' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);
        $data['teacher_id'] = Auth::id();
        Classroom::create($data);

        return redirect()->route('guru.kelas.index')->with('success', 'Kelas berhasil dibuat.');
    }

    public function editKelas(Classroom $classroom)
    {
        $this->ensureClassOwner($classroom);

        return view('guru.kelas.form', [
            'settings' => $this->websiteService->getSettings(),
            'classroom' => $classroom,
        ]);
    }

    public function updateKelas(Request $request, Classroom $classroom)
    {
        $this->ensureClassOwner($classroom);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:classrooms,name,'.$classroom->id],
            'room' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);
        $oldName = $classroom->name;

        DB::transaction(function () use ($classroom, $data, $oldName): void {
            $classroom->update($data);
            if ($oldName !== $data['name']) {
                Student::where('class_name', $oldName)->update(['class_name' => $data['name']]);
                LearningMaterial::where('class_level', $oldName)->update(['class_level' => $data['name']]);
                EducationalVideo::where('class_level', $oldName)->update(['class_level' => $data['name']]);
                Assignment::where('class_level', $oldName)->update(['class_level' => $data['name']]);
            }
        });

        return redirect()->route('guru.kelas.index')->with('success', 'Informasi kelas berhasil diperbarui.');
    }

    public function destroyKelas(Classroom $classroom)
    {
        $this->ensureClassOwner($classroom);
        if ($classroom->students()->exists()) {
            return back()->with('error', 'Kelas belum dapat dihapus karena masih memiliki siswa.');
        }

        $classroom->delete();

        return redirect()->route('guru.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }

    /* -------------------------------------------------------------
     * 4. VIDEO EDUKASI
     * ------------------------------------------------------------- */
    public function video(Request $request)
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $videoData = $this->guruService->getVideoGallery($request);
        $videoData['classOptions'] = $this->guruService->getClassOptions(Auth::id());

        return view('guru.video', array_merge(['settings' => $settings, 'user' => $user], $videoData));
    }

    public function storeVideo(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'subject' => ['required', 'string', 'max:100'],
            'class_level' => ['required', 'string', 'max:100', Rule::in($this->guruService->getClassOptions()->push('Semua Kelas')->all())],
            'source_type' => ['nullable', 'string', 'in:auto,youtube,google_drive'],
            'video_url' => ['required', 'string', 'max:1000'],
            'duration' => ['required', 'string', 'max:30'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $video = $this->guruService->storeVideo($validated, Auth::id());
        $sourceLabel = $video->is_drive ? 'Google Drive' : 'YouTube';

        return redirect()->route('guru.video', ['play' => $video->id])
            ->with('success', "Video edukasi ({$sourceLabel}) berhasil ditambahkan ke koleksi pembelajaran!");
    }

    public function updateVideo(Request $request, EducationalVideo $video)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'subject' => ['required', 'string', 'max:100'],
            'class_level' => ['required', 'string', 'max:100', Rule::in($this->guruService->getClassOptions()->push('Semua Kelas')->all())],
            'source_type' => ['nullable', 'string', 'in:auto,youtube,google_drive'],
            'video_url' => ['required', 'string', 'max:1000'],
            'duration' => ['required', 'string', 'max:30'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $this->guruService->updateVideo($video, $validated);
        $sourceLabel = $video->is_drive ? 'Google Drive' : 'YouTube';

        return redirect()->route('guru.video', ['play' => $video->id])
            ->with('success', "Video edukasi ({$sourceLabel}) '{$video->title}' berhasil diperbarui!");
    }

    public function destroyVideo(EducationalVideo $video)
    {
        $title = $video->title;
        $this->guruService->deleteVideo($video);

        return redirect()->route('guru.video')->with('success', "Video edukasi '{$title}' berhasil dihapus.");
    }

    /* -------------------------------------------------------------
     * 4. PENGUMUMAN GURU
     * ------------------------------------------------------------- */
    public function pengumuman()
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $announcements = $this->guruService->getPengumuman(10);

        return view('guru.pengumuman', compact('settings', 'user', 'announcements'));
    }

    private function ensureGuru(): void
    {
        abort_unless(Auth::user()?->role === 'guru', 403);
    }

    private function ensureClassOwner(Classroom $classroom): void
    {
        $this->ensureGuru();
        abort_unless($classroom->teacher_id === Auth::id(), 404);
    }
}
