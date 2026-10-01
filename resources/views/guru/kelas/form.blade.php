@extends('layouts.guru')

@section('title', ($classroom->exists ? 'Edit Kelas' : 'Buat Kelas') . ' - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
<div class="welcome" style="margin-bottom:24px"><div class="welcome-text"><h1><i class="fa-solid fa-users-rectangle"></i> {{ $classroom->exists ? 'Edit Kelas' : 'Buat Kelas' }}</h1><p>Informasi ini akan digunakan pada pilihan kelas materi dan video.</p></div></div>
@if($errors->any())<div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:14px 18px;border-radius:10px;margin-bottom:20px"><ul style="margin:0;padding-left:20px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="section-card" style="max-width:760px">
    <form action="{{ $classroom->exists ? route('guru.kelas.update', $classroom) : route('guru.kelas.store') }}" method="POST">
        @csrf @if($classroom->exists) @method('PUT') @endif
        <div style="margin-bottom:18px"><label for="class-name" style="display:block;font-weight:700;margin-bottom:7px">Nama Kelas *</label><input id="class-name" name="name" type="text" value="{{ old('name', $classroom->name) }}" placeholder="Contoh: Kelas 4A" maxlength="100" required style="width:100%;padding:11px 13px;border:1px solid #cbd5e1;border-radius:8px;box-sizing:border-box"></div>
        <div style="margin-bottom:18px"><label for="class-room" style="display:block;font-weight:700;margin-bottom:7px">Ruang Kelas</label><input id="class-room" name="room" type="text" value="{{ old('room', $classroom->room) }}" placeholder="Contoh: Ruang 4A" maxlength="100" style="width:100%;padding:11px 13px;border:1px solid #cbd5e1;border-radius:8px;box-sizing:border-box"></div>
        <div style="margin-bottom:22px"><label for="class-description" style="display:block;font-weight:700;margin-bottom:7px">Keterangan</label><textarea id="class-description" name="description" rows="4" maxlength="1000" placeholder="Catatan kelas (opsional)" style="width:100%;padding:11px 13px;border:1px solid #cbd5e1;border-radius:8px;box-sizing:border-box;resize:vertical">{{ old('description', $classroom->description) }}</textarea></div>
        <div style="display:flex;justify-content:flex-end;gap:10px"><a href="{{ route('guru.kelas.index') }}" class="btn btn-grey">Batal</a><button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Kelas</button></div>
    </form>
</div>
@endsection