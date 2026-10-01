@extends('layouts.admin')

@section('title', 'Kalender Pendidikan - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    @if (session('success'))<div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>@endif
    <div class="information-hero"><div><span class="panel-eyebrow">KELOLA INFORMASI</span><h2>Kalender Pendidikan</h2><p>Kelola jadwal pembelajaran, ujian, libur, dan kegiatan sekolah.</p></div><a href="{{ route('admin.kalender.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Agenda</a></div>
    <div class="information-panel admin-table-panel">
        <div class="admin-panel-heading"><div><span class="panel-eyebrow">DAFTAR AGENDA</span><h4>Semua Kegiatan</h4></div><span class="information-count">{{ $events->total() }} data</span></div>
        <div class="table-responsive"><table><thead><tr><th>Kegiatan</th><th>Kategori</th><th>Tanggal</th><th>Status</th><th class="text-right">Aksi</th></tr></thead><tbody>
        @forelse($events as $event)
        <tr><td><strong>{{ $event->title }}</strong>@if($event->description)<small class="table-subtext">{{ \Illuminate\Support\Str::limit($event->description, 90) }}</small>@endif</td><td>{{ $event->category }}</td><td>{{ $event->start_date->format('d M Y') }}@if(!$event->start_date->isSameDay($event->end_date))<br>s.d. {{ $event->end_date->format('d M Y') }}@endif</td><td><span class="information-status {{ $event->is_active ? 'information-status-active' : 'information-status-muted' }}">{{ $event->is_active ? 'Aktif' : 'Nonaktif' }}</span></td><td class="text-right action-cell"><a href="{{ route('admin.kalender.edit', $event) }}" class="btn btn-grey btn-xs"><i class="fa fa-pencil"></i> Edit</a><form action="{{ route('admin.kalender.destroy', $event) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?');">@csrf @method('DELETE')<button class="btn btn-danger btn-xs" aria-label="Hapus agenda"><i class="fa fa-trash"></i></button></form></td></tr>
        @empty<tr><td colspan="5" class="text-center">Belum ada agenda pendidikan.</td></tr>@endforelse
        </tbody></table></div>
        <div class="information-pagination">{{ $events->links() }}</div>
    </div>
</div>
@endsection