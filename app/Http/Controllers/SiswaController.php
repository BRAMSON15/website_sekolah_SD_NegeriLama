<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LearningMaterial;
use App\Services\SiswaService;
use App\Services\WebsiteContentService;

class SiswaController extends Controller
{
    public function __construct(
        protected SiswaService $siswaService,
        protected WebsiteContentService $websiteService
    ) {}

    /**
     * Beranda khusus siswa terdaftar (Portal Pembelajaran Digital)
     */
    public function beranda(Request $request)
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $berandaData = $this->siswaService->getBerandaData($request, $user);

        return view('siswa.beranda', array_merge(['settings' => $settings], $berandaData));
    }

    /**
     * Download file materi pembelajaran khusus siswa
     */
    public function downloadMateri(LearningMaterial $material)
    {
        return $this->siswaService->downloadMaterial($material);
    }

    /**
     * Verifikasi & Akses Langsung Siswa dengan NISN Terdaftar
     */
    public function aksesNisn(Request $request)
    {
        $request->validate([
            'nisn' => ['required', 'string'],
        ], [
            'nisn.required' => 'Nomor NISN siswa wajib diisi.',
        ]);

        $nisn = trim($request->nisn);
        $student = $this->siswaService->authenticateByNisn($nisn, $request);

        if (! $student) {
            return back()->with('error_nisn', 'Nomor NISN "' . $nisn . '" tidak terdaftar sebagai siswa aktif SD Negeri Lama. Silakan periksa kembali.')
                ->withInput();
        }

        return redirect()->route('siswa.beranda')
            ->with('success', 'Verifikasi berhasil! Selamat datang di Ruang Belajar, ' . $student->name . ' (' . $student->class_name . ')!');
    }
}
