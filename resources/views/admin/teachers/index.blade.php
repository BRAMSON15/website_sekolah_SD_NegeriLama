@extends('layouts.admin')

@section('title', 'Kelola Akun Guru - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    @if (session('success'))
    <div class="alert-custom-success">
        <span><i class="fa fa-check-circle"></i> {{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    <div class="information-hero">
        <div>
            <span class="panel-eyebrow">KELOLA AKUN MANAJEMEN</span>
            <h2>Data & Akun Guru</h2>
            <p>Kelola data pendidik, NIP, serta akses akun portal guru {{ $settings['school_name'] ?? 'SD Negeri Lama' }}.</p>
        </div>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Akun Guru
        </a>
    </div>

    <div class="information-panel">
        <div class="information-panel-heading">
            <div>
                <span class="panel-eyebrow">TENAGA PENDIDIK</span>
                <h4>Daftar Guru Terdaftar</h4>
            </div>
            <span class="information-count">{{ $teachers->total() }} Guru</span>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama Guru</th>
                        <th>NIP (Password Default)</th>
                        <th>Mata Pelajaran / Tugas</th>
                        <th>Email</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                    <tr>
                        <td>
                            <strong><i class="fa fa-user-tie" style="color: #1769d9; margin-right: 6px;"></i> {{ $teacher->name }}</strong>
                        </td>
                        <td>
                            <code style="background: #eef4ff; color: #1769d9; padding: 3px 8px; border-radius: 6px; font-weight: 700;">{{ $teacher->nip ?? '-' }}</code>
                        </td>
                        <td>{{ $teacher->subject ?? 'Guru Kelas' }}</td>
                        <td>{{ $teacher->email }}</td>
                        <td class="text-right action-cell">
                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-grey btn-xs">
                                <i class="fa fa-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" onsubmit="return confirm('Hapus akun guru ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 30px; color: #7390b5;">
                            Belum ada akun guru. Klik tombol <strong>"Tambah Akun Guru"</strong> untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="information-pagination" style="margin-top: 20px;">
            {{ $teachers->links() }}
        </div>
    </div>
</div>
@endsection
