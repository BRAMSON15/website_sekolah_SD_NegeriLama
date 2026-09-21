<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WebsiteContentService;
use App\Models\PpdbRegistration;

class AdminWebsiteController extends Controller
{
    public function __construct(
        protected WebsiteContentService $websiteService
    ) {}

    /* -------------------------------------------------------------
     * 1. PROFIL SEKOLAH (Visi, Misi, Sambutan, Sejarah)
     * ------------------------------------------------------------- */
    public function profil()
    {
        $settings = $this->websiteService->getSettings();
        return view('admin.website.profil', compact('settings'));
    }

    public function updateProfil(Request $request)
    {
        $validated = $request->validate([
            'school_name'        => ['required', 'string', 'max:150'],
            'school_tagline'     => ['nullable', 'string', 'max:255'],
            'school_vision'      => ['required', 'string'],
            'school_mission'     => ['required', 'string'],
            'school_history'     => ['nullable', 'string'],
            'principal_name'     => ['required', 'string', 'max:150'],
            'principal_title'    => ['required', 'string', 'max:150'],
            'principal_message'  => ['required', 'string'],
        ]);

        $this->websiteService->saveSettings($validated);

        return redirect()->route('admin.website.profil')->with('success', 'Konten Profil Sekolah, Visi & Misi berhasil disimpan.');
    }

    /* -------------------------------------------------------------
     * 2. AKADEMIK & KURIKULUM (Kurikulum & Ekstrakurikuler)
     * ------------------------------------------------------------- */
    public function akademik()
    {
        $settings = $this->websiteService->getSettings();
        return view('admin.website.akademik', compact('settings'));
    }

    public function updateAkademik(Request $request)
    {
        $validated = $request->validate([
            'curriculum_title'   => ['required', 'string', 'max:150'],
            'curriculum_desc'    => ['required', 'string'],
            'extracurriculars'   => ['required', 'string'],
        ]);

        $this->websiteService->saveSettings($validated);

        return redirect()->route('admin.website.akademik')->with('success', 'Konten Akademik & Ekstrakurikuler berhasil disimpan.');
    }

    /* -------------------------------------------------------------
     * 3. FASILITAS SEKOLAH
     * ------------------------------------------------------------- */
    public function fasilitas()
    {
        $settings = $this->websiteService->getSettings();
        $facilities = $this->websiteService->getFacilitiesData();

        return view('admin.website.fasilitas', compact('settings', 'facilities'));
    }

    public function updateFasilitas(Request $request)
    {
        $request->validate([
            'facilities' => ['required', 'array', 'min:1'],
            'facilities.*.title' => ['required', 'string', 'max:120'],
            'facilities.*.icon'  => ['required', 'string', 'max:60'],
            'facilities.*.desc'  => ['required', 'string', 'max:300'],
        ]);

        $this->websiteService->updateFacilities($request->facilities);

        return redirect()->route('admin.website.fasilitas')->with('success', 'Daftar Fasilitas Sekolah berhasil diperbarui.');
    }

    /* -------------------------------------------------------------
     * 4. PENGATURAN PPDB
     * ------------------------------------------------------------- */
    public function ppdb()
    {
        $settings = $this->websiteService->getSettings();
        $totalApplicants = PpdbRegistration::count();

        return view('admin.website.ppdb', compact('settings', 'totalApplicants'));
    }

    public function updatePpdb(Request $request)
    {
        $validated = $request->validate([
            'ppdb_status'        => ['required', 'in:open,closed'],
            'ppdb_batch_title'   => ['required', 'string', 'max:150'],
            'ppdb_batch_desc'    => ['required', 'string'],
            'ppdb_requirements'  => ['required', 'string'],
            'ppdb_step_1_title'  => ['required', 'string', 'max:100'],
            'ppdb_step_1_desc'   => ['required', 'string', 'max:255'],
            'ppdb_step_2_title'  => ['required', 'string', 'max:100'],
            'ppdb_step_2_desc'   => ['required', 'string', 'max:255'],
            'ppdb_step_3_title'  => ['required', 'string', 'max:100'],
            'ppdb_step_3_desc'   => ['required', 'string', 'max:255'],
            'ppdb_step_4_title'  => ['required', 'string', 'max:100'],
            'ppdb_step_4_desc'   => ['required', 'string', 'max:255'],
        ]);

        $this->websiteService->saveSettings($validated);

        return redirect()->route('admin.website.ppdb')->with('success', 'Pengaturan dan Informasi PPDB berhasil disimpan.');
    }

    /* -------------------------------------------------------------
     * 5. KONTAK & LOKASI SEKOLAH
     * ------------------------------------------------------------- */
    public function kontak()
    {
        $settings = $this->websiteService->getSettings();
        return view('admin.website.kontak', compact('settings'));
    }

    public function updateKontak(Request $request)
    {
        $validated = $request->validate([
            'address'     => ['required', 'string', 'max:255'],
            'phone'       => ['required', 'string', 'max:50'],
            'email'       => ['required', 'email', 'max:100'],
            'facebook'    => ['nullable', 'string', 'max:255'],
            'instagram'   => ['nullable', 'string', 'max:255'],
            'youtube'     => ['nullable', 'string', 'max:255'],
            'maps_embed'  => ['nullable', 'string'],
        ]);

        $this->websiteService->saveSettings($validated);

        return redirect()->route('admin.website.kontak')->with('success', 'Informasi Kontak dan Lokasi berhasil disimpan.');
    }
}
