@extends('layouts.admin')

@section('title', ($announcement->exists ? 'Edit Pengumuman' : 'Tambah Pengumuman') . ' - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    <div class="information-hero"><div><span class="panel-eyebrow">KELOLA INFORMASI / PENGUMUMAN</span><h2>{{ $announcement->exists ? 'Edit Pengumuman' : 'Tambah Pengumuman' }}</h2><p>Isi informasi dengan jelas agar mudah dibaca warga sekolah.</p></div></div>
    @if ($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="information-panel information-form-panel">
        <form action="{{ $announcement->exists ? route('admin.pengumuman.update', $announcement) : route('admin.pengumuman.store') }}" method="POST">@csrf @if($announcement->exists) @method('PUT') @endif
            <div class="row"><div class="col-md-8"><div class="form-group"><label>Judul Pengumuman</label><input type="text" name="title" class="form-control" value="{{ old('title', $announcement->title) }}" required></div></div><div class="col-md-4"><div class="form-group"><label>Tanggal Publikasi</label><input type="date" name="published_at" class="form-control" value="{{ old('published_at', optional($announcement->published_at)->format('Y-m-d') ?: date('Y-m-d')) }}" required></div></div></div>
            <div class="form-group"><label>Isi Pengumuman</label><textarea name="content" class="form-control" rows="8" required>{{ old('content', $announcement->content) }}</textarea></div>
            <div class="checkbox"><label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $announcement->exists ? $announcement->is_active : true) ? 'checked' : '' }}> Tampilkan sebagai pengumuman aktif</label></div>
            <div class="form-actions"><a href="{{ route('admin.pengumuman.index') }}" class="btn btn-grey">Batal</a><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Pengumuman</button></div>
        </form>
    </div>
</div>
@endsection
