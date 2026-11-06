<?php
Namespace App\Services;

use App\Models\Monitoring\PpdbActivity;
use App\Models\PpdbRegistration;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PpdbService
{
    protected PpdbMonitoringService $monitoringService;

    public function __construct(PpdbMonitoringService $monitoringService)
    {
        $this->monitoringService = $monitoringService;
    }

    /**
     * Get registered applicants with pagination
     */
    public function getRegistrations(int $perPage = 15): LengthAwarePaginator
    {
        return PpdbRegistration::latest()->paginate($perPage);
    }

    /**
     * Validate registration data with custom messages
     */
    public function validateRegistration(array $data): array
    {
        return validator($data, $this->getValidationRules(), $this->getValidationMessages())->validate();
    }

    /**
     * Get validation rules for registration
     */
    private function getValidationRules(): array
    {
        return [
            "student_name" => ["required", "string", "max:150"],
            "birth_place" => ["required", "string", "max:100"],
            "birth_date" => ["required", "date", "before_or_equal:".now()->subYears(5)->format("Y-m-d")],
            "gender" => ["required", "in:L,P"],
            "nik" => ["nullable", "digits:16"],
            "kk_number" => ["nullable", "digits:16"],
            "parent_name" => ["required", "string", "max:150"],
            "phone" => ["required", "string", "max:25"],
            "email" => ["nullable", "email", "max:150"],
            "address" => ["required", "string", "max:1000"],
            "previous_school" => ["nullable", "string", "max:150"],
            "supporting_file_kk" => ["required", "file", "mimes:pdf,jpg,jpeg,png", "max:5120"],
            "supporting_file_akte" => ["nullable", "file", "mimes:pdf,jpg,jpeg,png", "max:5120"],
            "supporting_file_rapor" => ["nullable", "file", "mimes:pdf,jpg,jpeg,png", "max:5120"],
        ];
    }

    /**
     * Get validation custom messages
     */
    private function getValidationMessages(): array
    {
        return [
            "birth_date.before_or_equal" => "Usia calon peserta didik minimal 5 tahun.",
            "*.required" => "Kolom ini wajib diisi.",
            "*.digits" => "Kolom ini harus berisi :digits angka.",
            "supporting_file_kk.required" => "Kartu Keluarga wajib diunggah.",
            "supporting_file_kk.mimes" => "File KK harus berformat PDF, JPG, atau PNG.",
            "supporting_file_kk.max" => "Ukuran file KK tidak boleh melebihi 5MB.",
            "supporting_file_akte.mimes" => "File Akte harus berformat PDF, JPG, atau PNG.",
            "supporting_file_akte.max" => "Ukuran file Akte tidak boleh melebihi 5MB.",
            "supporting_file_rapor.mimes" => "File Rapor harus berformat PDF, JPG, atau PNG.",
            "supporting_file_rapor.max" => "Ukuran file Rapor tidak boleh melebihi 5MB.",
        ];
    }

    /**
     * Handle supporting file uploads
     */
    public function handleSupportingFileUploads(Request $request): array
    {
        $fileFields = ['kk', 'akte', 'rapor'];
        $uploadedFiles = [];

        foreach ($fileFields as $field) {
            $fileKey = "supporting_file_{$field}";
            
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                
                if (!$file->isValid()) {
                    throw new \Exception("File {$field} tidak valid atau korup");
                }
                
                $uploadedFiles[$fileKey] = $file->store("ppdb/supporting-files", "public");
            }
        }

        return $uploadedFiles;
    }

    /**
     * Generate unique registration number
     */
    public function generateRegistrationNumber(): string
    {
        do {
            $number = 'PPDB-'.now()->format('Y').'-'.Str::upper(Str::random(6));
        } while (PpdbRegistration::where('registration_number', $number)->exists());

        return $number;
    }

    /**
     * Register new student applicant
     */
    public function register(array $data): PpdbRegistration
    {
        try {
            $data['registration_number'] = $this->generateRegistrationNumber();
            $data['status'] = 'pending';

            $registration = PpdbRegistration::create($data);

            \Log::info('PPDB Registration Created Successfully', [
                'registration_id' => $registration->id,
                'registration_number' => $registration->registration_number,
                'student_name' => $registration->student_name,
            ]);

            // Record activity for this new registration
            $this->recordRegistrationActivity($registration);

            return $registration;
        } catch (\Exception $e) {
            \Log::error('PPDB Registration Failed', [
                'message' => $e->getMessage(),
                'data' => $data,
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Record activity when registration is created
     */
    private function recordRegistrationActivity(PpdbRegistration $registration): void
    {
        $this->monitoringService->recordActivity(
            $registration->id,
            PpdbActivity::TYPE_CREATED,
            "Registrasi baru dari {$registration->parent_name}",
            ["student_name" => $registration->student_name]
        );
    }

    /**
     * Generate PDF output for PPDB registrations
     */
    public function generatePdfExport(array $settings): array
    {
        $registrations = PpdbRegistration::orderBy('created_at', 'asc')->get();

        $totalRegistrations = $registrations->count();
        $totalL = $registrations->where('gender', 'L')->count();
        $totalP = $registrations->where('gender', 'P')->count();
        $totalPending = $registrations->filter(fn ($r) => in_array(strtolower($r->status), ['pending']))->count();
        $totalDiterima = $registrations->filter(fn ($r) => in_array(strtolower($r->status), ['accepted', 'diterima']))->count();
        $totalDitolak = $registrations->filter(fn ($r) => in_array(strtolower($r->status), ['rejected', 'ditolak']))->count();

        // Convert school logo to base64 for reliable Dompdf rendering
        $logoPath = public_path('mentahan2/img/Logo1.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,'.base64_encode($logoData);
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

        $options = new Options;
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'Data_Pendaftar_PPDB_'.Str::slug($settings['school_name'] ?? 'SD_Negeri_Lama').'_'.date('Y-m-d').'.pdf';

        return [
            'content' => $dompdf->output(),
            'filename' => $filename,
        ];
    }

    /**
     * Generate Excel export spreadsheet content for PPDB registrations
     */
    public function generateExcelExport(array $settings): array
    {
        $registrations = PpdbRegistration::orderBy('created_at', 'asc')->get();
        $html = view('admin.ppdb.excel', compact('settings', 'registrations'))->render();
        $filename = 'Data_Pendaftar_PPDB_'.Str::slug($settings['school_name'] ?? 'SD_Negeri_Lama').'_'.date('Y-m-d').'.xls';

        return [
            'content' => $html,
            'filename' => $filename,
        ];
    }
}
