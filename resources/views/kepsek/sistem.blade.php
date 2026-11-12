@extends('layouts.kepsek')

@section('title', 'Monitoring Sistem & Informasi - Kepala Sekolah')
@section('page-title', 'Status Sistem & Kesehatan Layanan')

@section('content')
@php
    $totalMedia = $stats['videos_count'] + $stats['materials_count'];
@endphp

<!-- Hero -->
<section class="exec-hero">
  <div class="exec-hero-glow exec-hero-glow--gold" aria-hidden="true"></div>
  <div class="exec-hero-glow exec-hero-glow--blue" aria-hidden="true"></div>

  <div class="exec-hero-main">
    <span class="exec-hero-chip">
      <i class="fa-solid fa-server"></i> Pusat Kontrol Operasional
    </span>
    <h1>Status &amp; <span>Kesehatan Sistem</span></h1>
    <p>
      Supervisi parameter server, integritas data, dan status modul aplikasi
      sekolah dalam satu panel pemantauan.
    </p>
    <div class="exec-hero-meta">
      <span><i class="fa-solid fa-code"></i> PHP {{ $serverInfo['php_version'] }}</span>
      <span><i class="fa-solid fa-cube"></i> Laravel {{ $serverInfo['laravel_version'] }}</span>
      <span class="exec-hero-status"><span class="pulse-dot"></span> Layanan normal</span>
    </div>
  </div>

  <div class="exec-hero-actions">
    <a href="{{ route('home') }}" target="_blank" class="hero-btn hero-btn--gold">
      <i class="fa-solid fa-globe"></i> Buka Website
    </a>
    <a href="{{ route('kepsek.dashboard') }}" class="hero-btn hero-btn--ghost">
      <i class="fa-solid fa-gauge-high"></i> Dashboard
    </a>
  </div>
</section>

<!-- Metric Cards -->
<div class="metric-grid">
  <div class="metric-card metric-card--blue">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-user-graduate"></i></div>
    <div class="metric-info">
      <span class="metric-label">Total Siswa</span>
      <h3>{{ $stats['students_count'] }}</h3>
      <span class="metric-note"><i class="fa-solid fa-database"></i> Terdaftar di data pokok</span>
    </div>
    <i class="fa-solid fa-user-graduate metric-ghost" aria-hidden="true"></i>
  </div>

  <div class="metric-card metric-card--emerald">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
    <div class="metric-info">
      <span class="metric-label">Dewan Guru</span>
      <h3>{{ $stats['guru_count'] }}</h3>
      <span class="metric-note"><i class="fa-solid fa-id-badge"></i> Akun tenaga pendidik</span>
    </div>
    <i class="fa-solid fa-chalkboard-user metric-ghost" aria-hidden="true"></i>
  </div>

  <div class="metric-card metric-card--amber">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-photo-film"></i></div>
    <div class="metric-info">
      <span class="metric-label">Media Digital</span>
      <h3>{{ $totalMedia }}</h3>
      <span class="metric-note"><i class="fa-solid fa-cloud-arrow-up"></i> Video &amp; modul terbit</span>
    </div>
    <i class="fa-solid fa-photo-film metric-ghost" aria-hidden="true"></i>
  </div>

  <div class="metric-card metric-card--rose">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-address-card"></i></div>
    <div class="metric-info">
      <span class="metric-label">Pendaftar PPDB</span>
      <h3>{{ $stats['ppdb_count'] }}</h3>
      <span class="metric-note"><i class="fa-solid fa-user-plus"></i> Calon siswa baru</span>
    </div>
    <i class="fa-solid fa-address-card metric-ghost" aria-hidden="true"></i>
  </div>
</div>

<!-- Details -->
<div class="content-grid-2 content-grid-2--even">
  <!-- Data Records -->
  <div class="box-card">
    <div class="box-card-header">
      <div class="box-card-title">
        <span class="title-icon title-icon--violet"><i class="fa-solid fa-chart-pie"></i></span>
        Distribusi Rekam Data Sekolah
      </div>
      <span class="badge-tag">Live Record</span>
    </div>

    <div class="kp-info-list">
      <div class="kp-info-row">
        <div class="kp-info-left">
          <span class="kp-info-icon kp-info-icon--blue"><i class="fa-solid fa-users"></i></span>
          <span class="kp-info-label">Total Akun Pengguna</span>
        </div>
        <div class="kp-info-value">
          {{ $stats['users_total'] }}
          <span class="kp-info-sub">{{ $stats['admin_count'] }} admin &bull; {{ $stats['guru_count'] }} guru &bull; {{ $stats['kepsek_count'] }} kepsek</span>
        </div>
      </div>

      <div class="kp-info-row">
        <div class="kp-info-left">
          <span class="kp-info-icon kp-info-icon--rose"><i class="fa-solid fa-video"></i></span>
          <span class="kp-info-label">Video Pembelajaran</span>
        </div>
        <div class="kp-info-value">{{ $stats['videos_count'] }} video</div>
      </div>

      <div class="kp-info-row">
        <div class="kp-info-left">
          <span class="kp-info-icon kp-info-icon--amber"><i class="fa-solid fa-file-lines"></i></span>
          <span class="kp-info-label">Modul &amp; Bahan Ajar</span>
        </div>
        <div class="kp-info-value">{{ $stats['materials_count'] }} berkas</div>
      </div>

      <div class="kp-info-row">
        <div class="kp-info-left">
          <span class="kp-info-icon kp-info-icon--emerald"><i class="fa-solid fa-bullhorn"></i></span>
          <span class="kp-info-label">Pengumuman &amp; Berita</span>
        </div>
        <div class="kp-info-value">
          {{ $stats['announcements_count'] }}
          <span class="kp-info-sub">{{ $stats['active_announcements'] }} tayang</span>
        </div>
      </div>
    </div>

    <div class="kp-identity-meta" style="border-top:1px dashed #e2e8f0; color:#64748b; border-radius:0;">
      <i class="fa-solid fa-shield-halved" style="color:#059669;"></i>
      Data tersimpan pada basis data sekolah dan tercatat otomatis oleh sistem.
    </div>
  </div>

  <!-- Server Environment -->
  <div class="box-card">
    <div class="box-card-header">
      <div class="box-card-title">
        <span class="title-icon title-icon--blue"><i class="fa-solid fa-microchip"></i></span>
        Spesifikasi Lingkungan Server
      </div>
      <span class="status-chip status-chip--green"><span class="pulse-dot"></span> Online</span>
    </div>

    <div class="kp-info-list">
      <div class="kp-info-row">
        <div class="kp-info-left">
          <span class="kp-info-icon kp-info-icon--violet"><i class="fa-brands fa-php"></i></span>
          <span class="kp-info-label">Versi PHP</span>
        </div>
        <span class="kp-value-code">{{ $serverInfo['php_version'] }}</span>
      </div>

      <div class="kp-info-row">
        <div class="kp-info-left">
          <span class="kp-info-icon kp-info-icon--rose"><i class="fa-solid fa-fire"></i></span>
          <span class="kp-info-label">Framework Engine</span>
        </div>
        <span class="kp-value-code">Laravel {{ $serverInfo['laravel_version'] }}</span>
      </div>

      <div class="kp-info-row">
        <div class="kp-info-left">
          <span class="kp-info-icon kp-info-icon--blue"><i class="fa-solid fa-database"></i></span>
          <span class="kp-info-label">Driver Basis Data</span>
        </div>
        <span class="kp-value-code" style="text-transform:uppercase;">{{ $serverInfo['database'] }}</span>
      </div>

      <div class="kp-info-row">
        <div class="kp-info-left">
          <span class="kp-info-icon kp-info-icon--amber"><i class="fa-regular fa-clock"></i></span>
          <span class="kp-info-label">Zona Waktu Server</span>
        </div>
        <span class="kp-value-code">{{ $serverInfo['timezone'] }}</span>
      </div>

      <div class="kp-info-row">
        <div class="kp-info-left">
          <span class="kp-info-icon kp-info-icon--emerald"><i class="fa-solid fa-leaf"></i></span>
          <span class="kp-info-label">Lingkungan Operasi</span>
        </div>
        <span class="kp-env-chip {{ $serverInfo['app_env'] === 'production' ? 'kp-env-chip--prod' : 'kp-env-chip--local' }}">
          {{ $serverInfo['app_env'] }}
        </span>
      </div>

      <div class="kp-info-row">
        <div class="kp-info-left">
          <span class="kp-info-icon kp-info-icon--slate"><i class="fa-solid fa-link"></i></span>
          <span class="kp-info-label">Domain Portal</span>
        </div>
        <span class="kp-value-code" style="max-width:230px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $serverInfo['app_url'] }}</span>
      </div>
    </div>

    <div class="kp-identity-card">
      <div class="kp-identity-top">
        <span class="kp-identity-logo"><i class="fa-solid fa-school"></i></span>
        <div>
          <h4>{{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}</h4>
          <p>NPSN: 60101968 &bull; Terakreditasi {{ $settings['stat_akreditasi'] ?? 'A' }}</p>
        </div>
      </div>
      <div class="kp-identity-meta">
        Kepala Sekolah Pengampu:
        <strong>{{ $settings['principal_name'] ?? 'Drs. H. Ahmad Dahlan, M.Pd.' }}</strong>
      </div>
    </div>
  </div>
</div>
@endsection
