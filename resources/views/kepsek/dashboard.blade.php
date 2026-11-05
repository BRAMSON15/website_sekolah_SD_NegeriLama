@extends('layouts.kepsek')

@section('title', 'Dashboard Monitoring Eksekutif - Kepala Sekolah')
@section('page-title', 'Dashboard Monitoring Eksekutif')

@section('styles')
<link rel="stylesheet" href="{{ asset('mentahan2/css/dashboard.css') }}?v={{ filemtime(public_path('mentahan2/css/dashboard.css')) ?: time() }}">
@endsection

@section('content')
@php
    $totalTeachersListed = $teachers->count();
    $activeTeachers = $teachers->filter(fn ($t) => $t->materials_count > 0 || $t->videos_count > 0)->count();
    $activeRate = $totalTeachersListed > 0 ? round($activeTeachers / $totalTeachersListed * 100) : 0;

    $ppdbAccepted = $totalPpdbDiterima;
    $ppdbPending = $totalPpdbPending;
    $ppdbRest = max(0, $totalPpdb - $ppdbAccepted - $ppdbPending);
    $ppdbPct = fn ($n) => $totalPpdb > 0 ? round($n / $totalPpdb * 100) : 0;
    $acceptedPct = $ppdbPct($ppdbAccepted);
    $pendingPct = $ppdbPct($ppdbPending);
    $restPct = max(0, 100 - $acceptedPct - $pendingPct);
    $donutGradient = sprintf(
        'conic-gradient(#10b981 0%% %d%%, #f59e0b %d%% %d%%, #cbd5e1 %d%% 100%%)',
        $acceptedPct,
        $acceptedPct,
        $acceptedPct + $pendingPct,
        $acceptedPct + $pendingPct
    );
@endphp

<!-- Executive Welcome Banner -->
<section class="exec-hero">
  <div class="exec-hero-glow exec-hero-glow--gold" aria-hidden="true"></div>
  <div class="exec-hero-glow exec-hero-glow--blue" aria-hidden="true"></div>

  <div class="exec-hero-main">
    <span class="exec-hero-chip">
      <i class="fa-solid fa-crown"></i> Panel Supervisi Kepala Sekolah
    </span>
    <h1>Selamat Datang, <span>{{ $user->name }}</span></h1>
    <p>
      Pantau seluruh aktivitas akademik, kinerja materi &amp; video guru, serta pendaftaran PPDB
      secara terintegrasi dan akurat dalam satu tampilan.
    </p>
    <div class="exec-hero-meta">
      <span><i class="fa-regular fa-calendar-days"></i> {{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
      <span><i class="fa-solid fa-school"></i> {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}</span>
      <span class="exec-hero-status"><span class="pulse-dot"></span> Data tersinkron</span>
    </div>
  </div>

  <div class="exec-hero-actions">
    <a href="{{ route('kepsek.monitoring.ppdb', ['print' => 1]) }}" target="_blank" class="hero-btn hero-btn--gold">
      <i class="fa-solid fa-file-pdf"></i> Laporan PPDB
    </a>
    <a href="{{ route('kepsek.monitoring.guru') }}" class="hero-btn hero-btn--ghost">
      <i class="fa-solid fa-chalkboard-user"></i> Monitoring Guru
    </a>
  </div>
</section>

<!-- 1. Executive Summary Metric Cards -->
<div class="metric-grid">
  <a href="{{ route('kepsek.monitoring.guru') }}" class="metric-card metric-card--blue">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
    <div class="metric-info">
      <span class="metric-label">Guru &amp; Pengajar</span>
      <h3>{{ $totalGuru }}</h3>
      <span class="metric-note"><i class="fa-solid fa-circle-check"></i> {{ $activeTeachers }} aktif unggah konten</span>
    </div>
    <i class="fa-solid fa-chalkboard-user metric-ghost" aria-hidden="true"></i>
  </a>

  <div class="metric-card metric-card--emerald">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-user-group"></i></div>
    <div class="metric-info">
      <span class="metric-label">Peserta Didik Aktif</span>
      <h3>{{ $totalSiswa }}</h3>
      <span class="metric-note"><i class="fa-solid fa-graduation-cap"></i> Siswa terdaftar</span>
    </div>
    <i class="fa-solid fa-user-group metric-ghost" aria-hidden="true"></i>
  </div>

  <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'video']) }}" class="metric-card metric-card--rose">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-circle-play"></i></div>
    <div class="metric-info">
      <span class="metric-label">Video Pembelajaran</span>
      <h3>{{ $totalVideo }}</h3>
      <span class="metric-note"><i class="fa-solid fa-film"></i> Media video edukasi</span>
    </div>
    <i class="fa-solid fa-circle-play metric-ghost" aria-hidden="true"></i>
  </a>

  <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'materi']) }}" class="metric-card metric-card--cyan">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-book"></i></div>
    <div class="metric-info">
      <span class="metric-label">Modul Bahan Ajar</span>
      <h3>{{ $totalMateri }}</h3>
      <span class="metric-note"><i class="fa-solid fa-folder-open"></i> Materi digital guru</span>
    </div>
    <i class="fa-solid fa-book metric-ghost" aria-hidden="true"></i>
  </a>

  <a href="{{ route('kepsek.monitoring.ppdb') }}" class="metric-card metric-card--amber">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-user-plus"></i></div>
    <div class="metric-info">
      <span class="metric-label">Pendaftar PPDB</span>
      <h3>{{ $totalPpdb }}</h3>
      <span class="metric-note"><i class="fa-solid fa-hourglass-half"></i> {{ $totalPpdbPending }} menunggu verifikasi</span>
    </div>
    <i class="fa-solid fa-user-plus metric-ghost" aria-hidden="true"></i>
  </a>
</div>

<!-- 2. Teacher Performance & PPDB Recap -->
<div class="content-grid-2">
  <!-- Left Column: Kinerja Keaktifan Guru Pengajar -->
  <div class="box-card">
    <div class="box-card-header">
      <div class="box-card-title">
        <span class="title-icon title-icon--blue"><i class="fa-solid fa-chart-line"></i></span>
        Kinerja Konten Pembelajaran Guru
      </div>
      <a href="{{ route('kepsek.monitoring.guru') }}" class="box-card-link">
        Lihat Semua Guru <i class="fa-solid fa-chevron-right"></i>
      </a>
    </div>

    <div class="active-rate">
      <div class="active-rate-text">
        <strong>{{ $activeRate }}%</strong>
        <span>guru telah mengunggah materi atau video ({{ $activeTeachers }} dari {{ $totalTeachersListed }})</span>
      </div>
      <div class="active-rate-bar" role="progressbar" aria-valuenow="{{ $activeRate }}" aria-valuemin="0" aria-valuemax="100">
        <span style="width: {{ $activeRate }}%;"></span>
      </div>
    </div>

    <div class="table-wrap">
      <table class="table-clean">
        <thead>
          <tr>
            <th>Guru Pengajar</th>
            <th>NIP</th>
            <th>Mata Pelajaran</th>
            <th class="text-center">Materi</th>
            <th class="text-center">Video</th>
            <th>Status</th>
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
            <td><code class="code-pill">{{ $t->nip ?? '-' }}</code></td>
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
          </tr>
          @empty
          <tr>
            <td colspan="6">
              <div class="empty-state">
                <i class="fa-solid fa-chalkboard-user"></i>
                <p>Belum ada data guru terdaftar.</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Right Column: Rekap PPDB -->
  <div class="box-card">
    <div class="box-card-header">
      <div class="box-card-title">
        <span class="title-icon title-icon--amber"><i class="fa-solid fa-id-card-clip"></i></span>
        Rekap Pendaftaran PPDB
      </div>
      <a href="{{ route('kepsek.monitoring.ppdb') }}" class="box-card-link">
        Detail <i class="fa-solid fa-arrow-up-right-from-square"></i>
      </a>
    </div>

    <div class="ppdb-recap">
      <div class="donut" style="background: {{ $donutGradient }};" role="img" aria-label="Komposisi status pendaftar PPDB">
        <div class="donut-hole">
          <strong>{{ $totalPpdb }}</strong>
          <span>Total Pendaftar</span>
        </div>
      </div>

      <ul class="ppdb-legend">
        <li>
          <span class="legend-dot legend-dot--green"></span>
          <span class="legend-label">Diterima</span>
          <strong>{{ $ppdbAccepted }}</strong>
          <em>{{ $acceptedPct }}%</em>
        </li>
        <li>
          <span class="legend-dot legend-dot--amber"></span>
          <span class="legend-label">Menunggu</span>
          <strong>{{ $ppdbPending }}</strong>
          <em>{{ $pendingPct }}%</em>
        </li>
        <li>
          <span class="legend-dot legend-dot--slate"></span>
          <span class="legend-label">Belum Diputuskan</span>
          <strong>{{ $ppdbRest }}</strong>
          <em>{{ $restPct }}%</em>
        </li>
      </ul>
    </div>

    <div class="ppdb-alert">
      <span class="ppdb-alert-icon"><i class="fa-solid fa-bell"></i></span>
      <div>
        <strong>{{ $ppdbPending }} pendaftar</strong> masih menunggu verifikasi berkas.
        <a href="{{ route('kepsek.monitoring.ppdb') }}">Tindak lanjuti</a>
      </div>
    </div>

    <a href="{{ route('kepsek.monitoring.ppdb') }}" class="btn-block">
      <i class="fa-solid fa-list-check"></i> Kelola Pendaftar PPDB
    </a>
  </div>
</div>

<!-- 3. Recent Materials & Videos -->
<div class="content-grid-2 content-grid-2--even">
  <!-- Modul Materi Ajar Terkini -->
  <div class="box-card">
    <div class="box-card-header">
      <div class="box-card-title">
        <span class="title-icon title-icon--cyan"><i class="fa-solid fa-book-bookmark"></i></span>
        Modul Materi Ajar Terkini
      </div>
      <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'materi']) }}" class="box-card-link">
        Lihat Semua <i class="fa-solid fa-chevron-right"></i>
      </a>
    </div>

    <div class="stream-list">
      @forelse($recentMaterials as $m)
      <div class="stream-item">
        <span class="stream-icon stream-icon--cyan"><i class="fa-solid fa-file-lines"></i></span>
        <div class="stream-body">
          <div class="stream-title">{{ $m->title }}</div>
          <div class="stream-meta">{{ $m->subject }} &bull; {{ $m->class_level }}</div>
        </div>
        <span class="badge-tag">{{ $m->file_type }}</span>
      </div>
      @empty
      <div class="empty-state">
        <i class="fa-solid fa-folder-open"></i>
        <p>Belum ada modul bahan ajar diunggah.</p>
      </div>
      @endforelse
    </div>

    <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'materi']) }}" class="btn-block">
      <i class="fa-solid fa-magnifying-glass-chart"></i> Buka Supervisi Modul Ajar
    </a>
  </div>

  <!-- Video Pembelajaran Terbaru -->
  <div class="box-card">
    <div class="box-card-header">
      <div class="box-card-title">
        <span class="title-icon title-icon--rose"><i class="fa-brands fa-youtube"></i></span>
        Video Pembelajaran Terkini
      </div>
      <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'video']) }}" class="box-card-link">
        Semua Video ({{ $totalVideo }}) <i class="fa-solid fa-chevron-right"></i>
      </a>
    </div>

    <div class="stream-list">
      @forelse($recentVideos as $v)
      <div class="stream-item">
        <span class="stream-icon stream-icon--rose"><i class="fa-solid fa-play"></i></span>
        <div class="stream-body">
          <div class="stream-title">{{ $v->title }}</div>
          <div class="stream-meta">
            {{ $v->user->name ?? 'Guru' }} &bull; {{ $v->class_level }} &bull; {{ $v->subject }}
          </div>
        </div>
        <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'video', 'search' => $v->title]) }}" class="stream-action">
          Lihat <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>
      @empty
      <div class="empty-state">
        <i class="fa-solid fa-video"></i>
        <p>Belum ada video pembelajaran yang diunggah.</p>
      </div>
      @endforelse
    </div>
  </div>
</div>

<!-- 4. Latest PPDB Registrations & Announcements -->
<div class="content-grid-2 content-grid-2--even">
  <!-- Pendaftar PPDB Terkini -->
  <div class="box-card">
    <div class="box-card-header">
      <div class="box-card-title">
        <span class="title-icon title-icon--amber"><i class="fa-solid fa-user-graduate"></i></span>
        Calon Siswa Baru (PPDB)
      </div>
      <a href="{{ route('kepsek.monitoring.ppdb') }}" class="box-card-link">
        Lihat Semua ({{ $totalPpdb }}) <i class="fa-solid fa-chevron-right"></i>
      </a>
    </div>

    <div class="stream-list stream-list--compact">
      @forelse($recentPpdb as $p)
      <div class="stream-item">
        <span class="stream-icon stream-icon--indigo"><i class="fa-solid fa-id-card"></i></span>
        <div class="stream-body">
          <div class="stream-title">{{ $p->student_name }}</div>
          <div class="stream-meta"><code>{{ $p->registration_number }}</code> &bull; {{ $p->previous_school ?: 'Asal sekolah -' }}</div>
        </div>
        @if(in_array($p->status, ['diterima', 'accepted'], true))
          <span class="status-chip status-chip--green"><i class="fa-solid fa-check"></i> Diterima</span>
        @elseif(in_array($p->status, ['ditolak', 'rejected'], true))
          <span class="status-chip status-chip--red"><i class="fa-solid fa-xmark"></i> Ditolak</span>
        @else
          <span class="status-chip status-chip--amber"><i class="fa-solid fa-hourglass-half"></i> Menunggu</span>
        @endif
      </div>
      @empty
      <div class="empty-state">
        <i class="fa-solid fa-user-plus"></i>
        <p>Belum ada calon peserta didik mendaftar.</p>
      </div>
      @endforelse
    </div>
  </div>

  <!-- Pengumuman Sekolah -->
  <div class="box-card">
    <div class="box-card-header">
      <div class="box-card-title">
        <span class="title-icon title-icon--violet"><i class="fa-solid fa-bullhorn"></i></span>
        Pengumuman Sekolah
      </div>
      <span class="badge-tag">{{ $announcements->count() }} aktif</span>
    </div>

    <div class="stream-list stream-list--compact">
      @forelse($announcements as $announcement)
      <div class="stream-item">
        <span class="stream-icon stream-icon--violet"><i class="fa-solid fa-bullhorn"></i></span>
        <div class="stream-body">
          <div class="stream-title">{{ $announcement->title }}</div>
          <div class="stream-meta">
            <i class="fa-regular fa-calendar"></i>
            {{ optional($announcement->published_at)->locale('id')->translatedFormat('d F Y') ?? 'Tanpa tanggal' }}
          </div>
        </div>
      </div>
      @empty
      <div class="empty-state">
        <i class="fa-solid fa-inbox"></i>
        <p>Belum ada pengumuman yang dipublikasikan.</p>
      </div>
      @endforelse
    </div>
  </div>
</div>
@endsection
