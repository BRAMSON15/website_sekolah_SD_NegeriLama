@extends('layouts.admin')

@section('title', ($student->exists ? 'Edit' : 'Tambah') . ' Siswa - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    <div class="information-hero">
        <div>
            <span class="panel-eyebrow">DATA PESERTA DIDIK</span>
            <h2>{{ $student->exists ? 'Edit Data Siswa' : 'Tambah Siswa' }}</h2>
            <p>Pastikan rombel sesuai dengan tingkat kelas siswa agar media belajar tersaring dengan benar.</p>
        </div>
    </div>

    @if($errors->any())
    <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 14px 18px; margin-bottom: 20px;">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
    </div>
    @endif

    <form action="{{ $student->exists ? route('admin.students.update', $student) : route('admin.students.store') }}" method="POST">
        @csrf
        @if($student->exists) @method('PUT') @endif
        <div class="information-panel">
            <div class="form-group">
                <label for="student-name">Nama Lengkap</label>
                <input id="student-name" type="text" name="name" class="form-control" required maxlength="255" value="{{ old('name', $student->name) }}">
            </div>
            <div class="form-group">
                <label for="student-nisn">NISN</label>
                <input id="student-nisn" type="text" name="nisn" class="form-control" required maxlength="20" value="{{ old('nisn', $student->nisn) }}">
            </div>
            <div class="form-group">
                <label for="student-class">Rombel / Tingkat Kelas</label>
                <input id="student-class" type="text" name="class_name" class="form-control" required maxlength="100" placeholder="Contoh: Kelas 4A" value="{{ old('class_name', $student->class_name) }}">
                <span class="form-hint">Gunakan format seperti “Kelas 4A” atau “Kelas IV”. Materi akan dicocokkan berdasarkan tingkatnya.</span>
            </div>
            <div class="form-group">
                <label for="student-gender">Jenis Kelamin</label>
                <select id="student-gender" name="gender" class="form-control" required>
                    <option value="">Pilih jenis kelamin</option>
                    <option value="L" {{ old('gender', $student->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender', $student->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="form-actions">
                <a href="{{ route('admin.students.index') }}" class="btn btn-grey">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Siswa</button>
            </div>
        </div>
    </form>
</div>
@endsection