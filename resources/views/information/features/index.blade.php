@extends('layouts.admin')

@section('title', 'Kelola Fitur dan Layanan - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    @if (session('success'))<div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>@endif
    <div class="information-hero"><div><span class="panel-eyebrow">KELOLA INFORMASI</span><h2>Fitur / Layanan</h2><p>Kelola keunggulan dan layanan yang ditampilkan pada halaman depan.</p></div><a href="{{ route('admin.fitur.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Fitur</a></div>
    <div class="information-panel admin-table-panel">
        <div class="admin-panel-heading"><div><span class="panel-eyebrow">KONTEN HALAMAN DEPAN</span><h4>Semua Fitur / Layanan</h4></div><span class="information-count">{{ $features->total() }} data</span></div>
        <div class="table-responsive"><table><thead><tr><th>Fitur</th><th>Deskripsi</th><th>Urutan</th><th class="text-right">Aksi</th></tr></thead><tbody>
        @forelse($features as $feature)
        <tr><td><span class="feature-table-icon {{ $feature->icon_color_class ?: 'bg-blue' }}"><i class="{{ $feature->icon ?: 'fa fa-star' }}"></i></span><strong>{{ $feature->title }}</strong></td><td>{{ Str::limit($feature->description, 85) }}</td><td>{{ $feature->order }}</td><td class="text-right action-cell"><a href="{{ route('admin.fitur.edit', $feature) }}" class="btn btn-grey btn-xs"><i class="fa fa-pencil"></i> Edit</a><form action="{{ route('admin.fitur.destroy', $feature) }}" method="POST" onsubmit="return confirm('Hapus fitur ini?');">@csrf @method('DELETE')<button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></form></td></tr>
        @empty<tr><td colspan="4" class="text-center">Belum ada fitur atau layanan.</td></tr>@endforelse
        </tbody></table></div>
        <div class="information-pagination">{{ $features->links() }}</div>
    </div>
</div>
@endsection
