@extends('layouts.kepsek')

@section('title', 'Monitoring Guru & Tenaga Pendidik - Kepala Sekolah')
@section('page-title', 'Monitoring Guru & Kinerja Pengajaran')

@section('content')
<style>
  .metric-mini-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
  }
  .metric-mini-card {
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .metric-mini-card .icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
  }
  .metric-mini-card h4 {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--text-dark);
    line-height: 1.1;
  }
  .metric-mini-card span {
    font-size: 0.78rem;
    color: var(--text-muted);
    font-weight: 600;
  }

  .box-card {
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
  }

  .table-custom {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.88rem;
  }
  .table-custom th {
    background: #f8fafc;
    padding: 12px 14px;
    text-align: left;
    font-weight: 700;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
  }
  .table-custom td {
    padding: 14px;
    border-bottom: 1px solid #f1f5f9;
  }
  .table-custom tr:hover td {
    background: #f8fafc;
  }

  .badge-tag {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 700;
  }
</style>

<!-- Mini Stats Overview -->
<div class="metric-mini-grid">
  <div class="metric-mini-card">
    <div class="icon" style="background: #eff6ff; color: #2563eb;">
      <i class="fa-solid fa-chalkboard-user"></i>
    </div>
    <div>
      <h4>{{ $totalTeachers }}</h4>
      <span>Total Guru Terdaftar</span>
    </div>
  </div>

  <div class="metric-mini-card">
    <div class="icon" style="background: #f0fdf4; color: #16a34a;">
      <i class="fa-solid fa-book"></i>
    </div>
    <div>
      <h4>{{ $totalMaterialsUploaded }}</h4>
      <span>Modul Materi Disediakan</span>
    </div>
  </div>

  <div class="metric-mini-card">
    <div class="icon" style="background: #fef2f2; color: #dc2626;">
      <i class="fa-solid fa-circle-play"></i>
    </div>
    <div>
      <h4>{{ $totalVideosUploaded }}</h4>
      <span>Video Edukasi Diunggah</span>
    </div>
  </div>
</div>

<!-- Main Table Card -->
<div class="box-card">
  <!-- Filter & Search Toolbar -->
  <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-bottom: 22px;">
    <div>
      <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text-dark);">Daftar Kinerja & Aktivitas Tenaga Pendidik</h3>
      <p style="font-size: 0.82rem; color: var(--text-muted); margin-top: 2px;">
        Evaluasi pemanfaatan media digital oleh dewan guru untuk kegiatan belajar mengajar peserta didik.
      </p>
    </div>

    <form method="GET" action="{{ route('kepsek.monitoring.guru') }}" style="display: flex; gap: 8px;">
      <div style="position: relative;">
        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama / NIP / mapel..." style="padding: 9px 14px 9px 34px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.85rem; outline: none; width: 240px;">
      </div>
      <button type="submit" style="background: var(--primary); color: #ffffff; border: none; padding: 9px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; cursor: pointer;">
        Cari
      </button>
      @if($search)
      <a href="{{ route('kepsek.monitoring.guru') }}" style="background: #e2e8f0; color: #475569; padding: 9px 12px; border-radius: 8px; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
        Reset
      </a>
      @endif
    </form>
  </div>

  <div style="overflow-x: auto;">
    <table class="table-custom">
      <thead>
        <tr>
          <th style="width: 50px;">No</th>
          <th>Nama Guru & Gelar</th>
          <th>NIP</th>
          <th>Mata Pelajaran</th>
          <th style="text-align: center;">Modul Materi</th>
          <th style="text-align: center;">Video Edukasi</th>
          <th>Status Keaktifan</th>
          <th style="text-align: right;">Aksi Supervisi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($teachers as $index => $t)
        <tr>
          <td style="color: var(--text-muted); font-weight: 700;">{{ $index + 1 }}</td>
          <td>
            <div style="font-weight: 700; color: #0f172a; font-size: 0.92rem;">{{ $t->name }}</div>
            <div style="font-size: 0.76rem; color: #64748b;"><i class="fa-solid fa-envelope" style="font-size: 0.7rem;"></i> {{ $t->email }}</div>
          </td>
          <td><code>{{ $t->nip ?? 'Belum Diisi' }}</code></td>
          <td>
            <span class="badge-tag" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
              <i class="fa-solid fa-book-bookmark"></i> {{ $t->subject ?? 'Guru Kelas' }}
            </span>
          </td>
          <td style="text-align: center; font-weight: 800; font-size: 1rem; color: #0284c7;">
            {{ $t->materials_count }}
          </td>
          <td style="text-align: center; font-weight: 800; font-size: 1rem; color: #dc2626;">
            {{ $t->videos_count }}
          </td>
          <td>
            @if($t->materials_count > 0 || $t->videos_count > 0)
              <span class="badge-tag" style="background: #ecfdf5; color: #059669; border: 1px solid #bbf7d0;">
                <i class="fa-solid fa-circle-check"></i> Aktif Berkontribusi
              </span>
            @else
              <span class="badge-tag" style="background: #fefce8; color: #a16207; border: 1px solid #fef08a;">
                <i class="fa-solid fa-triangle-exclamation"></i> Belum Ada Konten
              </span>
            @endif
          </td>
          <td style="text-align: right;">
            <a href="{{ route('kepsek.monitoring.pembelajaran', ['search' => $t->name]) }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 8px; background: #f1f5f9; color: #1e293b; font-size: 0.8rem; font-weight: 700; text-decoration: none; border: 1px solid var(--border);">
              <i class="fa-solid fa-eye"></i> Periksa Konten
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" style="text-align: center; padding: 30px; color: #94a3b8;">
            Tidak ditemukan data guru yang sesuai dengan pencarian "{{ $search }}".
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
