<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\KepalaSekolahService;
use App\Services\WebsiteContentService;

class KepalaSekolahController extends Controller
{
    public function __construct(
        protected KepalaSekolahService $kepalaSekolahService,
        protected WebsiteContentService $websiteService
    ) {}

    /**
     * Dashboard Utama Monitoring Kepala Sekolah (Ringkasan Eksekutif)
     */
    public function dashboard()
    {
        $settings = $this->websiteService->getSettings();
        $user = Auth::user();
        $dashboardData = $this->kepalaSekolahService->getDashboardData($user);

        return view('kepsek.dashboard', array_merge(['settings' => $settings], $dashboardData));
    }

    /**
     * Monitoring Data Guru & Keaktifan Pengajaran
     */
    public function monitoringGuru(Request $request)
    {
        $settings = $this->websiteService->getSettings();
        $guruData = $this->kepalaSekolahService->getMonitoringGuruData($request);

        return view('kepsek.guru', array_merge(['settings' => $settings], $guruData));
    }

    /**
     * Monitoring Media Pembelajaran (Video & Modul Materi)
     */
    public function monitoringPembelajaran(Request $request)
    {
        $settings = $this->websiteService->getSettings();
        $pembelajaranData = $this->kepalaSekolahService->getMonitoringPembelajaranData($request);

        return view('kepsek.pembelajaran', array_merge(['settings' => $settings], $pembelajaranData));
    }

    /**
     * Monitoring PPDB Online (Penerimaan Peserta Didik Baru)
     */
    public function monitoringPpdb(Request $request)
    {
        $settings = $this->websiteService->getSettings();
        $ppdbData = $this->kepalaSekolahService->getMonitoringPpdbData($request);

        if (!empty($ppdbData['isPrint'])) {
            return view('kepsek.ppdb-print', array_merge(['settings' => $settings], $ppdbData));
        }

        return view('kepsek.ppdb', array_merge(['settings' => $settings], $ppdbData));
    }

    /**
     * Monitoring Status Sistem & Informasi Sekolah
     */
    public function monitoringSistem()
    {
        $settings = $this->websiteService->getSettings();
        $sistemData = $this->kepalaSekolahService->getMonitoringSistemData();

        return view('kepsek.sistem', array_merge(['settings' => $settings], $sistemData));
    }
}
