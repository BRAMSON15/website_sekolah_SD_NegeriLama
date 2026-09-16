@extends('layouts.admin')

@section('title', ($teacher->exists ? 'Edit Akun Guru' : 'Tambah Akun Guru') . ' - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    <div class="information-hero">
        <div>
            <span class="panel-eyebrow">KELOLA AKUN / GURU</span>
            <h2>{{ $teacher->exists ? 'Edit Akun Guru' : 'Tambah Akun Guru Baru' }}</h2>
            <p>Password akun guru secara otomatis menggunakan NIP yang diinputkan.</p>
        </div>
    </div>

    @if ($errors->any())
    <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 14px; border-radius: 9px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 16px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="information-panel">
        <form action="{{ $teacher->exists ? route('admin.teachers.update', $teacher) : route('admin.teachers.store') }}" method="POST">
            @csrf
            @if($teacher->exists)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Lengkap Guru (dengan Gelar)</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso, S.Pd" value="{{ old('name', $teacher->name) }}" required>
                        <span class="form-hint">Digunakan guru untuk memasukkan Nama saat login portal.</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>NIP (Nomor Induk Pegawai)</label>
                        <input type="text" name="nip" class="form-control" placeholder="Contoh: 198507122010011002" value="{{ old('nip', $teacher->nip) }}" required>
                        <span class="form-hint">NIP akan berfungsi sebagai password saat login.</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Mata Pelajaran / Tugas Mengajar</label>
                        <input type="text" name="subject" class="form-control" placeholder="Contoh: Matematika / Wali Kelas 5" value="{{ old('subject', $teacher->subject) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Email (Opsional)</label>
                        <input type="email" name="email" class="form-control" placeholder="budi@sdnegerilama.sch.id" value="{{ old('email', $teacher->email) }}">
                        <span class="form-hint">Jika dikosongkan, email otomatis akan dibuatkan sistem.</span>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-grey">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data Guru</button>
            </div>
        </form>
    </div>
</div>
@endsection
