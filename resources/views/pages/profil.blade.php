@extends('layouts.app')

@section('title', 'Profil Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Profil Sekolah</h1>
  <p>Mengenal lebih dekat visi, misi, sejarah, dan struktur organisasi {{ $settings['school_name'] ?? 'SD Negeri Lama' }}</p>
</div>

<div class="page-content">
  <div class="card-box">
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-bullseye"></i> Visi & Misi</h2>
    <div style="margin-bottom: 24px;">
      <h3 style="font-size: 1.1rem; margin-bottom: 8px;">Visi</h3>
      <p style="color: var(--muted); font-size: 1rem; padding-left: 16px; border-left: 4px solid var(--primary);">
        "{{ $settings['school_vision'] ?? 'Terwujudnya Peserta Didik yang Bertaqwa, Berprestasi Tinggi, Berkarakter Pancasila, dan Berwawasan Lingkungan Global.' }}"
      </p>
    </div>
    <div>
      <h3 style="font-size: 1.1rem; margin-bottom: 8px;">Misi</h3>
      @php
        $defaultMissions = [
          'Menanamkan nilai-nilai keimanan dan ketaqwaan kepada Tuhan Yang Maha Esa melalui kegiatan keagamaan rutin.',
          'Menyelenggarakan proses pembelajaran yang aktif, kreatif, inovatif, dan menyenangkan berbasis teknologi informasi.',
          'Mendorong dan memfasilitasi siswa untuk menguasai ilmu pengetahuan dan teknologi serta meraih prestasi dalam lomba akademik maupun non-akademik.',
          'Membentuk karakter siswa yang sopan, santun, jujur, serta memiliki kepedulian sosial dan lingkungan.'
        ];
        if (!empty($settings['school_mission'])) {
          $missions = array_filter(array_map('trim', explode("\n", $settings['school_mission'])));
        } else {
          $missions = $defaultMissions;
        }
      @endphp
      <ul style="color: var(--muted); padding-left: 20px; font-size: 0.95rem; line-height: 1.8;">
        @foreach($missions as $mission)
          <li>{{ $mission }}</li>
        @endforeach
      </ul>
    </div>
  </div>

  @if(!empty($settings['school_history']))
  <div class="card-box">
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-landmark"></i> Sejarah Sekolah</h2>
    <p style="color: var(--muted); line-height: 1.8;">
      {{ $settings['school_history'] }}
    </p>
  </div>
  @endif

  <div class="card-box">
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-user-tie"></i> Sambutan Kepala Sekolah</h2>
    <p style="color: var(--muted); line-height: 1.8; margin-bottom: 16px;">
      "{{ $settings['principal_message'] ?? 'Selamat datang di SD Negeri Lama.' }}"
    </p>
    <div style="font-weight: 800; color: var(--dark);">{{ $settings['principal_name'] ?? 'Drs. H. Ahmad Dahlan, M.Pd.' }}</div>
    <div style="font-size: 0.85rem; color: var(--muted);">{{ $settings['principal_title'] ?? 'Kepala Sekolah SD Negeri Lama' }}</div>
  </div>
</div>
@endsection
