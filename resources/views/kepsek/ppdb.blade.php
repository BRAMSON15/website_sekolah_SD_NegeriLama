@extends('layouts.kepsek')

@section('title', 'Monitoring PPDB Online - Kepala Sekolah')
@section('page-title', 'Monitoring PPDB Online')

@section('content')
@php
    $pct = fn ($n) => $totalAll > 0 ? (int) round($n / $totalAll * 100) : 0;
    $approvedPct = $pct($totalApproved);
    $pendingPct = $pct($totalPending);
    $rejectedPct = $pct($totalRejected);
@endphp

<!-- Hero -->
<section class="exec-hero">
  <div class="exec-hero-glow exec-hero-glow--gold" aria-hidden="true"></div>
  <div class="exec-hero-glow exec-hero-glow--blue" aria-hidden="true"></div>

  <div class="exec-hero-main">
    <span class="exec-hero-chip">
      <i class="fa-solid fa-id-card-clip"></i> Penerimaan Peserta Didik Baru
    </span>
    <h1>Monitoring <span>PPDB Online</span></h1>
    <p>
      Supervisi pendaftaran siswa baru, verifikasi berkas, dan kuota penerimaan
      pada setiap jalur seleksi secara terintegrasi.
    </p>
    <div class="exec-hero-meta">
      <span><i class="fa-regular fa-calendar-days"></i> {{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
      <span><i class="fa-solid fa-users"></i> {{ $totalAll }} pendaftar</span>
      <span class="exec-hero-status"><span class="pulse-dot"></span> {{ $totalPending }} menunggu verifikasi</span>
    </div>
  </div>

  <div class="exec-hero-actions">
    <a href="{{ route('kepsek.monitoring.ppdb', array_merge(request()->query(), ['print' => 1])) }}" target="_blank" class="hero-btn hero-btn--gold">
      <i class="fa-solid fa-print"></i> Cetak Rekap
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
    <div class="metric-icon"><i class="fa-solid fa-users"></i></div>
    <div class="metric-info">
      <span class="metric-label">Total Pendaftar</span>
      <h3>{{ $totalAll }}</h3>
      <span class="metric-note"><i class="fa-solid fa-id-card"></i> Berkas masuk</span>
    </div>
    <i class="fa-solid fa-users metric-ghost" aria-hidden="true"></i>
  </div>

  <div class="metric-card metric-card--amber">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-hourglass-half"></i></div>
    <div class="metric-info">
      <span class="metric-label">Menunggu Verifikasi</span>
      <h3>{{ $totalPending }}</h3>
      <span class="metric-note"><i class="fa-solid fa-clock"></i> {{ $pendingPct }}% dari pendaftar</span>
    </div>
    <i class="fa-solid fa-hourglass-half metric-ghost" aria-hidden="true"></i>
  </div>

  <div class="metric-card metric-card--emerald">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-circle-check"></i></div>
    <div class="metric-info">
      <span class="metric-label">Siswa Diterima</span>
      <h3>{{ $totalApproved }}</h3>
      <span class="metric-note"><i class="fa-solid fa-check-double"></i> {{ $approvedPct }}% diterima</span>
    </div>
    <i class="fa-solid fa-circle-check metric-ghost" aria-hidden="true"></i>
  </div>

  <div class="metric-card metric-card--rose">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-circle-xmark"></i></div>
    <div class="metric-info">
      <span class="metric-label">Tidak Lolos</span>
      <h3>{{ $totalRejected }}</h3>
      <span class="metric-note"><i class="fa-solid fa-xmark"></i> {{ $rejectedPct }}% ditolak</span>
    </div>
    <i class="fa-solid fa-circle-xmark metric-ghost" aria-hidden="true"></i>
  </div>
</div>

<!-- Verification Summary -->
<div class="box-card kp-toolbar">
  <div class="box-card-header" style="margin-bottom:16px;">
    <div class="box-card-title">
      <span class="title-icon title-icon--amber"><i class="fa-solid fa-clipboard-check"></i></span>
      Ringkasan Verifikasi Berkas
    </div>
    <span class="badge-tag">{{ $totalLaki }} laki-laki &bull; {{ $totalPerempuan }} perempuan</span>
  </div>

  <div class="kp-verify-grid">
    <div class="kp-verify-item">
      <div class="kp-verify-top">
        <span>Diterima</span>
        <strong>{{ $totalApproved }}</strong>
      </div>
      <div class="kp-verify-bar kp-verify-bar--green"><span style="width: {{ $approvedPct }}%;"></span></div>
      <div class="kp-verify-note">{{ $approvedPct }}% dari total pendaftar</div>
    </div>

    <div class="kp-verify-item">
      <div class="kp-verify-top">
        <span>Menunggu</span>
        <strong>{{ $totalPending }}</strong>
      </div>
      <div class="kp-verify-bar kp-verify-bar--amber"><span style="width: {{ $pendingPct }}%;"></span></div>
      <div class="kp-verify-note">{{ $pendingPct }}% perlu ditindaklanjuti</div>
    </div>

    <div class="kp-verify-item">
      <div class="kp-verify-top">
        <span>Ditolak</span>
        <strong>{{ $totalRejected }}</strong>
      </div>
      <div class="kp-verify-bar kp-verify-bar--rose"><span style="width: {{ $rejectedPct }}%;"></span></div>
      <div class="kp-verify-note">{{ $rejectedPct }}% tidak lolos seleksi</div>
    </div>
  </div>
</div>

<!-- Filter -->
<div class="box-card kp-toolbar">
  <form action="{{ route('kepsek.monitoring.ppdb') }}" method="GET" class="kp-filter-form">
    <div class="kp-tabs">
      <a href="{{ route('kepsek.monitoring.ppdb', ['status' => 'all', 'track' => $track, 'search' => $search]) }}"
         class="kp-tab {{ $status === 'all' ? 'active' : '' }}">
        Semua <span class="kp-tab-count">{{ $totalAll }}</span>
      </a>
      <a href="{{ route('kepsek.monitoring.ppdb', ['status' => 'menunggu', 'track' => $track, 'search' => $search]) }}"
         class="kp-tab {{ $status === 'menunggu' ? 'active' : '' }}">
        Menunggu <span class="kp-tab-count">{{ $totalPending }}</span>
      </a>
      <a href="{{ route('kepsek.monitoring.ppdb', ['status' => 'diterima', 'track' => $track, 'search' => $search]) }}"
         class="kp-tab {{ $status === 'diterima' ? 'active' : '' }}">
        Diterima <span class="kp-tab-count">{{ $totalApproved }}</span>
      </a>
      <a href="{{ route('kepsek.monitoring.ppdb', ['status' => 'ditolak', 'track' => $track, 'search' => $search]) }}"
         class="kp-tab {{ $status === 'ditolak' ? 'active' : '' }}">
        Ditolak <span class="kp-tab-count">{{ $totalRejected }}</span>
      </a>
    </div>

    <input type="hidden" name="status" value="{{ $status }}">
    <div class="kp-filter-group">
      <select name="track" class="kp-select" onchange="this.form.submit()">
        <option value="all" {{ ($track === 'all') ? 'selected' : '' }}>Semua Jalur</option>
        <option value="Zonasi" {{ ($track === 'Zonasi') ? 'selected' : '' }}>Jalur Zonasi</option>
        <option value="Afirmasi" {{ ($track === 'Afirmasi') ? 'selected' : '' }}>Jalur Afirmasi</option>
        <option value="Perpindahan Tugas Orang Tua" {{ ($track === 'Perpindahan Tugas Orang Tua') ? 'selected' : '' }}>Perpindahan Tugas</option>
        <option value="Prestasi" {{ ($track === 'Prestasi') ? 'selected' : '' }}>Jalur Prestasi</option>
      </select>

      <div class="kp-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, nomor reg, asal TK...">
      </div>

      <button type="submit" class="kp-btn kp-btn--primary">
        <i class="fa-solid fa-filter"></i> Terapkan
      </button>

      @if($search || $track !== 'all' || $status !== 'all')
        <a href="{{ route('kepsek.monitoring.ppdb') }}" class="kp-btn kp-btn--soft" title="Reset filter">
          <i class="fa-solid fa-rotate-left"></i>
        </a>
      @endif
    </div>
  </form>
</div>

<!-- Registrations Table -->
<div class="box-card">
  <div class="box-card-header">
    <div class="box-card-title">
      <span class="title-icon title-icon--cyan"><i class="fa-solid fa-folder-open"></i></span>
      Daftar Berkas Calon Siswa Baru
    </div>
    <span class="badge-tag">{{ $registrations->count() }} pendaftar ditampilkan</span>
  </div>

  @if($registrations->isEmpty())
    <div class="empty-state">
      <i class="fa-solid fa-folder-open"></i>
      <p>Tidak ada data pendaftaran yang sesuai dengan filter saat ini.</p>
    </div>
  @else
    <div class="table-wrap">
      <table class="table-clean">
        <thead>
          <tr>
            <th>No. Registrasi</th>
            <th>Nama Calon Siswa</th>
            <th class="text-center">L/P</th>
            <th>Jalur Pendaftaran</th>
            <th>Asal Sekolah</th>
            <th>Wali / Kontak</th>
            <th class="text-center">Status</th>
            <th class="text-right">Waktu Daftar</th>
          </tr>
        </thead>
        <tbody>
          @foreach($registrations as $reg)
            <tr>
              <td><code class="code-pill">{{ $reg->registration_number }}</code></td>
              <td>
                <div class="teacher-cell">
                  <span class="avatar-initial avatar-initial--{{ ($loop->index % 5) + 1 }}">
                    {{ strtoupper(mb_substr($reg->full_name ?: 'S', 0, 1)) }}
                  </span>
                  <div class="teacher-identity">
                    <div class="teacher-name">{{ $reg->full_name }}</div>
                    <div class="teacher-mail">NISN: {{ $reg->nisn ?: '-' }}</div>
                  </div>
                </div>
              </td>
              <td class="text-center">
                <span class="kp-gender {{ $reg->gender === 'L' ? 'kp-gender--l' : 'kp-gender--p' }}">
                  {{ $reg->gender ?? '-' }}
                </span>
              </td>
              <td><span class="subject-badge">{{ $reg->registration_track ?? 'Zonasi' }}</span></td>
              <td>{{ $reg->previous_school ?: '-' }}</td>
              <td>
                <div class="teacher-name" style="max-width:170px;">{{ $reg->parent_name ?: 'Orang Tua / Wali' }}</div>
                <div class="teacher-mail">{{ $reg->phone ?? '-' }}</div>
              </td>
              <td class="text-center">
                @if(in_array($reg->status, ['diterima', 'accepted', 'approved'], true))
                  <span class="status-chip status-chip--green"><i class="fa-solid fa-check"></i> Diterima</span>
                @elseif(in_array($reg->status, ['ditolak', 'rejected'], true))
                  <span class="status-chip status-chip--red"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                @else
                  <span class="status-chip status-chip--amber"><i class="fa-solid fa-clock"></i> Menunggu</span>
                @endif
              </td>
              <td class="text-right">
                <span class="teacher-mail">{{ $reg->created_at->format('d/m/Y') }}</span>
                <div class="teacher-mail">{{ $reg->created_at->format('H:i') }} WIT</div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
