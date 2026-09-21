<?php

namespace App\Http\Controllers;

use App\Models\PpdbRegistration;
use App\Services\PpdbService;
use App\Services\WebsiteContentService;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    public function __construct(
        protected PpdbService $ppdbService,
        protected WebsiteContentService $websiteService
    ) {}

    public function create()
    {
        $settings = $this->websiteService->getSettings();

        return view('pages.ppdb-register', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name'    => ['required', 'string', 'max:150'],
            'birth_place'     => ['required', 'string', 'max:100'],
            'birth_date'      => ['required', 'date', 'before_or_equal:' . now()->subYears(5)->format('Y-m-d')],
            'gender'          => ['required', 'in:L,P'],
            'nik'             => ['nullable', 'digits:16'],
            'kk_number'       => ['nullable', 'digits:16'],
            'parent_name'     => ['required', 'string', 'max:150'],
            'phone'           => ['required', 'string', 'max:25'],
            'email'           => ['nullable', 'email', 'max:150'],
            'address'         => ['required', 'string', 'max:1000'],
            'previous_school' => ['nullable', 'string', 'max:150'],
        ], [
            'birth_date.before_or_equal' => 'Usia calon peserta didik minimal 5 tahun.',
            '*.required'                 => 'Kolom ini wajib diisi.',
            '*.digits'                   => 'Kolom ini harus berisi :digits angka.',
        ]);

        $registration = $this->ppdbService->register($validated);

        return redirect()->route('ppdb.success', $registration)
            ->with('success', 'Pendaftaran PPDB berhasil dikirim.');
    }

    public function success(PpdbRegistration $registration)
    {
        $settings = $this->websiteService->getSettings();

        return view('pages.ppdb-success', compact('settings', 'registration'));
    }

    public function index()
    {
        $settings = $this->websiteService->getSettings();
        $registrations = PpdbRegistration::latest()->paginate(15);

        return view('admin.ppdb.index', compact('settings', 'registrations'));
    }

    public function exportPdf()
    {
        $settings = $this->websiteService->getSettings();
        $export = $this->ppdbService->generatePdfExport($settings);

        return response($export['content'])
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $export['filename'] . '"');
    }

    public function exportExcel()
    {
        $settings = $this->websiteService->getSettings();
        $export = $this->ppdbService->generateExcelExport($settings);

        return response($export['content'])
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $export['filename'] . '"')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
