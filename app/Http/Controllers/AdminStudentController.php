<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Services\AdminStudentService;
use App\Services\WebsiteContentService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminStudentController extends Controller
{
    public function __construct(
        protected AdminStudentService $studentService,
        protected WebsiteContentService $websiteService
    ) {}

    public function index(Request $request)
    {
        $this->ensureAdmin();
        $settings = $this->websiteService->getSettings();
        $students = $this->studentService->getStudents($request);
        $classOptions = $this->studentService->getClassOptions();

        return view('admin.students.index', compact('settings', 'students', 'classOptions'));
    }

    public function create()
    {
        $this->ensureAdmin();
        return view('admin.students.form', [
            'settings' => $this->websiteService->getSettings(),
            'student' => new Student(),
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();
        $this->studentService->createStudent($this->validateStudent($request));

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        $this->ensureAdmin();
        return view('admin.students.form', [
            'settings' => $this->websiteService->getSettings(),
            'student' => $student,
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $this->ensureAdmin();
        $this->studentService->updateStudent($student, $this->validateStudent($request, $student));

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $this->ensureAdmin();
        $this->studentService->deleteStudent($student);

        return redirect()->route('admin.students.index')->with('success', 'Data siswa dan akun terkait berhasil dihapus.');
    }

    private function validateStudent(Request $request, ?Student $student = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'string', 'max:20', Rule::unique('students', 'nisn')->ignore($student?->id)],
            'class_name' => ['required', 'string', 'max:100'],
            'gender' => ['required', Rule::in(['L', 'P'])],
        ]);
    }

    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
    }
}