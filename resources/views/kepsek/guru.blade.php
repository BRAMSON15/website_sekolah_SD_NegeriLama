@extends('layouts.kepsek')

@section('title', 'Monitoring Guru & Tenaga Pendidik - Kepala Sekolah')
@section('page-title', 'Monitoring Guru & Kinerja Pengajaran')

@section('content')
@php
    $activeTeachers = $teachers->filter(fn ($t) => ($t->materials_count ?? 0) > 0 || ($t->videos_count ?? 0) > 0)->count();
    $activeRate = $teachers->count() > 0 ? (int) round($activeTeachers / $teachers->count() * 100) : 0;
@endphp

<!-- Hero -->
<section class="exec-hero">
  <div class="exec-hero-glow exec-hero-glow--gold" aria-hidden="true"></div>
  <div class="exec-hero-glow exec-hero-glow--blue" aria-hidden="true"></div>

  <div class="exec-hero-main">
    <span class="exec-hero-chip">
      <i class="fa-solid fa-chalkboard-user"></i> Supervisi Akademik
    </span>
    <h1>Kinerja <span>Dewan Guru</span></h1>
    <p>
      Pantau keaktifan tenaga pendidik dalam menyusun modul materi dan video pembelajaran
      sebagai bahan evaluasi supervisi akademik.
    </p>
    <div class="exec-hero-meta">
      <span><i class="fa-regular fa-calendar-days"></i> {{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
      <span><i class="fa-solid fa-user-group"></i> {{ $totalTeachers }} guru terdaftar</span>
      <span class="exec-hero-status"><span class="pulse-dot"></span> {{ $activeTeachers }} aktif berkonten</span>
    </div>
  </div>

  <div class="exec-hero-actions">
    <a href="{{ route('kepsek.monitoring.pembelajaran') }}" class="hero-btn hero-btn--gold">
      <i class="fa-solid fa-book-open-reader"></i> Supervisi Konten
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
    <div class="metric-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
    <div class="metric-info">
      <span class="metric-label">Total Guru</span>
      <h3>{{ $totalTeachers }}</h3>
      <span class="metric-note"><i class="fa-solid fa-users"></i> Tenaga pendidik terdaftar</span>
    </div>
    <i class="fa-solid fa-chalkboard-user metric-ghost" aria-hidden="true"></i>
  </div>

  <div class="metric-card metric-card--emerald">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-user-check"></i></div>
    <div class="metric-info">
      <span class="metric-label">Guru Aktif</span>
      <h3>{{ $activeTeachers }}</h3>
      <span class="metric-note"><i class="fa-solid fa-arrow-trend-up"></i> {{ $activeRate }}% dari daftar ini</span>
    </div>
    <i class="fa-solid fa-user-check metric-ghost" aria-hidden="true"></i>
  </div>

  <div class="metric-card metric-card--cyan">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-book"></i></div>
    <div class="metric-info">
      <span class="metric-label">Modul Materi</span>
      <h3>{{ $totalMaterialsUploaded }}</h3>
      <span class="metric-note"><i class="fa-solid fa-folder-open"></i> Bahan ajar digital</span>
    </div>
    <i class="fa-solid fa-book metric-ghost" aria-hidden="true"></i>
  </div>

  <div class="metric-card metric-card--rose">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-circle-play"></i></div>
    <div class="metric-info">
      <span class="metric-label">Video Edukasi</span>
      <h3>{{ $totalVideosUploaded }}</h3>
      <span class="metric-note"><i class="fa-solid fa-film"></i> Media pembelajaran</span>
    </div>
    <i class="fa-solid fa-circle-play metric-ghost" aria-hidden="true"></i>
  </div>
</div>

<!-- Toolbar -->
<div class="box-card kp-toolbar">
  <div class="kp-toolbar-head">
    <div>
      <h3 class="kp-section-title">
        <span class="title-icon title-icon--blue"><i class="fa-solid fa-list-check"></i></span>
        Daftar Kinerja Tenaga Pendidik
      </h3>
      <p class="kp-section-sub">
        Evaluasi pemanfaatan media digital oleh dewan guru untuk kegiatan belajar mengajar peserta didik.
      </p>
    </div>

    <form method="GET" action="{{ route('kepsek.monitoring.guru') }}" class="kp-search-form">
      <div class="kp-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, NIP, atau mata pelajaran...">
      </div>
      <button type="submit" class="kp-btn kp-btn--primary">
        <i class="fa-solid fa-magnifying-glass"></i> Cari
      </button>
      @if($search)
        <a href="{{ route('kepsek.monitoring.guru') }}" class="kp-btn kp-btn--soft">
          <i class="fa-solid fa-rotate-left"></i> Reset
        </a>
      @endif
    </form>
  </div>
</div>

<!-- Teacher Table -->
<div class="box-card">
  <div class="box-card-header">
    <div class="box-card-title">
      <span class="title-icon title-icon--blue"><i class="fa-solid fa-table-list"></i></span>
      Rekap Aktivitas &amp; Kontribusi Konten
    </div>
    <span class="badge-tag">{{ $teachers->count() }} guru ditampilkan</span>
  </div>

  @if($teachers->isNotEmpty())
    <div class="active-rate">
      <div class="active-rate-text">
        <strong>{{ $activeRate }}%</strong>
        <span>guru pada daftar ini telah mengunggah materi atau video ({{ $activeTeachers }} dari {{ $teachers->count() }})</span>
      </div>
      <div class="active-rate-bar" role="progressbar" aria-valuenow="{{ $activeRate }}" aria-valuemin="0" aria-valuemax="100">
        <span style="width: {{ $activeRate }}%;"></span>
      </div>
    </div>
  @endif

  <div class="table-wrap">
    <table class="table-clean">
      <thead>
        <tr>
          <th>Guru &amp; Akun</th>
          <th>NIP</th>
          <th>Mata Pelajaran</th>
          <th class="text-center">Modul</th>
          <th class="text-center">Video</th>
          <th>Status Keaktifan</th>
          <th class="text-right">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($teachers as $t)
          <tr>
            <td>
              <div class="teacher-cell">
                <span class="avatar-initial avatar-initial--{{ ($loop->index % 5) + 1 }}">
                  {{ strtoupper(mb_substr($t->name, 0, 1)) }}
                </span>
                <div class="teacher-identity">
                  <div class="teacher-name">{{ $t->name }}</div>
                  <div class="teacher-mail">{{ $t->email }}</div>
                </div>
              </div>
            </td>
            <td><code class="code-pill">{{ $t->nip ?? 'Belum diisi' }}</code></td>
            <td><span class="subject-badge">{{ $t->subject ?? 'Guru Kelas' }}</span></td>
            <td class="text-center"><span class="count-pill count-pill--blue">{{ $t->materials_count }}</span></td>
            <td class="text-center"><span class="count-pill count-pill--rose">{{ $t->videos_count }}</span></td>
            <td>
              @if($t->materials_count > 0 || $t->videos_count > 0)
                <span class="status-chip status-chip--green"><i class="fa-solid fa-circle-check"></i> Aktif</span>
              @else
                <span class="status-chip status-chip--slate"><i class="fa-solid fa-clock"></i> Belum Unggah</span>
              @endif
            </td>
            <td class="text-right">
              <a href="{{ route('kepsek.monitoring.pembelajaran', ['search' => $t->name]) }}" class="kp-btn kp-btn--soft kp-btn--sm">
                <i class="fa-solid fa-eye"></i> Periksa
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7">
              <div class="empty-state">
                <i class="fa-solid fa-user-slash"></i>
                <p>Tidak ada guru yang cocok dengan pencarian "{{ $search }}".</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
