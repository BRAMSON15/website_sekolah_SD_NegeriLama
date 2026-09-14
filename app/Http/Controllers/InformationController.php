<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InformationController extends Controller
{
    public function announcements()
    {
        $settings = $this->settings();
        $announcements = Announcement::latest('published_at')->paginate(10);

        return view('information.announcements.index', compact('settings', 'announcements'));
    }

    public function createAnnouncement()
    {
        return view('information.announcements.form', ['settings' => $this->settings(), 'announcement' => new Announcement()]);
    }

    public function storeAnnouncement(Request $request)
    {
        $data = $this->validateAnnouncement($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        Announcement::create($data);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function editAnnouncement(Announcement $announcement)
    {
        return view('information.announcements.form', compact('announcement') + ['settings' => $this->settings()]);
    }

    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        $data = $this->validateAnnouncement($request);
        $data['slug'] = $this->uniqueSlug($data['title'], $announcement->id);
        $announcement->update($data);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroyAnnouncement(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function features()
    {
        $settings = $this->settings();
        $features = Feature::orderBy('order')->orderBy('title')->paginate(10);

        return view('information.features.index', compact('settings', 'features'));
    }

    public function createFeature()
    {
        return view('information.features.form', ['settings' => $this->settings(), 'feature' => new Feature()]);
    }

    public function storeFeature(Request $request)
    {
        Feature::create($this->validateFeature($request));
        return redirect()->route('admin.fitur.index')->with('success', 'Fitur atau layanan berhasil ditambahkan.');
    }

    public function editFeature(Feature $feature)
    {
        return view('information.features.form', compact('feature') + ['settings' => $this->settings()]);
    }

    public function updateFeature(Request $request, Feature $feature)
    {
        $feature->update($this->validateFeature($request));
        return redirect()->route('admin.fitur.index')->with('success', 'Fitur atau layanan berhasil diperbarui.');
    }

    public function destroyFeature(Feature $feature)
    {
        $feature->delete();
        return back()->with('success', 'Fitur atau layanan berhasil dihapus.');
    }

    private function settings(): array
    {
        return \App\Models\SchoolSetting::pluck('value', 'key')->toArray();
    }

    private function validateAnnouncement(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'published_at' => ['required', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }

    private function validateFeature(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'icon' => ['required', 'string', 'max:100'],
            'icon_color_class' => ['required', 'string', 'max:100'],
            'order' => ['required', 'integer', 'min:0'],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'pengumuman';
        $slug = $base;
        $counter = 2;

        while (Announcement::where('slug', $slug)->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}
