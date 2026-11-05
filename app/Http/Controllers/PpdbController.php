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
        return view("pages.ppdb-register", compact("settings"));
    }

    public function store(Request $request)
    {
        try {
            // Validate registration data using service
            $validated = $this->ppdbService->validateRegistration($request->all());

            // Handle file uploads using service
            $uploadedFiles = $this->ppdbService->handleSupportingFileUploads($request);
            $validated = array_merge($validated, $uploadedFiles);

            // Register using service (includes activity recording)
            $registration = $this->ppdbService->register($validated);

            return redirect()->route("ppdb.success", $registration)
                ->with("success", "Pendaftaran PPDB berhasil dikirim.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error("PPDB Registration Error", [
                "message" => $e->getMessage(),
                "file" => $e->getFile(),
                "line" => $e->getLine(),
                "trace" => $e->getTraceAsString(),
            ]);

            return back()
                ->with("error", "Terjadi kesalahan saat memproses pendaftaran: " . $e->getMessage() . ". Silakan coba lagi atau hubungi admin.")
                ->withInput();
        }
    }

    public function success(PpdbRegistration $registration)
    {
        $settings = $this->websiteService->getSettings();
        return view("pages.ppdb-success", compact("settings", "registration"));
    }

    public function index()
    {
        $settings = $this->websiteService->getSettings();
        return view("admin.ppdb.index", compact("settings"));
    }

    public function monitoringDashboard()
    {
        $settings = $this->websiteService->getSettings();
        return view("admin.ppdb.monitoring", compact("settings"));
    }

    public function exportPdf()
    {
        $settings = $this->websiteService->getSettings();
        $export = $this->ppdbService->generatePdfExport($settings);

        return response($export["content"])
            ->header("Content-Type", "application/pdf")
            ->header("Content-Disposition", "attachment; filename=\"".$export["filename"]."\"");
    }

    public function exportExcel()
    {
        $settings = $this->websiteService->getSettings();
        $export = $this->ppdbService->generateExcelExport($settings);

        return response($export["content"])
            ->header("Content-Type", "application/vnd.ms-excel; charset=UTF-8")
            ->header("Content-Disposition", "attachment; filename=\"".$export["filename"]."\"")
            ->header("Pragma", "no-cache")
            ->header("Expires", "0");
    }
}
