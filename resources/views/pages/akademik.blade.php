@extends('layouts.app')

@section('title', 'Akademik & Pembelajaran Siswa - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<!-- PAGE HEADER -->
<div class="page-header" style="background-image: linear-gradient(rgba(15, 23, 42, 0.58), rgba(30, 64, 175, 0.58)), url('{{ asset('mentahan2/img/image1.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
  <style>
    .page-header {
      padding: 60px 6% !important;
      text-align: center;
    }
    .page-header h1 {
      font-size: 2.5rem !important;
      font-weight: 800 !important;
      margin-bottom: 10px !important;
      color: #ffffff !important;
      text-shadow: 0 2px 8px rgba(15, 23, 42, 0.55) !important;
    }
    .page-header p {
      font-size: 1.1rem !important;
      color: #eff0f0 !important;
      opacity: 0.95 !important;
      text-shadow: 0 1px 4px rgba(15, 23, 42, 0.55) !important;
    }
    @media (max-width: 768px) {
      .page-header { padding: 48px 5% !important; }
      .page-header h1 { font-size: 2rem !important; }
      .page-header p { font-size: 0.95rem !important; }
    }
    @media (max-width: 576px) {
      .page-header { padding: 36px 4% !important; }
      .page-header h1 { font-size: 1.8rem !important; margin-bottom: 6px !important; }
      .page-header p { font-size: 0.8rem !important; }
    }
    @media (max-width: 380px) {
      .page-header { padding: 28px 3% !important; }
      .page-header h1 { font-size: 1.4rem !important; }
      .page-header p { font-size: 0.72rem !important; }
    }
  </style>
  <h1>Akademik & Pembelajaran Siswa</h1>
  <p>Pusat media video edukasi interaktif, modul materi pembelajaran digital, serta kurikulum sekolah</p>
</div>

<div class="page-content" style="max-width: 1200px; margin: 0 auto; padding: 60px 6%;">
  <style>
    .page-content {
      padding: 60px 6% !important;
      max-width: 1200px !important;
      margin: 0 auto !important;
    }
    @media (max-width: 768px) {
      .page-content { padding: 48px 5% !important; }
    }
    @media (max-width: 576px) {
      .page-content { padding: 36px 4% !important; }
    }
    @media (max-width: 380px) {
      .page-content { padding: 28px 3% !important; }
    }
  </style>

  <!-- ============================================================== -->
  <!-- 1. PUSAT VIDEO & MATERI PEMBELAJARAN DIGITAL                   -->
  <!-- ============================================================== -->
  @guest
  <!-- PEMBERITAHUAN MEDIA PEMBELAJARAN DIGITAL (KHUSUS SISWA TERDAFTAR) -->
  <div class="card-box" style="margin-bottom: 35px; padding: 40px 30px; border-radius: 18px; background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%); border: 1.5px solid #bfdbfe; box-shadow: 0 10px 30px rgba(37, 99, 235, 0.05); text-align: center;">
    <style>
      @media (max-width: 768px) {
        .card-box { padding: 28px 20px !important; margin-bottom: 28px !important; }
      }
      @media (max-width: 576px) {
        .card-box { padding: 20px 14px !important; margin-bottom: 20px !important; }
      }
      @media (max-width: 380px) {
        .card-box { padding: 14px 10px !important; margin-bottom: 16px !important; }
      }
    </style>
    <div style="width: 64px; height: 64px; background: #dbeafe; color: var(--primary); border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 16px;">
      <style>
        @media (max-width: 576px) {
          .icon-badge { width: 56px !important; height: 56px !important; font-size: 1.8rem !important; margin-bottom: 12px !important; }
        }
        @media (max-width: 380px) {
          .icon-badge { width: 48px !important; height: 48px !important; font-size: 1.4rem !important; }
        }
      </style>
      <i class="fa-solid fa-graduation-cap"></i>
    </div>
    <h2 style="font-size: 1.6rem; font-weight: 800; color: var(--dark); margin: 0 0 10px 0;">
      <style>
        @media (max-width: 576px) {
          .card-box h2 { font-size: 1.3rem !important; margin-bottom: 8px !important; }
        }
        @media (max-width: 380px) {
          .card-box h2 { font-size: 1.05rem !important; margin-bottom: 6px !important; }
        }
      </style>
      Media Video Edukasi & Modul Pembelajaran Khusus Siswa
    </h2>
    <p style="color: var(--muted); font-size: 0.98rem; max-width: 650px; margin: 0 auto 24px; line-height: 1.6;">
      <style>
        @media (max-width: 576px) {
          .card-box p { font-size: 0.88rem !important; margin-bottom: 16px !important; }
        }
        @media (max-width: 380px) {
          .card-box p { font-size: 0.80rem !important; margin-bottom: 12px !important; }
        }
      </style>
      Video pembelajaran interaktif dan file bahan ajar bapak/ibu guru dilindungi dan dapat diakses oleh <strong>peserta didik terdaftar</strong> melalui Portal Belajar Siswa.
    </p>
    <!-- Form Input NISN Siswa Terdaftar -->
    <form action="{{ route('siswa.akses.nisn') }}" method="POST" style="max-width: 540px; margin: 0 auto 16px;">
      <style>
        @media (max-width: 576px) {
          .nisn-form { max-width: 100% !important; }
          .nisn-form-flex { gap: 8px !important; flex-direction: column; }
          .nisn-input-wrap { min-width: auto !important; }
          .nisn-input { padding: 11px 16px 11px 40px !important; font-size: 0.90rem !important; }
          .nisn-button { padding: 11px 18px !important; font-size: 0.88rem !important; width: 100%; }
        }
        @media (max-width: 380px) {
          .nisn-input { padding: 10px 14px 10px 36px !important; font-size: 0.80rem !important; }
          .nisn-button { padding: 10px 14px !important; font-size: 0.80rem !important; }
        }
      </style>
      @csrf
      <div class="nisn-form-flex" style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: center;">
        <div class="nisn-input-wrap" style="flex: 1; min-width: 250px; position: relative;">
          <i class="fa-solid fa-id-badge" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #3b82f6; font-size: 1.15rem;"></i>
          <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="Masukkan Nomor NISN Terdaftar..." required autofocus class="nisn-input" style="width: 100%; box-sizing: border-box; padding: 13px 18px 13px 46px; border: 2px solid #bfdbfe; border-radius: 12px; font-size: 0.95rem; font-family: inherit; outline: none; background: #ffffff; color: #1e293b; font-weight: 600; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.08); transition: border-color 0.2s;">
        </div>
        <button type="submit" class="nisn-button btn-login" style="padding: 13px 24px; font-size: 0.95rem; border-radius: 12px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.28);">
          <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Ruang Belajar
        </button>
      </div>

      @if(session('error_nisn'))
      <div style="margin-top: 14px; background: #fef2f2; border: 1.5px solid #fecaca; color: #b91c1c; padding: 10px 18px; border-radius: 10px; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 8px; text-align: left;">
        <style>
          @media (max-width: 576px) {
            .error-msg { padding: 8px 12px !important; font-size: 0.78rem !important; }
          }
        </style>
        <i class="fa-solid fa-circle-exclamation" style="font-size: 1.1rem; color: #ef4444; flex-shrink: 0;"></i>
        <span>{{ session('error_nisn') }}</span>
      </div>
      @endif

      <div style="margin-top: 12px; font-size: 0.82rem; color: #64748b;">
        <style>
          @media (max-width: 576px) {
            .info-msg { font-size: 0.72rem !important; }
          }
        </style>
        <i class="fa-solid fa-circle-info" style="color: #3b82f6; margin-right: 4px;"></i>
        Akses khusus peserta didik aktif SD Negeri Negeri Lama. (Contoh NISN: <code>009123401</code>)
      </div>
    </form>

    <div style="margin-top: 8px;">
      <a href="{{ route('kontak') }}" style="background: transparent; color: var(--muted); padding: 6px 14px; border-radius: 8px; font-size: 0.82rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
        <i class="fa-solid fa-circle-question"></i> Belum tahu nomor NISN Anda? Hubungi Guru / Sekolah
      </a>
    </div>
  </div>
  @else
  <div class="card-box" style="margin-bottom: 35px; padding: 30px; border-radius: 18px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04); border: 1px solid var(--border);">
    <style>
      .auth-card { margin-bottom: 35px !important; padding: 30px !important; }
      .auth-info-banner { padding: 12px 20px !important; margin-bottom: 24px !important; gap: 10px !important; }
      .auth-info-banner span { font-size: 0.90rem !important; }
      .auth-info-banner a { font-size: 0.88rem !important; gap: 6px !important; }
      .auth-header { gap: 16px !important; margin-bottom: 24px !important; }
      .auth-badge { padding: 4px 14px !important; font-size: 0.80rem !important; margin-bottom: 8px !important; }
      .auth-title { font-size: 1.65rem !important; margin-bottom: 6px !important; }
      .auth-subtitle { font-size: 0.95rem !important; }
      .total-badge { padding: 10px 18px !important; gap: 12px !important; }
      .total-badge i { font-size: 1.5rem !important; }
      .badge-label { font-size: 0.75rem !important; }
      .badge-count { font-size: 1.25rem !important; }
      @media (max-width: 768px) {
        .auth-card { padding: 22px !important; margin-bottom: 28px !important; }
        .auth-info-banner { padding: 10px 14px !important; margin-bottom: 18px !important; }
        .auth-info-banner span { font-size: 0.80rem !important; }
        .auth-header { margin-bottom: 18px !important; }
        .auth-title { font-size: 1.35rem !important; }
        .total-badge { padding: 8px 14px !important; }
      }
      @media (max-width: 576px) {
        .auth-card { padding: 16px !important; margin-bottom: 20px !important; }
        .auth-info-banner { padding: 8px 12px !important; margin-bottom: 14px !important; flex-direction: column !important; }
        .auth-info-banner span { font-size: 0.75rem !important; }
        .auth-info-banner a { font-size: 0.75rem !important; width: 100%; justify-content: center; }
        .auth-title { font-size: 1.1rem !important; margin-bottom: 4px !important; }
        .auth-subtitle { font-size: 0.85rem !important; }
        .total-badge { padding: 6px 10px !important; gap: 8px !important; }
        .badge-label { font-size: 0.65rem !important; }
        .badge-count { font-size: 1rem !important; }
      }
      @media (max-width: 380px) {
        .auth-card { padding: 12px !important; }
        .auth-info-banner span { font-size: 0.70rem !important; }
        .auth-title { font-size: 0.95rem !important; }
        .auth-subtitle { font-size: 0.78rem !important; }
        .badge-count { font-size: 0.90rem !important; }
      }
    </style>
    <div class="auth-info-banner" style="background: #eff6ff; border: 1px solid #bfdbfe; padding: 12px 20px; border-radius: 10px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <span style="font-size: 0.9rem; color: #1e40af;"><i class="fa-solid fa-circle-check" style="color: #2563eb;"></i> Anda sedang masuk sebagai <strong>{{ Auth::user()->name }}</strong>.</span>
      <a href="{{ route('siswa.beranda') }}" style="font-weight: 700; font-size: 0.88rem; color: #2563eb; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
        Buka Tampilan Ruang Belajar <i class="fa-solid fa-arrow-right"></i>
      </a>
    </div>
    <div class="auth-header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 2px solid var(--light-bg);">
      <div>
        <div class="auth-badge" style="display: inline-flex; align-items: center; gap: 8px; background: #e0f2fe; color: #0284c7; padding: 4px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; margin-bottom: 8px;">
          <i class="fa-solid fa-graduation-cap"></i> Media Pembelajaran Digital
        </div>
        <h2 class="auth-title" style="font-size: 1.65rem; font-weight: 800; color: var(--dark); margin: 0 0 6px 0;">
          Koleksi Video Edukasi & File Materi Pembelajaran
        </h2>
        <p class="auth-subtitle" style="color: var(--muted); margin: 0; font-size: 0.95rem; line-height: 1.6;">
          Disediakan oleh bapak/ibu guru untuk mempermudah siswa belajar mandiri di rumah maupun di kelas.
        </p>
      </div>

      <!-- Quick Total Count Badge -->
      <div class="total-badge" style="background: var(--light-bg); padding: 10px 18px; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
        <i class="fa-solid fa-layer-group" style="font-size: 1.5rem; color: var(--primary);"></i>
        <div>
          <div class="badge-label" style="font-size: 0.75rem; color: var(--muted); font-weight: 700; text-transform: uppercase;">Total Tersedia</div>
          <div class="badge-count" style="font-size: 1.25rem; font-weight: 800; color: var(--dark);">{{ $totalCombinedCount }} Konten</div>
        </div>
      </div>
    </div>

    <!-- FILTER BAR: TABS & SEARCH FORM -->
    <div style="background: var(--light-bg); padding: 20px; border-radius: 14px; margin-bottom: 30px;">
      <style>
        .filter-bar { padding: 20px !important; margin-bottom: 30px !important; }
        .filter-tabs { gap: 10px !important; margin-bottom: 18px !important; }
        .filter-tab { padding: 10px 18px !important; font-size: 0.88rem !important; }
        .filter-controls { gap: 12px !important; }
        .class-select { min-width: 170px !important; padding: 10px 14px !important; font-size: 0.9rem !important; }
        .search-input-wrap { min-width: 220px !important; }
        .search-input { padding: 10px 14px 10px 38px !important; font-size: 0.9rem !important; }
        .filter-btn { padding: 10px 20px !important; font-size: 0.9rem !important; }
        .reset-btn { padding: 10px 16px !important; font-size: 0.85rem !important; }
        @media (max-width: 768px) {
          .filter-bar { padding: 14px !important; margin-bottom: 22px !important; }
          .filter-tabs { margin-bottom: 12px !important; }
          .filter-tab { padding: 8px 14px !important; font-size: 0.80rem !important; gap: 6px !important; }
          .filter-controls { flex-direction: column; }
          .class-select { min-width: auto !important; width: 100%; }
          .search-input-wrap { width: 100%; }
          .filter-btn { width: 100%; }
          .reset-btn { width: 100%; }
        }
        @media (max-width: 576px) {
          .filter-bar { padding: 10px !important; margin-bottom: 16px !important; }
          .filter-tabs { gap: 6px !important; margin-bottom: 10px !important; }
          .filter-tab { padding: 7px 10px !important; font-size: 0.72rem !important; gap: 4px !important; }
          .filter-controls { gap: 8px !important; }
          .class-select { padding: 8px 10px !important; font-size: 0.8rem !important; }
          .search-input { padding: 8px 12px 8px 32px !important; font-size: 0.8rem !important; }
          .filter-btn { padding: 8px 14px !important; font-size: 0.8rem !important; }
          .reset-btn { padding: 8px 12px !important; font-size: 0.75rem !important; }
        }
        @media (max-width: 380px) {
          .filter-tab { padding: 6px 8px !important; font-size: 0.65rem !important; }
          .search-input { font-size: 0.75rem !important; }
        }
      </style>
      <!-- FILTER TABS (SEMUA / VIDEO / MATERI) -->
      <div class="filter-tabs" style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 18px;">
        <!-- Tab 1: Semua Media -->
        <a class="filter-tab" href="{{ route('akademik', array_merge(request()->query(), ['tab' => 'all'])) }}" style="padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; {{ ($tab === 'all' || !$tab) ? 'background: var(--primary); color: #ffffff; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);' : 'background: #ffffff; color: var(--dark); border: 1px solid var(--border);' }}">
          <i class="fa-solid fa-shapes"></i> Semua Media ({{ $totalCombinedCount }})
        </a>

        <!-- Tab 2: Video Pembelajaran -->
        <a class="filter-tab" href="{{ route('akademik', array_merge(request()->query(), ['tab' => 'video'])) }}" style="padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; {{ $tab === 'video' ? 'background: #dc2626; color: #ffffff; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);' : 'background: #ffffff; color: var(--dark); border: 1px solid var(--border);' }}">
          <i class="fa-brands fa-youtube"></i> Video Pembelajaran ({{ $totalVideoCount }})
        </a>

        <!-- Tab 3: File Materi -->
        <a class="filter-tab" href="{{ route('akademik', array_merge(request()->query(), ['tab' => 'materi'])) }}" style="padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; {{ $tab === 'materi' ? 'background: #0284c7; color: #ffffff; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);' : 'background: #ffffff; color: var(--dark); border: 1px solid var(--border);' }}">
          <i class="fa-solid fa-file-arrow-down"></i> File Materi ({{ $totalMaterialCount }})
        </a>
      </div>

      <!-- FILTER CONTROLS: KELAS & SEARCH -->
      <form method="GET" action="{{ route('akademik') }}" class="filter-controls" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <input type="hidden" name="tab" value="{{ $tab }}">

        <!-- Filter Kelas Dropdown -->
        <div class="class-select" style="min-width: 170px;">
          <select name="class_level" onchange="this.form.submit()" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 10px; font-size: 0.9rem; background: #ffffff; outline: none; font-weight: 600; cursor: pointer;">
            @foreach($availableClasses as $cls)
              <option value="{{ $cls }}" {{ ($classLevel === $cls || (!$classLevel && $cls === 'Semua Kelas')) ? 'selected' : '' }}>
                {{ $cls === 'Semua Kelas' ? '🎯 Semua Tingkat Kelas' : '🏫 ' . $cls }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Search Input -->
        <div class="search-input-wrap" style="position: relative; flex: 1; min-width: 220px;">
          <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem;"></i>
          <input type="text" name="search" value="{{ $search }}" placeholder="Cari topik pembelajaran, judul materi, atau mapel..." class="search-input" style="width: 100%; padding: 10px 14px 10px 38px; border: 1px solid var(--border); border-radius: 10px; font-size: 0.9rem; outline: none; background: #ffffff; box-sizing: border-box;">
        </div>

        <!-- Filter Button -->
        <button type="submit" class="filter-btn" style="background: var(--primary); color: #ffffff; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-filter"></i> Terapkan
        </button>

        @if($search || ($classLevel && $classLevel !== 'Semua Kelas'))
        <a class="reset-btn" href="{{ route('akademik', ['tab' => $tab]) }}" style="background: #ffffff; color: #64748b; border: 1px solid var(--border); padding: 10px 16px; border-radius: 10px; font-weight: 600; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fa-solid fa-rotate-left"></i> Reset Filter
        </a>
        @endif
      </form>
    </div>

    <!-- ============================================================== -->
    <!-- BAGIAN 1: VIDEO PEMBELAJARAN                                   -->
    <!-- ============================================================== -->
    @if($tab !== 'materi')
    <div style="margin-bottom: 35px;">
      <style>
        .video-section { margin-bottom: 35px !important; }
        .video-header { margin-bottom: 18px !important; }
        .video-header h3 { font-size: 1.25rem !important; margin-bottom: 0 !important; }
        .video-header-count { font-size: 0.85rem !important; }
        .video-grid { gap: 20px !important; grid-template-columns: repeat(auto-fill, minmax(min(100%, 280px), 1fr)); }
        .video-card-height { height: 165px !important; }
        .video-tags { margin-bottom: 8px !important; }
        .video-title { font-size: 1rem !important; margin-bottom: 6px !important; }
        .video-desc { font-size: 0.82rem !important; margin-bottom: 10px !important; }
        .video-meta { font-size: 0.76rem !important; }
        .video-actions { padding: 12px 16px !important; gap: 8px !important; }
        .video-btn { padding: 7px 12px !important; font-size: 0.8rem !important; }
        @media (max-width: 768px) {
          .video-section { margin-bottom: 28px !important; }
          .video-header h3 { font-size: 1.1rem !important; }
          .video-grid { gap: 14px !important; grid-template-columns: repeat(auto-fill, minmax(min(100%, 240px), 1fr)); }
          .video-card-height { height: 140px !important; }
          .video-title { font-size: 0.92rem !important; }
          .video-desc { font-size: 0.76rem !important; }
        }
        @media (max-width: 576px) {
          .video-section { margin-bottom: 20px !important; }
          .video-header { margin-bottom: 12px !important; }
          .video-header h3 { font-size: 0.95rem !important; }
          .video-header-count { font-size: 0.75rem !important; }
          .video-grid { gap: 10px !important; grid-template-columns: repeat(auto-fill, minmax(min(100%, 160px), 1fr)); }
          .video-card-height { height: 100px !important; }
          .video-card { padding: 12px !important; }
          .video-tags { margin-bottom: 6px !important; gap: 4px !important; }
          .video-title { font-size: 0.80rem !important; margin-bottom: 4px !important; line-height: 1.3; }
          .video-desc { font-size: 0.70rem !important; margin-bottom: 6px !important; -webkit-line-clamp: 1 !important; }
          .video-meta { font-size: 0.65rem !important; }
          .video-actions { padding: 8px 12px !important; gap: 6px !important; }
          .video-btn { padding: 5px 8px !important; font-size: 0.70rem !important; }
        }
        @media (max-width: 380px) {
          .video-header h3 { font-size: 0.85rem !important; }
          .video-title { font-size: 0.75rem !important; }
          .video-desc { font-size: 0.65rem !important; }
        }
      </style>
      <div class="video-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 10px;">
        <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--dark); margin: 0; display: flex; align-items: center; gap: 10px;">
          <i class="fa-solid fa-circle-play" style="color: #ef4444;"></i> Video Pembelajaran Interaktif
        </h3>
        <span class="video-header-count" style="font-size: 0.85rem; color: var(--muted); font-weight: 600;">
          {{ count($videos) }} Video Ditemukan
        </span>
      </div>

      <div class="video-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 280px), 1fr)); gap: 20px;">
        @forelse($videos as $video)
        <div class="video-card" style="background: #ffffff; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(0,0,0,0.04)';">
          <div>
            <!-- Thumbnail Preview with Play Overlay -->
            <div class="video-card-height" style="position: relative; height: 165px; background: #0f172a; overflow: hidden;">
              @if($video->thumbnail_url)
                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div style="display: none; width: 100%; height: 100%; background: linear-gradient(135deg, {{ $video->is_drive ? '#0369a1, #0284c7' : '#991b1b, #ef4444' }}); align-items: center; justify-content: center; flex-direction: column; color: white;">
                  <i class="{{ $video->source_badge['icon'] }}" style="font-size: 2.8rem; margin-bottom: 6px;"></i>
                  <span style="font-size: 0.8rem; font-weight: 700;">{{ $video->source_badge['label'] }} Video</span>
                </div>
              @else
                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, {{ $video->is_drive ? '#0284c7, #38bdf8' : '#dc2626, #f87171' }}); display: flex; align-items: center; justify-content: center; flex-direction: column; color: white;">
                  <i class="{{ $video->source_badge['icon'] }}" style="font-size: 2.8rem; margin-bottom: 6px;"></i>
                  <span style="font-size: 0.8rem; font-weight: 700;">{{ $video->source_badge['label'] }} Video</span>
                </div>
              @endif

              <!-- Play Button Trigger (Modal) -->
              <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.32); display: flex; align-items: center; justify-content: center;">
                <button type="button" onclick="playPublicVideo('{{ addslashes($video->title) }}', '{{ $video->embed_url }}', '{{ $video->subject }}', '{{ $video->class_level }}', '{{ $video->source_badge['label'] }}')" style="width: 48px; height: 48px; border-radius: 50%; background: rgba(255,255,255,0.95); border: none; color: {{ $video->is_drive ? '#0284c7' : '#dc2626' }}; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; cursor: pointer; box-shadow: 0 4px 14px rgba(0,0,0,0.35); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" title="Putar Video">
                  <i class="fa-solid fa-play" style="margin-left: 2px;"></i>
                </button>
              </div>

              <!-- Platform Badge (Top-Right) -->
              <span style="position: absolute; top: 8px; right: 8px; background: {{ $video->is_drive ? 'rgba(2, 132, 199, 0.92)' : 'rgba(220, 38, 38, 0.92)' }}; color: #ffffff; padding: 3px 8px; border-radius: 6px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(0,0,0,0.25);">
                <i class="{{ $video->source_badge['icon'] }}"></i> {{ $video->source_badge['label'] }}
              </span>

              <!-- Duration Badge (Bottom-Right) -->
              <span style="position: absolute; bottom: 8px; right: 8px; background: rgba(15, 23, 42, 0.85); color: #ffffff; padding: 2px 7px; border-radius: 5px; font-size: 0.72rem; font-weight: 700;">
                <i class="fa-regular fa-clock" style="font-size: 0.68rem;"></i> {{ $video->duration }}
              </span>
            </div>

            <!-- Content Area -->
            <div style="padding: 16px;">
              <!-- Tags -->
              <div class="video-tags" style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 8px;">
                <span style="background: #e0f2fe; color: #0369a1; padding: 2px 9px; border-radius: 12px; font-size: 0.72rem; font-weight: 700;">
                  {{ $video->class_level }}
                </span>
                <span style="background: #f1f5f9; color: #475569; padding: 2px 9px; border-radius: 12px; font-size: 0.72rem; font-weight: 700;">
                  {{ $video->subject }}
                </span>
              </div>

              <!-- Title -->
              <h4 class="video-title" style="font-size: 1rem; font-weight: 800; color: var(--dark); margin: 0 0 6px 0; line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.9em;">
                {{ $video->title }}
              </h4>

              <!-- Description -->
              <p class="video-desc" style="font-size: 0.82rem; color: var(--muted); line-height: 1.5; margin: 0 0 10px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                {{ $video->description ?: 'Tidak ada deskripsi materi video.' }}
              </p>

              <!-- Teacher Uploader & Views -->
              <div class="video-meta" style="display: flex; justify-content: space-between; align-items: center; font-size: 0.76rem; color: #94a3b8; border-top: 1px dashed var(--border); padding-top: 8px;">
                <span><i class="fa-solid fa-chalkboard-user"></i> {{ $video->user ? $video->user->name : 'Guru SD Negeri Negeri Lama' }}</span>
                <span><i class="fa-regular fa-eye"></i> {{ number_format($video->views_count, 0, ',', '.') }}x</span>
              </div>
            </div>
          </div>

          <!-- Card Actions Footer -->
          <div class="video-actions" style="padding: 12px 16px; background: #f8fafc; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 8px;">
            <button type="button" class="video-btn" onclick="playPublicVideo('{{ addslashes($video->title) }}', '{{ $video->embed_url }}', '{{ $video->subject }}', '{{ $video->class_level }}', '{{ $video->source_badge['label'] }}')" style="flex: 1; padding: 7px 12px; font-size: 0.8rem; background: var(--primary); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
              <i class="fa-solid fa-play"></i> Tonton Video
            </button>

            @if($video->effective_url)
            <a href="{{ $video->effective_url }}" target="_blank" rel="noopener noreferrer" style="background: #ffffff; color: #475569; border: 1px solid var(--border); padding: 7px 10px; border-radius: 8px; font-size: 0.8rem; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;" title="Buka tautan asli">
              <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
            @endif
          </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; padding: 36px 20px; background: #ffffff; border: 1px dashed var(--border); border-radius: 14px; text-align: center; color: var(--muted);">
          <i class="fa-solid fa-video-slash" style="font-size: 2.2rem; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
          <h4 style="font-size: 1.05rem; font-weight: 700; color: var(--dark); margin-bottom: 4px;">Tidak Ada Video Pembelajaran</h4>
          <p style="font-size: 0.88rem; margin: 0;">Tidak ditemukan video pembelajaran yang cocok dengan filter pencarian ini.</p>
        </div>
        @endforelse
      </div>
    </div>
    @endif

    <!-- ============================================================== -->
    <!-- BAGIAN 2: FILE MATERI PEMBELAJARAN (PDF, DOCX, PPTX)           -->
    <!-- ============================================================== -->
    @if($tab !== 'video')
    <div>
      <style>
        .material-section { }
        .material-header { margin-bottom: 18px !important; }
        .material-header h3 { font-size: 1.25rem !important; }
        .material-header-count { font-size: 0.85rem !important; }
        .material-grid { gap: 20px !important; grid-template-columns: repeat(auto-fill, minmax(min(100%, 280px), 1fr)); }
        .material-card { padding: 20px !important; }
        .material-icon-box { width: 44px !important; height: 44px !important; font-size: 1.4rem !important; }
        .material-file-size { padding: 4px 10px !important; font-size: 0.72rem !important; }
        .material-title { font-size: 1.02rem !important; margin-bottom: 6px !important; }
        .material-desc { font-size: 0.84rem !important; margin-bottom: 12px !important; }
        .material-footer { margin-top: 8px !important; padding-top: 12px !important; }
        .material-meta { font-size: 0.75rem !important; }
        .material-download-btn { padding: 8px 14px !important; font-size: 0.8rem !important; }
        @media (max-width: 768px) {
          .material-header h3 { font-size: 1.1rem !important; }
          .material-grid { gap: 14px !important; grid-template-columns: repeat(auto-fill, minmax(min(100%, 240px), 1fr)); }
          .material-card { padding: 16px !important; }
          .material-title { font-size: 0.95rem !important; }
          .material-desc { font-size: 0.78rem !important; }
        }
        @media (max-width: 576px) {
          .material-header h3 { font-size: 0.95rem !important; }
          .material-header-count { font-size: 0.75rem !important; }
          .material-grid { gap: 10px !important; grid-template-columns: repeat(auto-fill, minmax(min(100%, 160px), 1fr)); }
          .material-card { padding: 12px !important; }
          .material-icon-box { width: 38px !important; height: 38px !important; font-size: 1.2rem !important; }
          .material-file-size { padding: 3px 8px !important; font-size: 0.65rem !important; }
          .material-title { font-size: 0.82rem !important; line-height: 1.3; }
          .material-desc { font-size: 0.72rem !important; margin-bottom: 8px !important; -webkit-line-clamp: 1 !important; }
          .material-meta { font-size: 0.65rem !important; }
          .material-download-btn { padding: 6px 10px !important; font-size: 0.70rem !important; }
        }
        @media (max-width: 380px) {
          .material-header h3 { font-size: 0.85rem !important; }
          .material-title { font-size: 0.75rem !important; }
          .material-desc { font-size: 0.65rem !important; }
        }
      </style>
      <div class="material-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 10px;">
        <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--dark); margin: 0; display: flex; align-items: center; gap: 10px;">
          <i class="fa-solid fa-folder-open" style="color: #2563eb;"></i> Berkas Materi & Modul Pembelajaran
        </h3>
        <span class="material-header-count" style="font-size: 0.85rem; color: var(--muted); font-weight: 600;">
          {{ count($materials) }} Berkas Tersedia
        </span>
      </div>

      <div class="material-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 280px), 1fr)); gap: 20px;">
        @forelse($materials as $material)
        <div class="material-card" style="background: #ffffff; border: 1px solid var(--border); border-radius: 14px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(0,0,0,0.04)';">
          <div>
            <!-- File Type Header -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
              <div class="material-icon-box" style="width: 44px; height: 44px; border-radius: 10px; background: {{ $material->icon_color }}15; color: {{ $material->icon_color }}; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                <i class="{{ $material->icon }}"></i>
              </div>
              <span class="material-file-size" style="background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 700;">
                {{ $material->file_size ?: 'Dokumen Digital' }}
              </span>
            </div>

            <!-- Tags -->
            <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 8px;">
              <span style="background: #e0f2fe; color: #0369a1; padding: 2px 9px; border-radius: 12px; font-size: 0.72rem; font-weight: 700;">
                {{ $material->class_level }}
              </span>
              <span style="background: #f1f5f9; color: #475569; padding: 2px 9px; border-radius: 12px; font-size: 0.72rem; font-weight: 700;">
                {{ $material->subject }}
              </span>
            </div>

            <!-- Title -->
            <h4 class="material-title" style="font-size: 1.02rem; font-weight: 800; color: var(--dark); margin: 0 0 6px 0; line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.9em;">
              {{ $material->title }}
            </h4>

            <!-- Description -->
            <p class="material-desc" style="font-size: 0.84rem; color: var(--muted); line-height: 1.5; margin: 0 0 12px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
              {{ $material->description ?: 'Bahan ajar materi mandiri untuk peserta didik.' }}
            </p>
          </div>

          <!-- Card Footer & Download Button -->
          <div class="material-footer" style="border-top: 1px solid var(--border); padding-top: 12px; margin-top: 8px; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
            <div class="material-meta" style="font-size: 0.75rem; color: #94a3b8;">
              <div><i class="fa-solid fa-chalkboard-user"></i> {{ $material->user ? $material->user->name : 'Guru Mapel' }}</div>
              <div style="margin-top: 2px;"><i class="fa-solid fa-download"></i> {{ number_format($material->downloads, 0, ',', '.') }} kali</div>
            </div>

            <a href="{{ route('materi.download', $material->id) }}" class="material-download-btn" style="padding: 8px 14px; font-size: 0.8rem; background: #0284c7; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(2, 132, 199, 0.25);" title="Unduh Berkas Pembelajaran">
              <i class="fa-solid fa-cloud-arrow-down"></i> Unduh
            </a>
          </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; padding: 36px 20px; background: #ffffff; border: 1px dashed var(--border); border-radius: 14px; text-align: center; color: var(--muted);">
          <i class="fa-solid fa-file-circle-xmark" style="font-size: 2.2rem; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
          <h4 style="font-size: 1.05rem; font-weight: 700; color: var(--dark); margin-bottom: 4px;">Tidak Ada Berkas Materi</h4>
          <p style="font-size: 0.88rem; margin: 0;">Tidak ditemukan bahan ajar yang cocok dengan filter pencarian ini.</p>
        </div>
        @endforelse
      </div>
    </div>
    @endif
  </div>
  @endguest

  <!-- ============================================================== -->
  <!-- 2. KURIKULUM MERDEKA                                           -->
  <!-- ============================================================== -->
  @if(!empty($settings['curriculum_title']))
  <div class="card-box" style="margin-bottom: 30px; padding: 30px; border-radius: 18px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04); border: 1px solid var(--border);">
    <style>
      .curriculum-section { padding: 30px !important; margin-bottom: 30px !important; }
      .curriculum-section h2 { font-size: 1.5rem !important; margin-bottom: 16px !important; }
      .curriculum-section p { font-size: 0.95rem !important; }
      @media (max-width: 768px) {
        .curriculum-section { padding: 20px !important; margin-bottom: 22px !important; }
        .curriculum-section h2 { font-size: 1.2rem !important; margin-bottom: 12px !important; }
        .curriculum-section p { font-size: 0.88rem !important; }
      }
      @media (max-width: 576px) {
        .curriculum-section { padding: 14px !important; margin-bottom: 16px !important; }
        .curriculum-section h2 { font-size: 1rem !important; margin-bottom: 10px !important; }
        .curriculum-section p { font-size: 0.78rem !important; line-height: 1.5; }
      }
      @media (max-width: 380px) {
        .curriculum-section h2 { font-size: 0.90rem !important; }
        .curriculum-section p { font-size: 0.72rem !important; }
      }
    </style>
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-book-open-reader"></i> {{ $settings['curriculum_title'] }}</h2>
    <p style="color: var(--muted); line-height: 1.8; margin-bottom: 0;">
      {!! nl2br(e($settings['curriculum_desc'] ?? '')) !!}
    </p>
  </div>
  @endif

  <!-- ============================================================== -->
  <!-- 3. EKSTRAKURIKULER                                             -->
  <!-- ============================================================== -->
  <div class="card-box" style="padding: 30px; border-radius: 18px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04); border: 1px solid var(--border);">
    <style>
      .ekstrakurikuler-section { padding: 30px !important; }
      .ekstrakurikuler-section h2 { font-size: 1.5rem !important; margin-bottom: 16px !important; }
      .ekstrakurikuler-section > p { font-size: 0.95rem !important; margin-bottom: 20px !important; }
      .eskul-grid { gap: 16px !important; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }
      .eskul-item { padding: 16px !important; font-size: 0.9rem !important; gap: 10px !important; }
      .eskul-icon { font-size: 1.1rem !important; width: 22px !important; }
      @media (max-width: 768px) {
        .ekstrakurikuler-section { padding: 20px !important; }
        .ekstrakurikuler-section h2 { font-size: 1.2rem !important; margin-bottom: 12px !important; }
        .ekstrakurikuler-section > p { font-size: 0.88rem !important; margin-bottom: 14px !important; }
        .eskul-grid { gap: 12px !important; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); }
        .eskul-item { padding: 12px !important; font-size: 0.82rem !important; }
      }
      @media (max-width: 576px) {
        .ekstrakurikuler-section { padding: 14px !important; }
        .ekstrakurikuler-section h2 { font-size: 1rem !important; margin-bottom: 10px !important; }
        .ekstrakurikuler-section > p { font-size: 0.78rem !important; margin-bottom: 10px !important; }
        .eskul-grid { gap: 8px !important; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); }
        .eskul-item { padding: 10px !important; font-size: 0.72rem !important; gap: 6px !important; }
      }
      @media (max-width: 380px) {
        .ekstrakurikuler-section h2 { font-size: 0.90rem !important; }
        .ekstrakurikuler-section > p { font-size: 0.70rem !important; }
        .eskul-item { padding: 8px !important; font-size: 0.65rem !important; }
      }
    </style>
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-medal"></i> Ekstrakurikuler</h2>
    @if(!empty($settings['extracurriculars']))
    <p style="color: var(--muted); margin-bottom: 20px;">Kami menyediakan berbagai wadah pengembangan bakat non-akademik bagi peserta didik:</p>
    @php
      $eskuls = array_filter(array_map('trim', explode("\n", $settings['extracurriculars'])));

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
    <div class="eskul-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
      @foreach($eskuls as $eskul)
      <div class="eskul-item" style="background: var(--light-bg); padding: 16px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid {{ $getIcon($eskul) }} eskul-icon" style="color: var(--primary); font-size: 1.1rem; width: 22px; text-align: center;"></i>
        <span>{{ $eskul }}</span>
      </div>
      @endforeach
    </div>
    @else
    <div style="padding: 30px; text-align: center; color: var(--muted); background: var(--light-bg); border-radius: 12px;">
      <style>
        @media (max-width: 576px) {
          .empty-eskul { padding: 20px !important; }
          .empty-eskul i { font-size: 1.5rem !important; }
          .empty-eskul p { font-size: 0.75rem !important; }
        }
      </style>
      <i class="fa-solid fa-inbox" style="font-size: 2rem; opacity: 0.3; margin-bottom: 10px; display: block;"></i>
      <p>Admin belum menambahkan data ekstrakurikuler. Silakan kembali kemudian.</p>
    </div>
    @endif
  </div>
</div>

<!-- ============================================================== -->
<!-- MODAL PEMUTAR VIDEO DIGITAL (INTERAKTIF UNTUK SISWA/PENGUNJUNG) -->
<!-- ============================================================== -->
<div id="modalPublicVideo" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.75); z-index: 99999; justify-content: center; align-items: center; padding: 16px; backdrop-filter: blur(4px);">
  <style>
    .modal-video-wrapper { width: 100% !important; max-width: 760px !important; border-radius: 16px !important; }
    .modal-video-header { padding: 16px 20px !important; }
    .modal-video-header h3 { font-size: 1.05rem !important; }
    .modal-video-footer { padding: 14px 20px !important; }
    .modal-video-footer-meta { gap: 8px !important; }
    .modal-video-footer-btn { padding: 6px 14px !important; font-size: 0.82rem !important; }
    @media (max-width: 768px) {
      .modal-video-header { padding: 12px 16px !important; }
      .modal-video-header h3 { font-size: 0.95rem !important; }
      .modal-video-footer { padding: 10px 16px !important; }
    }
    @media (max-width: 576px) {
      .modal-video-wrapper { padding: 8px !important; }
      .modal-video-header { padding: 10px 14px !important; }
      .modal-video-header h3 { font-size: 0.85rem !important; gap: 6px !important; }
      .modal-video-footer { padding: 8px 12px !important; flex-direction: column !important; }
      .modal-video-footer-meta { flex-direction: column !important; width: 100%; }
      .modal-video-footer-btn { width: 100%; padding: 8px 10px !important; font-size: 0.75rem !important; }
    }
    @media (max-width: 380px) {
      .modal-video-header h3 { font-size: 0.75rem !important; }
      .modal-video-footer-btn { font-size: 0.70rem !important; }
    }
  </style>
  <div class="modal-video-wrapper" style="background: #ffffff; width: 100%; max-width: 760px; border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.3); display: flex; flex-direction: column;">
    <!-- Modal Header -->
    <div class="modal-video-header" style="padding: 16px 20px; background: #0f172a; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
      <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
        <i class="fa-solid fa-circle-play" style="color: #ef4444; font-size: 1.2rem; flex-shrink: 0;"></i>
        <h3 id="modalVideoTitle" style="margin: 0; font-size: 1.05rem; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #ffffff;">
          Pemutar Video Edukasi
        </h3>
      </div>
      <button type="button" onclick="closePublicVideo()" style="background: transparent; border: none; color: #94a3b8; font-size: 1.5rem; cursor: pointer; line-height: 1; padding: 0 4px; transition: color 0.2s;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#94a3b8'">&times;</button>
    </div>

    <!-- 16:9 Video Player Iframe Container -->
    <div style="position: relative; width: 100%; aspect-ratio: 16/9; background: #000000;">
      <iframe id="modalVideoIframe" src="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>

    <!-- Modal Footer with Meta info -->
    <div class="modal-video-footer" style="padding: 14px 20px; background: #f8fafc; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
      <div class="modal-video-footer-meta" style="display: flex; align-items: center; gap: 8px;">
        <span id="modalVideoSubject" style="background: #e0f2fe; color: #0369a1; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">
          Mapel
        </span>
        <span id="modalVideoClass" style="background: #f1f5f9; color: #475569; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">
          Kelas
        </span>
        <span id="modalVideoPlatform" style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">
          Platform
        </span>
      </div>

      <button type="button" class="modal-video-footer-btn" onclick="closePublicVideo()" style="background: #e2e8f0; color: #334155; border: none; padding: 6px 14px; border-radius: 8px; font-weight: 700; font-size: 0.82rem; cursor: pointer;">
        Tutup Pemutar
      </button>
    </div>
  </div>
</div>

@section('scripts')
<script src="{{ asset('mentahan2/js/akademik.js') }}?v={{ filemtime(public_path('mentahan2/js/akademik.js')) ?: time() }}"></script>
@endsection
