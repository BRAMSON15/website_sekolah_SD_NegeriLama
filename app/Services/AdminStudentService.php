<?php

namespace App\Services;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminStudentService
{
    public function getStudents(Request $request)
    {
        return Student::query()
            ->when($request->filled('class_name'), fn ($query) => $query->where('class_name', $request->string('class_name')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->string('search')->toString());
                $query->where(fn ($query) => $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%"));
            })
            ->orderBy('class_name')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();
    }

    public function getClassOptions(): array
    {
        return Classroom::query()->orderBy('name')->pluck('name')
            ->merge(Student::query()->distinct()->orderBy('class_name')->pluck('class_name'))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    public function createStudent(array $data): Student
    {
        return Student::create($data);
    }

    public function updateStudent(Student $student, array $data): void
    {
        DB::transaction(function () use ($student, $data) {
            $oldNisn = $student->nisn;
            $student->update($data);

            $user = User::where('role', 'siswa')->where('nip', $oldNisn)->first();
            if (! $user) {
                return;
            }

            $userData = [
                'name' => $data['name'],
                'nip' => $data['nisn'],
            ];
            if ($user->email === $oldNisn . '@siswa.sdnegerilama.sch.id') {
                $userData['email'] = $data['nisn'] . '@siswa.sdnegerilama.sch.id';
            }

            $user->update($userData);
        });
    }

    public function deleteStudent(Student $student): void
    {
        DB::transaction(function () use ($student) {
            User::where('role', 'siswa')->where('nip', $student->nisn)->delete();
            $student->delete();
        });
    }
}