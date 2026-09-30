<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Feature;
use App\Models\EducationalVideo;
use App\Models\LearningMaterial;
use App\Services\WebsiteContentService;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct(
        protected WebsiteContentService $websiteService
    ) {}

    private function getSettings()
    {
        return $this->websiteService->getSettings();
    }

    public function index()
    {
        $settings = $this->getSettings();
        $announcements = Announcement::active()->take(5)->get();
        $features = Feature::orderBy('order', 'asc')->get();

        return view('welcome', compact('settings', 'announcements', 'features'));
    }

    public function profil()
    {
        $settings = $this->getSettings();
        return view('pages.profil', compact('settings'));
    }

    public function akademik(Request $request)
    {
        $settings = $this->getSettings();

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

        // Total Counts for Tabs (respecting active class and search filters)
        $totalVideoCount = EducationalVideo::query()
            ->when($classLevel && $classLevel !== 'Semua Kelas', fn($q) => $q->where('class_level', $classLevel))
            ->when($search, fn($q) => $q->where(fn($sub) => $sub->where('title', 'like', "%{$search}%")->orWhere('subject', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%")))
            ->count();

        $totalMaterialCount = LearningMaterial::query()
            ->when($classLevel && $classLevel !== 'Semua Kelas', fn($q) => $q->where('class_level', $classLevel))
            ->when($search, fn($q) => $q->where(fn($sub) => $sub->where('title', 'like', "%{$search}%")->orWhere('subject', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%")))
            ->count();

        $totalCombinedCount = $totalVideoCount + $totalMaterialCount;

        $availableClasses = ['Semua Kelas', 'Kelas 4A', 'Kelas 5A', 'Kelas 6B'];

        return view('pages.akademik', compact(
            'settings',
            'videos',
            'materials',
            'tab',
            'classLevel',
            'search',
            'totalVideoCount',
            'totalMaterialCount',
            'totalCombinedCount',
            'availableClasses'
        ));
    }

    public function downloadMateri(LearningMaterial $material)
    {
        $material->increment('downloads');

        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            return Storage::disk('public')->download($material->file_path);
        }

        return response($material->title . "\n\nMateri Pembelajaran " . $material->subject . "\n" . $material->class_level . "\n\n" . $material->description)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . str()->slug($material->title) . '.txt"');
    }

    public function fasilitas()
    {
        $settings = $this->getSettings();
        return view('pages.fasilitas', compact('settings'));
    }

    public function ppdb()
    {
        $settings = $this->getSettings();
        return view('pages.ppdb', compact('settings'));
    }

    public function pengumuman()
    {
        $settings = $this->getSettings();
        $announcements = Announcement::active()->paginate(10);
        return view('pages.pengumuman', compact('settings', 'announcements'));
    }

    public function detailPengumuman($slug)
    {
        $settings = $this->getSettings();
        $announcement = Announcement::where('slug', $slug)->firstOrFail();
        $recentAnnouncements = Announcement::active()->where('id', '!=', $announcement->id)->take(5)->get();
        return view('pages.detail-pengumuman', compact('settings', 'announcement', 'recentAnnouncements'));
    }

    public function kontak()
    {
        $settings = $this->getSettings();
        return view('pages.kontak', compact('settings'));
    }
}
