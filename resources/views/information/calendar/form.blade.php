@extends('layouts.admin')

@section('title', ($event->exists ? 'Edit Agenda' : 'Tambah Agenda') . ' - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    <div class="information-hero"><div><span class="panel-eyebrow">KELOLA INFORMASI / KALENDER PENDIDIKAN</span><h2>{{ $event->exists ? 'Edit Agenda' : 'Tambah Agenda' }}</h2><p>Atur rentang tanggal dan kategori kegiatan sekolah.</p></div></div>
    @if ($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="information-panel information-form-panel">
        <form action="{{ $event->exists ? route('admin.kalender.update', $event) : route('admin.kalender.store') }}" method="POST">@csrf @if($event->exists) @method('PUT') @endif
            <div class="form-group"><label>Nama Kegiatan</label><input type="text" name="title" class="form-control" value="{{ old('title', $event->title) }}" maxlength="255" required></div>
            <div class="row"><div class="col-md-4"><div class="form-group"><label>Kategori</label><select name="category" class="form-control" required>@foreach($categories as $category)<option value="{{ $category }}" {{ old('category', $event->category ?: 'Kegiatan') === $category ? 'selected' : '' }}>{{ $category }}</option>@endforeach</select></div></div><div class="col-md-4"><div class="form-group"><label>Tanggal Mulai</label><input type="date" name="start_date" class="form-control" value="{{ old('start_date', optional($event->start_date)->format('Y-m-d') ?: date('Y-m-d')) }}" required></div></div><div class="col-md-4"><div class="form-group"><label>Tanggal Selesai</label><input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($event->end_date)->format('Y-m-d') ?: date('Y-m-d')) }}" required></div></div></div>
            <div class="form-group"><label>Keterangan</label><textarea name="description" class="form-control" rows="5" maxlength="5000">{{ old('description', $event->description) }}</textarea></div>
            <div class="checkbox"><label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $event->exists ? $event->is_active : true) ? 'checked' : '' }}> Tampilkan pada kalender publik</label></div>
            <div class="form-actions"><a href="{{ route('admin.kalender.index') }}" class="btn btn-grey">Batal</a><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Agenda</button></div>
        </form>
    </div>
</div>
@endsection