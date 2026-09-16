<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolSetting;
use Illuminate\Support\Facades\Hash;

class AdminTeacherController extends Controller
{
    private function getSettings()
    {
        return SchoolSetting::pluck('value', 'key')->toArray();
    }

    public function index()
    {
        $settings = $this->getSettings();
        $teachers = User::where('role', 'guru')->orderBy('name')->paginate(10);

        return view('admin.teachers.index', compact('settings', 'teachers'));
    }

    public function create()
    {
        $settings = $this->getSettings();
        $teacher = new User();

        return view('admin.teachers.form', compact('settings', 'teacher'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:50', 'unique:users,nip'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'subject' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama lengkap guru wajib diisi.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar untuk guru lain.',
        ]);

        User::create([
            'name' => $validated['name'],
            'nip' => $validated['nip'],
            'email' => $validated['email'] ?: strtolower(str_replace(' ', '', $validated['name'])) . '@sdnegerilama.sch.id',
            'subject' => $validated['subject'] ?: 'Guru Kelas',
            'role' => 'guru',
            'password' => Hash::make($validated['nip']), // NIP digunakan sebagai password
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Akun Guru berhasil ditambahkan!');
    }

    public function edit(User $teacher)
    {
        $settings = $this->getSettings();

        return view('admin.teachers.form', compact('settings', 'teacher'));
    }

    public function update(Request $request, User $teacher)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:50', 'unique:users,nip,' . $teacher->id],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email,' . $teacher->id],
            'subject' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama lengkap guru wajib diisi.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar untuk guru lain.',
        ]);

        $teacher->update([
            'name' => $validated['name'],
            'nip' => $validated['nip'],
            'email' => $validated['email'] ?: $teacher->email,
            'subject' => $validated['subject'] ?: $teacher->subject,
            'password' => Hash::make($validated['nip']), // Auto update password jika NIP berubah
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data Akun Guru berhasil diperbarui!');
    }

    public function destroy(User $teacher)
    {
        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Akun Guru berhasil dihapus.');
    }
}
