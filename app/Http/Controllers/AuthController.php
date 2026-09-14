<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use App\Models\Feature;
use App\Models\SchoolSetting;

class AuthController extends Controller
{
    private function getSettings()
    {
        return SchoolSetting::pluck('value', 'key')->toArray();
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $settings = $this->getSettings();
        return view('auth.login', compact('settings'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    public function dashboard()
    {
        $settings = $this->getSettings();
        $user = Auth::user();
        $stats = [
            'announcements' => Announcement::count(),
            'activeAnnouncements' => Announcement::where('is_active', true)->count(),
            'features' => Feature::count(),
            'settings' => SchoolSetting::count(),
        ];
        $recentAnnouncements = Announcement::latest('published_at')->take(5)->get();

        return view('dashboard.index', compact('settings', 'user', 'stats', 'recentAnnouncements'));
    }

    public function information()
    {
        $settings = $this->getSettings();
        $user = Auth::user();
        $announcementCount = Announcement::count();
        $featureCount = Feature::count();
        $announcements = Announcement::latest('published_at')->take(5)->get();
        $features = Feature::orderBy('order')->take(6)->get();

        return view('information.index', compact('settings', 'user', 'announcements', 'features', 'announcementCount', 'featureCount'));
    }
}
