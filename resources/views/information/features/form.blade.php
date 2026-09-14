@extends('layouts.admin')

@section('title', ($feature->exists ? 'Edit Fitur / Layanan' : 'Tambah Fitur / Layanan') . ' - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    <div class="information-hero"><div><span class="panel-eyebrow">KELOLA INFORMASI / FITUR</span><h2>{{ $feature->exists ? 'Edit Fitur / Layanan' : 'Tambah Fitur / Layanan' }}</h2><p>Tambahkan keunggulan yang ingin ditampilkan pada halaman depan.</p></div></div>
    @if ($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="information-panel information-form-panel">
        <form action="{{ $feature->exists ? route('admin.fitur.update', $feature) : route('admin.fitur.store') }}" method="POST">@csrf @if($feature->exists) @method('PUT') @endif
            <div class="row"><div class="col-md-8"><div class="form-group"><label>Nama Fitur / Layanan</label><input type="text" name="title" class="form-control" value="{{ old('title', $feature->title) }}" required></div></div><div class="col-md-4"><div class="form-group"><label>Urutan Tampil</label><input type="number" name="order" class="form-control" min="0" value="{{ old('order', $feature->order ?? 0) }}" required></div></div></div>
            <div class="form-group"><label>Deskripsi</label><textarea name="description" class="form-control" rows="5" required>{{ old('description', $feature->description) }}</textarea></div>
            <div class="row"><div class="col-md-6"><div class="form-group"><label>Class Ikon Font Awesome</label><input type="text" name="icon" class="form-control" placeholder="fa fa-star" value="{{ old('icon', $feature->icon) }}" required><span class="form-hint">Contoh: fa fa-book, fa fa-trophy, fa fa-laptop</span></div></div><div class="col-md-6"><div class="form-group"><label>Class Warna</label><input type="text" name="icon_color_class" class="form-control" placeholder="bg-blue" value="{{ old('icon_color_class', $feature->icon_color_class ?: 'bg-blue') }}" required><span class="form-hint">Contoh: bg-blue, bg-green, bg-purple</span></div></div></div>
            <div class="form-actions"><a href="{{ route('admin.fitur.index') }}" class="btn btn-grey">Batal</a><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Fitur</button></div>
        </form>
    </div>
</div>
@endsection
