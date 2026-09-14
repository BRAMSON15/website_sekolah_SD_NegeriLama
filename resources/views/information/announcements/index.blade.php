@extends('layouts.admin')

@section('title', 'Kelola Pengumuman - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    @if (session('success'))<div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>@endif
    <div class="information-hero"><div><span class="panel-eyebrow">KELOLA INFORMASI</span><h2>Pengumuman</h2><p>Buat dan kelola informasi yang tampil pada website sekolah.</p></div><a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Pengumuman</a></div>
    <div class="information-panel admin-table-panel">
        <div class="admin-panel-heading"><div><span class="panel-eyebrow">DAFTAR PUBLIKASI</span><h4>Semua Pengumuman</h4></div><span class="information-count">{{ $announcements->total() }} data</span></div>
        <div class="table-responsive"><table><thead><tr><th>Judul</th><th>Tanggal</th><th>Status</th><th class="text-right">Aksi</th></tr></thead><tbody>
        @forelse($announcements as $announcement)
        <tr><td><strong>{{ $announcement->title }}</strong><small class="table-subtext">/{{ $announcement->slug }}</small></td><td>{{ $announcement->published_at ? $announcement->published_at->format('d M Y') : '-' }}</td><td><span class="information-status {{ $announcement->is_active ? 'information-status-active' : 'information-status-muted' }}">{{ $announcement->is_active ? 'Aktif' : 'Nonaktif' }}</span></td><td class="text-right action-cell"><a href="{{ route('admin.pengumuman.edit', $announcement) }}" class="btn btn-grey btn-xs"><i class="fa fa-pencil"></i> Edit</a><form action="{{ route('admin.pengumuman.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?');">@csrf @method('DELETE')<button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></form></td></tr>
        @empty<tr><td colspan="4" class="text-center">Belum ada pengumuman.</td></tr>@endforelse
        </tbody></table></div>
        <div class="information-pagination">{{ $announcements->links() }}</div>
    </div>
</div>
@endsection
