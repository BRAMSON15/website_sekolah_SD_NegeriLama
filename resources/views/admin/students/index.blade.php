@extends('layouts.admin')

@section('title', 'Kelola Siswa - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    @if(session('success'))
    <div class="alert-custom-success">
        <span><i class="fa fa-check-circle"></i> {{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    <div class="information-hero">
        <div>
            <span class="panel-eyebrow">DATA PESERTA DIDIK</span>
            <h2>Kelola Siswa</h2>
            <p>Kelola rombongan belajar siswa. Tingkat kelas ini menentukan video dan materi yang tampil di Ruang Belajar.</p>
        </div>
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Siswa</a>
    </div>

    @if($errors->any())
    <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 14px 18px; margin-bottom: 20px;">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
    </div>
    @endif

    <div class="information-panel">
        <div class="information-panel-heading">
            <h4>Daftar Siswa</h4>
            <span class="information-count">{{ $students->total() }} siswa</span>
        </div>

        <form method="GET" action="{{ route('admin.students.index') }}" style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 18px;">
            <select name="class_name" class="form-control" style="max-width: 240px;">
                <option value="">Semua Rombel</option>
                @foreach($classOptions as $className)
                <option value="{{ $className }}" {{ request('class_name') === $className ? 'selected' : '' }}>{{ $className }}</option>
                @endforeach
            </select>
            <input type="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari nama atau NISN" style="flex: 1; min-width: 200px;">
            <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Terapkan</button>
            @if(request()->hasAny(['class_name', 'search']))
            <a href="{{ route('admin.students.index') }}" class="btn btn-grey">Reset</a>
            @endif
        </form>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr><th>Nama Siswa</th><th>NISN</th><th>Rombel</th><th>Jenis Kelamin</th><th class="text-right">Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td><strong>{{ $student->name }}</strong></td>
                        <td>{{ $student->nisn }}</td>
                        <td>{{ $student->class_name }}</td>
                        <td>{{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="text-right action-cell">
                            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-grey btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                            <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Hapus data siswa dan akun belajarnya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center" style="padding: 30px; color: #7390b5;">Belum ada siswa yang sesuai dengan filter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="information-pagination" style="margin-top: 20px;">{{ $students->links() }}</div>
    </div>
</div>
@endsection