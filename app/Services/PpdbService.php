<?php

namespace App\Services;

use App\Models\PpdbRegistration;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;

class PpdbService
{
    /**
     * Generate unique registration number.
     */
    public function generateRegistrationNumber(): string
    {
        do {
            $number = 'PPDB-' . now()->format('Y') . '-' . Str::upper(Str::random(6));
        } while (PpdbRegistration::where('registration_number', $number)->exists());

        return $number;
    }

    /**
     * Register new student applicant.
     */
    public function register(array $data): PpdbRegistration
    {
        $data['registration_number'] = $this->generateRegistrationNumber();
        $data['status'] = 'pending';

        return PpdbRegistration::create($data);
    }

    /**
     * Generate PDF output for PPDB registrations.
     */
    public function generatePdfExport(array $settings): array
    {
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

        return [
            'content'  => $dompdf->output(),
            'filename' => $filename,
        ];
    }

    /**
     * Generate Excel export spreadsheet content for PPDB registrations.
     */
    public function generateExcelExport(array $settings): array
    {
        $registrations = PpdbRegistration::orderBy('created_at', 'asc')->get();
        $html = view('admin.ppdb.excel', compact('settings', 'registrations'))->render();
        $filename = 'Data_Pendaftar_PPDB_' . Str::slug($settings['school_name'] ?? 'SD_Negeri_Lama') . '_' . date('Y-m-d') . '.xls';

        return [
            'content'  => $html,
            'filename' => $filename,
        ];
    }
}
