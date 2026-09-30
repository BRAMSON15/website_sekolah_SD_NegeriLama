@extends('layouts.kepsek')

@section('title', 'Dashboard Monitoring Eksekutif - Kepala Sekolah')
@section('page-title', 'Dashboard Monitoring Eksekutif')

@section('content')
<style>
  .metric-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px;
    margin-bottom: 26px;
  }
  .metric-card {
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform 0.2s, box-shadow 0.2s;
  }
  .metric-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
  }
  .metric-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
  }
  .metric-info h3 {
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--text-dark);
    line-height: 1.1;
  }
  .metric-info span {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 600;
  }

  .content-grid-2 {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 24px;
    margin-bottom: 26px;
  }
  @media (max-width: 1024px) {
    .content-grid-2 {
      grid-template-columns: 1fr;
    }
  }

  .box-card {
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
  }
  .box-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border);
  }
  .box-card-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .box-card-link {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--primary-light);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .box-card-link:hover {
    text-decoration: underline;
  }

  .table-clean {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.86rem;
  }
  .table-clean th {
    text-align: left;
    padding: 10px 12px;
    background: #f8fafc;
    color: var(--text-muted);
    font-weight: 700;
    border-bottom: 1px solid var(--border);
  }
  .table-clean td {
    padding: 12px;
    border-bottom: 1px solid #f1f5f9;
    color: var(--text-dark);
  }
  .table-clean tr:hover td {
    background: #f8fafc;
  }

  .badge-tag {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 0.74rem;
    font-weight: 700;
  }
</style>

<!-- Welcome Principal Banner -->
<div style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); border-radius: 16px; padding: 26px 30px; color: #ffffff; margin-bottom: 26px; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
  <div>
    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(245, 158, 11, 0.2); border: 1px solid rgba(245, 158, 11, 0.4); color: #fcd34d; font-size: 0.75rem; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
      <i class="fa-solid fa-crown"></i> Panel Supervisi Kepala Sekolah
    </div>
    <h1 style="font-size: 1.55rem; font-weight: 800; margin-bottom: 6px; letter-spacing: -0.3px;">
      Selamat Datang, {{ $user->name }}
    </h1>
    <p style="font-size: 0.88rem; color: #cbd5e1; max-width: 650px; line-height: 1.5;">
      Pantau seluruh aktivitas akademik, kinerja materi & video guru, kalender pendidikan, serta pendaftaran PPDB secara terintegrasi dan akurat.
    </p>
  </div>
  <div style="display: flex; gap: 10px; flex-wrap: wrap;">
    <a href="{{ route('kepsek.monitoring.kalender') }}" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); color: #ffffff; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.85rem; text-decoration: none; backdrop-filter: blur(4px);">
      <i class="fa-solid fa-calendar-days"></i> Kalender Pendidikan
    </a>
    <a href="{{ route('kepsek.monitoring.ppdb', ['print' => 1]) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; background: #d97706; color: #ffffff; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.85rem; text-decoration: none; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);">
      <i class="fa-solid fa-file-pdf"></i> Laporan PPDB
    </a>
  </div>
</div>

<!-- 1. Executive Summary Metric Cards -->
<div class="metric-grid">
  <!-- Card 1: Total Guru -->
  <div class="metric-card">
    <div class="metric-icon" style="background: #eff6ff; color: #2563eb;">
      <i class="fa-solid fa-chalkboard-user"></i>
    </div>
    <div class="metric-info">
      <h3>{{ $totalGuru }}</h3>
      <span>Guru & Pengajar</span>
    </div>
  </div>

  <!-- Card 2: Total Siswa Aktif -->
  <div class="metric-card">
    <div class="metric-icon" style="background: #f0fdf4; color: #16a34a;">
      <i class="fa-solid fa-user-group"></i>
    </div>
    <div class="metric-info">
      <h3>{{ $totalSiswa }}</h3>
      <span>Peserta Didik Aktif</span>
    </div>
  </div>

  <!-- Card 3: Video Edukasi Guru -->
  <div class="metric-card">
    <div class="metric-icon" style="background: #fef2f2; color: #dc2626;">
      <i class="fa-solid fa-circle-play"></i>
    </div>
    <div class="metric-info">
      <h3>{{ $totalVideo }}</h3>
      <span>Video Pembelajaran</span>
    </div>
  </div>

  <!-- Card 4: Modul Materi Digital -->
  <div class="metric-card">
    <div class="metric-icon" style="background: #f0f9ff; color: #0284c7;">
      <i class="fa-solid fa-book"></i>
    </div>
    <div class="metric-info">
      <h3>{{ $totalMateri }}</h3>
      <span>Modul Bahan Ajar</span>
    </div>
  </div>

  <!-- Card 5: Pendaftar PPDB Online -->
  <div class="metric-card">
    <div class="metric-icon" style="background: #fefce8; color: #ca8a04;">
      <i class="fa-solid fa-user-plus"></i>
    </div>
    <div class="metric-info">
      <h3>{{ $totalPpdb }}</h3>
      <span>Pendaftar PPDB Baru</span>
    </div>
  </div>
</div>

<!-- 2. Dual Column Content Area -->
<div class="content-grid-2">
  <!-- Left Column: Kinerja Keaktifan Guru Pengajar -->
  <div class="box-card">
    <div class="box-card-header">
      <div class="box-card-title">
        <i class="fa-solid fa-chart-line" style="color: #2563eb;"></i> Kinerja Konten Pembelajaran Guru
      </div>
      <a href="{{ route('kepsek.monitoring.guru') }}" class="box-card-link">
        Lihat Semua Guru <i class="fa-solid fa-chevron-right"></i>
      </a>
    </div>

    <div style="overflow-x: auto;">
      <table class="table-clean">
        <thead>
          <tr>
            <th>Guru Pengajar</th>
            <th>NIP</th>
            <th>Mata Pelajaran</th>
            <th style="text-align: center;">Materi</th>
            <th style="text-align: center;">Video</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($teachers as $t)
          <tr>
            <td>
              <div style="font-weight: 700; color: #1e293b;">{{ $t->name }}</div>
              <div style="font-size: 0.74rem; color: #64748b;">{{ $t->email }}</div>
            </td>
            <td><code>{{ $t->nip ?? '-' }}</code></td>
            <td><span class="badge-tag" style="background: #eff6ff; color: #1d4ed8;">{{ $t->subject ?? 'Guru Kelas' }}</span></td>
            <td style="text-align: center; font-weight: 700;">{{ $t->materials_count }}</td>
            <td style="text-align: center; font-weight: 700; color: #dc2626;">{{ $t->videos_count }}</td>
            <td>
              @if($t->materials_count > 0 || $t->videos_count > 0)
                <span class="badge-tag" style="background: #ecfdf5; color: #059669;"><i class="fa-solid fa-check"></i> Aktif Unggah</span>
              @else
                <span class="badge-tag" style="background: #fef2f2; color: #dc2626;"><i class="fa-solid fa-clock"></i> Belum Mengunggah</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada data guru terdaftar.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Right Column: Modul Materi Pembelajaran Terkini -->
  <div class="box-card">
    <div class="box-card-header">
      <div class="box-card-title">
        <i class="fa-solid fa-book-bookmark" style="color: #0284c7;"></i> Modul Materi Ajar Terkini
      </div>
      <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'materi']) }}" class="box-card-link">
        Lihat Semua <i class="fa-solid fa-chevron-right"></i>
      </a>
    </div>

    <div style="display: flex; flex-direction: column; gap: 12px;">
      @forelse($recentMaterials as $m)
      <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 12px; background: #f8fafc; border: 1px solid var(--border); border-radius: 10px;">
        <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
          <div style="width: 38px; height: 38px; border-radius: 8px; background: #f0f9ff; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
            <i class="fa-solid fa-file-lines"></i>
          </div>
          <div style="min-width: 0;">
            <div style="font-weight: 700; color: #1e293b; font-size: 0.88rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $m->title }}</div>
            <div style="font-size: 0.74rem; color: #64748b;">
              {{ $m->subject }} &bull; {{ $m->class_level }}
            </div>
          </div>
        </div>
        <span class="badge-tag" style="background: #f1f5f9; color: #475569; white-space: nowrap;">{{ $m->file_type }}</span>
      </div>
      @empty
      <div style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada modul bahan ajar diunggah.</div>
      @endforelse
    </div>

    <div style="margin-top: 18px;">
      <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'materi']) }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 10px; border-radius: 10px; background: #0f172a; color: #ffffff; font-size: 0.85rem; font-weight: 700; text-decoration: none;">
        <i class="fa-solid fa-magnifying-glass-chart"></i> Buka Supervisi Modul Ajar
      </a>
    </div>
  </div>
</div>

<!-- 3. Bottom Grid: Video Terbaru & Pendaftar PPDB Terbaru -->
<div class="content-grid-2">
  <!-- Video Pembelajaran Terbaru -->
  <div class="box-card">
    <div class="box-card-header">
      <div class="box-card-title">
        <i class="fa-brands fa-youtube" style="color: #dc2626;"></i> Video Pembelajaran Terkini
      </div>
      <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'video']) }}" class="box-card-link">
        Semua Video ({{ $totalVideo }}) <i class="fa-solid fa-chevron-right"></i>
      </a>
    </div>

    <div style="display: flex; flex-direction: column; gap: 12px;">
      @forelse($recentVideos as $v)
      <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 12px; background: #f8fafc; border: 1px solid var(--border); border-radius: 10px;">
        <div style="display: flex; align-items: center; gap: 12px; min-width: 0;">
          <div style="width: 40px; height: 40px; border-radius: 8px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
            <i class="fa-solid fa-play"></i>
          </div>
          <div style="min-width: 0;">
            <div style="font-weight: 700; color: #1e293b; font-size: 0.88rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $v->title }}</div>
            <div style="font-size: 0.74rem; color: #64748b;">
              Oleh: <strong>{{ $v->user->name ?? 'Guru' }}</strong> &bull; Kelas: {{ $v->class_level }} &bull; {{ $v->subject }}
            </div>
          </div>
        </div>
        <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'video', 'search' => $v->title]) }}" style="padding: 6px 12px; border-radius: 8px; background: #ffffff; border: 1px solid #cbd5e1; font-size: 0.75rem; font-weight: 700; color: #1e293b; text-decoration: none; white-space: nowrap;">
          Lihat Video
        </a>
      </div>
      @empty
      <div style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada video pembelajaran yang diunggah.</div>
      @endforelse
    </div>
  </div>

  <!-- Pendaftar PPDB Terkini -->
  <div class="box-card">
    <div class="box-card-header">
      <div class="box-card-title">
        <i class="fa-solid fa-id-card-clip" style="color: #ca8a04;"></i> Calon Siswa Baru (PPDB)
      </div>
      <a href="{{ route('kepsek.monitoring.ppdb') }}" class="box-card-link">
        Lihat Semua ({{ $totalPpdb }}) <i class="fa-solid fa-chevron-right"></i>
      </a>
    </div>

    <div style="display: flex; flex-direction: column; gap: 10px;">
      @forelse($recentPpdb as $p)
      <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 10px 12px; background: #f8fafc; border: 1px solid var(--border); border-radius: 10px;">
        <div style="min-width: 0;">
          <div style="font-weight: 700; color: #1e293b; font-size: 0.88rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p->full_name }}</div>
          <div style="font-size: 0.74rem; color: #64748b;">No: <code>{{ $p->registration_number }}</code> &bull; Asal: {{ $p->previous_school ?: '-' }}</div>
        </div>
        <div>
          @if($p->status === 'diterima')
            <span class="badge-tag" style="background: #ecfdf5; color: #059669;">Diterima</span>
          @elseif($p->status === 'ditolak')
            <span class="badge-tag" style="background: #fef2f2; color: #dc2626;">Ditolak</span>
          @else
            <span class="badge-tag" style="background: #fefce8; color: #ca8a04;">Menunggu</span>
          @endif
        </div>
      </div>
      @empty
      <div style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada calon peserta didik mendaftar.</div>
      @endforelse
    </div>
  </div>
</div>
@endsection
