<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LearningMaterial;
use App\Models\EducationalVideo;
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
            'source_type' => ['nullable', 'string', 'in:auto,youtube,google_drive'],
            'video_url'   => ['required', 'string', 'max:1000'],
            'duration'    => ['required', 'string', 'max:30'],
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
            'title'       => ['required', 'string', 'max:200'],
            'subject'     => ['required', 'string', 'max:100'],
            'class_level' => ['required', 'string', 'max:50'],
            'source_type' => ['nullable', 'string', 'in:auto,youtube,google_drive'],
            'video_url'   => ['required', 'string', 'max:1000'],
            'duration'    => ['required', 'string', 'max:30'],
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
}
