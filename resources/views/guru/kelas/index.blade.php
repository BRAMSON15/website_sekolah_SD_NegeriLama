@extends('layouts.guru')

@section('title', 'Kelas Saya - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
@if(session('success'))
<div style="background:#dcfce7;border:1px solid #86efac;color:#166534;padding:14px 18px;border-radius:10px;margin-bottom:20px;font-weight:600"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:14px 18px;border-radius:10px;margin-bottom:20px;font-weight:600"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
@endif
<div class="welcome" style="margin-bottom:24px">
    <div class="welcome-text"><h1><i class="fa-solid fa-users-rectangle"></i> Kelas Saya</h1><p>Buat kelas dan kelola informasi kelas yang Anda ampu.</p></div>
    <a href="{{ route('guru.kelas.create') }}" style="align-self:center;background:#16a34a;color:white;padding:11px 16px;border-radius:8px;text-decoration:none;font-weight:700"><i class="fa-solid fa-plus"></i> Buat Kelas</a>
</div>
<div class="section-card">
    <div class="section-header"><div><h2>Daftar Kelas</h2><p>Kelas yang dibuat oleh akun Anda</p></div><span>{{ $classrooms->count() }} kelas</span></div>
    @forelse($classrooms as $classroom)
    <div style="display:flex;align-items:center;gap:16px;padding:16px 0;border-top:1px solid #e2e8f0;flex-wrap:wrap">
        <div style="width:46px;height:46px;display:grid;place-items:center;border-radius:10px;background:#e0f2fe;color:#0369a1;font-weight:800"><i class="fa-solid fa-users"></i></div>
        <div style="flex:1;min-width:180px"><strong style="display:block;color:#1e293b">{{ $classroom->name }}</strong><span style="font-size:.84rem;color:#64748b">{{ $classroom->room ?: 'Ruang belum ditentukan' }} · {{ $classroom->students_count }} siswa</span>@if($classroom->description)<p style="margin:4px 0 0;color:#64748b;font-size:.85rem">{{ $classroom->description }}</p>@endif</div>
        <div style="display:flex;gap:8px"><a href="{{ route('guru.kelas.edit', $classroom) }}" class="btn btn-grey btn-xs"><i class="fa-solid fa-pen"></i> Edit</a><form action="{{ route('guru.kelas.destroy', $classroom) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-xs" aria-label="Hapus kelas"><i class="fa-solid fa-trash"></i></button></form></div>
    </div>
    @empty
    <div style="padding:36px 16px;text-align:center;color:#64748b;border-top:1px solid #e2e8f0"><i class="fa-solid fa-chalkboard-user" style="font-size:2rem;margin-bottom:10px"></i><p>Belum ada kelas yang Anda buat.</p><a href="{{ route('guru.kelas.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Buat kelas pertama</a></div>
    @endforelse
</div>
@endsection