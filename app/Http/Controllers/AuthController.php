<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\DashboardService;
use App\Services\WebsiteContentService;

class AuthController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService,
        protected WebsiteContentService $websiteService
    ) {}

    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        $settings = $this->websiteService->getSettings();
        return view('auth.login', compact('settings'));
    }

    public function login(Request $request)
    {
        $loginType = $request->input('login_type', 'admin');

        if ($loginType === 'guru') {
            $request->validate([
                'name' => ['required', 'string'],
                'nip'  => ['required', 'string'],
            ], [
                'name.required' => 'Nama lengkap guru wajib diisi.',
                'nip.required'  => 'NIP wajib diisi sebagai kata sandi.',
            ]);

            // Cari user guru berdasarkan nama (case-insensitive & whitespace trimmed)
            $nameInput = trim($request->name);
            $nipInput = trim($request->nip);

            $user = User::where('role', 'guru')
                ->whereRaw('LOWER(name) = ?', [strtolower($nameInput)])
                ->first();

            if (! $user) {
                // Alternatif search jika user hanya mengetik sebagian nama
                $user = User::where('role', 'guru')
                    ->where('name', 'LIKE', '%' . $nameInput . '%')
                    ->first();
            }

            if ($user && ($user->nip === $nipInput || Hash::check($nipInput, $user->password))) {
                Auth::login($user, $request->has('remember'));
                $request->session()->regenerate();

                return redirect()->intended(route('guru.dashboard'))
                    ->with('success', 'Selamat datang, ' . $user->name . '!');
            }

            return back()->withErrors([
                'name' => 'Nama Guru atau NIP yang Anda masukkan tidak terdaftar/tidak sesuai.',
            ])->withInput();
        } else {
            $credentials = $request->validate([
                'email'    => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials, $request->has('remember'))) {
                $request->session()->regenerate();

                return $this->redirectBasedOnRole();
            }

            return back()->withErrors([
                'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
            ])->withInput();
        }
    }

    private function redirectBasedOnRole()
    {
        $user = Auth::user();
        if ($user->role === 'guru') {
            return redirect()->intended(route('guru.dashboard'))
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
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
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();

        if ($user->role === 'guru') {
            return redirect()->route('guru.dashboard');
        }

        $dashboardData = $this->dashboardService->getAdminDashboardData();
        $stats = $dashboardData['stats'];
        $recentAnnouncements = $dashboardData['recentAnnouncements'];

        return view('dashboard.index', compact('settings', 'user', 'stats', 'recentAnnouncements'));
    }

    public function information()
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $hubData = $this->dashboardService->getInformationHubData();

        return view('information.index', array_merge([
            'settings' => $settings,
            'user'     => $user,
        ], $hubData));
    }

    public function guruDashboard()
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();

        return view('guru.dashboard', compact('settings', 'user'));
    }
}
