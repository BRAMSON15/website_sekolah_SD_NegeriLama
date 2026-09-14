<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\SchoolSetting;
use App\Models\Feature;

class HomeController extends Controller
{
    private function getSettings()
    {
        return SchoolSetting::pluck('value', 'key')->toArray();
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

    public function akademik()
    {
        $settings = $this->getSettings();
        return view('pages.akademik', compact('settings'));
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
