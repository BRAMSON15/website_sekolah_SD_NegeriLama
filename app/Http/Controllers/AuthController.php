<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\DashboardService;
use App\Services\WebsiteContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected DashboardService $dashboardService,
        protected WebsiteContentService $websiteService
    ) {}

    public function showLoginForm(Request $request)
    {
        $role = $request->query('role', old('login_type', 'guru'));

        return $this->renderRoleLoginForm($role);
    }

    public function showGuruLoginForm()
    {
        return $this->renderRoleLoginForm('guru');
    }

    public function showAdminLoginForm()
    {
        return $this->renderRoleLoginForm('admin');
    }

    public function showKepsekLoginForm()
    {
        return $this->renderRoleLoginForm('kepsek');
    }

    protected function renderRoleLoginForm(string $role)
    {
        $settings = $this->websiteService->getSettings();
        $currentUser = Auth::user();

        if (in_array($role, ['kepala_sekolah', 'kepsek'])) {
            $role = 'kepsek';
        } elseif ($role === 'admin') {
            $role = 'admin';
        } else {
            $role = 'guru';
        }

        return view('auth.login', compact('settings', 'currentUser', 'role'));
    }

    public function login(Request $request)
    {
        $credentials = $this->validatedLoginCredentials($request);
        $result = $this->authService->authenticate(
            $credentials['type'],
            $credentials['identifier'],
            $credentials['password']
        );

        if (! $result) {
            return back()->withErrors([
                $credentials['error_key'] => $credentials['error_message'],
            ])->withInput();
        }

        if (Auth::check()) {
            Auth::logout();
        }

        Auth::login($result['user'], $request->has('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route($this->dashboardRoute($result['user']->role)))
            ->with('success', $this->loginSuccessMessage($credentials['type'], $result));
    }

    private function validatedLoginCredentials(Request $request): array
    {
        $loginType = $request->input('login_type', 'guru');

        if ($loginType === 'guru') {
            $data = $request->validate([
                'name' => ['required', 'string'],
                'nip' => ['required', 'string'],
            ], [
                'name.required' => 'Nama lengkap, NIP, atau Email guru wajib diisi.',
                'nip.required' => 'NIP atau kata sandi wajib diisi.',
            ]);

            return [
                'type' => 'guru',
                'identifier' => trim($data['name']),
                'password' => trim($data['nip']),
                'error_key' => 'name',
                'error_message' => 'Data Guru (Nama/NIP/Email) atau kata sandi yang Anda masukkan tidak sesuai.',
            ];
        }

        if ($loginType === 'siswa') {
            $data = $request->validate([
                'student_identifier' => ['required', 'string'],
                'student_password' => ['required', 'string'],
            ], [
                'student_identifier.required' => 'NISN atau Email Siswa wajib diisi.',
                'student_password.required' => 'Kata sandi wajib diisi.',
            ]);

            return [
                'type' => 'siswa',
                'identifier' => trim($data['student_identifier']),
                'password' => trim($data['student_password']),
                'error_key' => 'student_identifier',
                'error_message' => 'NISN/Email Siswa atau kata sandi tidak sesuai dengan data siswa terdaftar.',
            ];
        }

        if (in_array($loginType, ['kepala_sekolah', 'kepsek'])) {
            $data = $request->validate([
                'kepsek_identifier' => ['required', 'string'],
                'kepsek_password' => ['required', 'string'],
            ], [
                'kepsek_identifier.required' => 'NIP, Email, atau Nama Kepala Sekolah wajib diisi.',
                'kepsek_password.required' => 'Kata sandi wajib diisi.',
            ]);

            return [
                'type' => 'kepsek',
                'identifier' => trim($data['kepsek_identifier']),
                'password' => trim($data['kepsek_password']),
                'error_key' => 'kepsek_identifier',
                'error_message' => 'Data Kepala Sekolah (NIP/Email/Nama) atau kata sandi tidak sesuai.',
            ];
        }

        $data = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email atau Username Admin wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        return [
            'type' => 'admin',
            'identifier' => trim($data['email']),
            'password' => $data['password'],
            'error_key' => 'email',
            'error_message' => 'Email/Username Admin atau kata sandi yang Anda masukkan tidak sesuai.',
        ];
    }

    private function dashboardRoute(string $role): string
    {
        return match ($role) {
            'kepala_sekolah', 'kepsek' => 'kepsek.dashboard',
            'guru' => 'guru.dashboard',
            'siswa' => 'siswa.beranda',
            default => 'dashboard',
        };
    }

    private function loginSuccessMessage(string $loginType, array $result): string
    {
        $user = $result['user'];

        if ($result['used_fallback']) {
            return match ($user->role) {
                'kepala_sekolah', 'kepsek' => 'Selamat datang, Bapak/Ibu Kepala Sekolah '.$user->name.'!',
                'guru' => 'Selamat datang kembali, '.$user->name.'!',
                'siswa' => 'Selamat datang kembali di Ruang Belajar, '.$user->name.'!',
                default => 'Selamat datang kembali, '.$user->name.'!',
            };
        }

        return match ($loginType) {
            'guru' => 'Selamat datang, '.$user->name.'!',
            'siswa' => $result['student']
                ? 'Selamat datang di Ruang Belajar, '.$result['student']->name.' ('.$result['student']->class_name.')!'
                : 'Selamat datang di Ruang Belajar, '.$user->name.'!',
            'kepsek' => 'Selamat datang, Bapak/Ibu Kepala Sekolah '.$user->name.'!',
            default => 'Selamat datang kembali, '.$user->name.'!',
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari akun.');
    }

    public function dashboard()
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();

        if (in_array($user->role, ['kepala_sekolah', 'kepsek'])) {
            return redirect()->route('kepsek.dashboard');
        }

        if ($user->role === 'guru') {
            return redirect()->route('guru.dashboard');
        }

        if ($user->role === 'siswa') {
            return redirect()->route('siswa.beranda');
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
            'user' => $user,
        ], $hubData));
    }

    public function guruDashboard()
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();

        return view('guru.dashboard', compact('settings', 'user'));
    }
}
