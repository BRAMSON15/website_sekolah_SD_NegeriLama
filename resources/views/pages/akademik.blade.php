@extends('layouts.app')

@section('title', 'Akademik & Kurikulum - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Akademik & Kurikulum</h1>
  <p>Informasi kurikulum pembelajaran, kegiatan ekstrakurikuler, dan kalender akademik</p>
</div>

<div class="page-content">
  <div class="card-box">
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-book-open-reader"></i> {{ $settings['curriculum_title'] ?? 'Kurikulum Merdeka' }}</h2>
    <p style="color: var(--muted); line-height: 1.8; margin-bottom: 16px;">
      {!! nl2br(e($settings['curriculum_desc'] ?? (($settings['school_name'] ?? 'SD Negeri Lama') . ' menerapkan Kurikulum Merdeka yang berfokus pada pengembangan minat, bakat, dan pembentukan Karakter Pelajar Pancasila. Sistem pembelajaran dirancang agar fleksibel dan interaktif melalui Projek Penguatan Profil Pelajar Pancasila (P5).'))) !!}
    </p>
  </div>

  <div class="card-box">
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-medal"></i> Ekstrakurikuler</h2>
    <p style="color: var(--muted); margin-bottom: 20px;">Kami menyediakan berbagai wadah pengembangan bakat non-akademik bagi peserta didik:</p>
    @php
      $defaultEskuls = [
        'Pramuka (Wajib)',
        'Sepak Bola & Futsal',
        'Seni Musik & Pianika',
        'Seni Lukis & Mewarnai',
        'Ekskul Komputer / Coding',
        'Pencak Silat'
      ];
      if (!empty($settings['extracurriculars'])) {
        $eskuls = array_filter(array_map('trim', explode("\n", $settings['extracurriculars'])));
      } else {
        $eskuls = $defaultEskuls;
      }

      $getIcon = function($name) {
        $lower = strtolower($name);
        if (str_contains($lower, 'pramuka')) return 'fa-campground';
        if (str_contains($lower, 'bola') || str_contains($lower, 'futsal')) return 'fa-futbol';
        if (str_contains($lower, 'musik') || str_contains($lower, 'pianika') || str_contains($lower, 'suara')) return 'fa-music';
        if (str_contains($lower, 'lukis') || str_contains($lower, 'warna') || str_contains($lower, 'tari')) return 'fa-palette';
        if (str_contains($lower, 'komputer') || str_contains($lower, 'coding') || str_contains($lower, 'it')) return 'fa-microchip';
        if (str_contains($lower, 'silat') || str_contains($lower, 'karate') || str_contains($lower, 'taekwondo')) return 'fa-hand-fist';
        if (str_contains($lower, 'tangkis') || str_contains($lower, 'badminton')) return 'fa-baseball';
        if (str_contains($lower, 'dokter') || str_contains($lower, 'uks') || str_contains($lower, 'pmr')) return 'fa-notes-medical';
        if (str_contains($lower, 'qur') || str_contains($lower, 'rohis') || str_contains($lower, 'agama')) return 'fa-book-quran';
        return 'fa-medal';
      };
    @endphp
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
      @foreach($eskuls as $eskul)
      <div style="background: var(--light-bg); padding: 16px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid {{ $getIcon($eskul) }}" style="color: var(--primary); font-size: 1.1rem; width: 22px; text-align: center;"></i>
        <span>{{ $eskul }}</span>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
