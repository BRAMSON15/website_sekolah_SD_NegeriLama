<?php

namespace App\Http\Controllers;

use App\Models\PpdbRegistration;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;

class PpdbController extends Controller
{
    private function getSettings(): array
    {
        return SchoolSetting::pluck('value', 'key')->toArray();
    }

    public function create()
    {
        $settings = $this->getSettings();

        return view('pages.ppdb-register', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:150'],
            'birth_place' => ['required', 'string', 'max:100'],
            'birth_date' => ['required', 'date', 'before_or_equal:' . now()->subYears(5)->format('Y-m-d')],
            'gender' => ['required', 'in:L,P'],
            'nik' => ['nullable', 'digits:16'],
            'kk_number' => ['nullable', 'digits:16'],
            'parent_name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:25'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['required', 'string', 'max:1000'],
            'previous_school' => ['nullable', 'string', 'max:150'],
        ], [
            'birth_date.before_or_equal' => 'Usia calon peserta didik minimal 5 tahun.',
            '*.required' => 'Kolom ini wajib diisi.',
            '*.digits' => 'Kolom ini harus berisi :digits angka.',
        ]);

        $validated['registration_number'] = $this->generateRegistrationNumber();
        $validated['status'] = 'pending';

        $registration = PpdbRegistration::create($validated);

        return redirect()->route('ppdb.success', $registration)
            ->with('success', 'Pendaftaran PPDB berhasil dikirim.');
    }

    public function success(PpdbRegistration $registration)
    {
        $settings = $this->getSettings();

        return view('pages.ppdb-success', compact('settings', 'registration'));
    }

    public function index()
    {
        $settings = $this->getSettings();
        $registrations = PpdbRegistration::latest()->paginate(15);

        return view('admin.ppdb.index', compact('settings', 'registrations'));
    }

    public function exportPdf()
    {
        $settings = $this->getSettings();
        $registrations = PpdbRegistration::orderBy('created_at', 'asc')->get();

        $totalRegistrations = $registrations->count();
        $totalL = $registrations->where('gender', 'L')->count();
        $totalP = $registrations->where('gender', 'P')->count();
        $totalPending = $registrations->filter(fn($r) => in_array(strtolower($r->status), ['pending']))->count();
        $totalDiterima = $registrations->filter(fn($r) => in_array(strtolower($r->status), ['accepted', 'diterima']))->count();
        $totalDitolak = $registrations->filter(fn($r) => in_array(strtolower($r->status), ['rejected', 'ditolak']))->count();

        // Convert school logo to base64 for reliable Dompdf rendering
        $logoPath = public_path('mentahan2/img/Logo1.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        $html = view('admin.ppdb.pdf', compact(
            'settings',
            'registrations',
            'totalRegistrations',
            'totalL',
            'totalP',
            'totalPending',
            'totalDiterima',
            'totalDitolak',
            'logoBase64'
        ))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'Data_Pendaftar_PPDB_' . Str::slug($settings['school_name'] ?? 'SD_Negeri_Lama') . '_' . date('Y-m-d') . '.pdf';

        return response($dompdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function exportExcel()
    {
        $settings = $this->getSettings();
        $registrations = PpdbRegistration::orderBy('created_at', 'asc')->get();

        $html = view('admin.ppdb.excel', compact('settings', 'registrations'))->render();

        $filename = 'Data_Pendaftar_PPDB_' . Str::slug($settings['school_name'] ?? 'SD_Negeri_Lama') . '_' . date('Y-m-d') . '.xls';

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    private function generateRegistrationNumber(): string
    {
        do {
            $number = 'PPDB-' . now()->format('Y') . '-' . Str::upper(Str::random(6));
        } while (PpdbRegistration::where('registration_number', $number)->exists());

        return $number;
    }
}
