@extends('layouts.app')

@section('title', 'Akademik & Kurikulum - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Akademik & Kurikulum</h1>
  <p>Informasi kurikulum pembelajaran, kegiatan ekstrakurikuler, dan kalender akademik</p>
</div>

<div class="page-content">
  <div class="card-box">
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-book-open-reader"></i> Kurikulum Merdeka</h2>
    <p style="color: var(--muted); line-height: 1.8; margin-bottom: 16px;">
      {{ $settings['school_name'] ?? 'SD Negeri Lama' }} menerapkan Kurikulum Merdeka yang berfokus pada pengembangan minat, bakat, dan pembentukan Karakter Pelajar Pancasila. Sistem pembelajaran dirancang agar fleksibel dan interaktif melalui Projek Penguatan Profil Pelajar Pancasila (P5).
    </p>
  </div>

  <div class="card-box">
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-medal"></i> Ekstrakurikuler</h2>
    <p style="color: var(--muted); margin-bottom: 20px;">Kami menyediakan berbagai wadah pengembangan bakat non-akademik bagi peserta didik:</p>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
      <div style="background: var(--light-bg); padding: 16px; border-radius: 12px; font-weight: 700;"><i class="fa-solid fa-campground" style="color: var(--primary);"></i> Pramuka (Wajib)</div>
      <div style="background: var(--light-bg); padding: 16px; border-radius: 12px; font-weight: 700;"><i class="fa-solid fa-futbol" style="color: var(--primary);"></i> Sepak Bola & Futsal</div>
      <div style="background: var(--light-bg); padding: 16px; border-radius: 12px; font-weight: 700;"><i class="fa-solid fa-music" style="color: var(--primary);"></i> Seni Musik & Pianika</div>
      <div style="background: var(--light-bg); padding: 16px; border-radius: 12px; font-weight: 700;"><i class="fa-solid fa-palette" style="color: var(--primary);"></i> Seni Lukis & Mewarnai</div>
      <div style="background: var(--light-bg); padding: 16px; border-radius: 12px; font-weight: 700;"><i class="fa-solid fa-microchip" style="color: var(--primary);"></i> Ekskul Komputer / Coding</div>
      <div style="background: var(--light-bg); padding: 16px; border-radius: 12px; font-weight: 700;"><i class="fa-solid fa-hand-fist" style="color: var(--primary);"></i> Pencak Silat</div>
    </div>
  </div>
</div>
@endsection
