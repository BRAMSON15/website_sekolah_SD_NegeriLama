<?php

namespace App\Http\Controllers;

use App\Models\PpdbRegistration;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    private function generateRegistrationNumber(): string
    {
        do {
            $number = 'PPDB-' . now()->format('Y') . '-' . Str::upper(Str::random(6));
        } while (PpdbRegistration::where('registration_number', $number)->exists());

        return $number;
    }
}
