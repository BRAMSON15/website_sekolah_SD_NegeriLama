@extends('layouts.app')

@section('title', $settings['school_name'] ?? 'SD Negeri Negeri Lama - Modern & Berkarakter')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endsection

@section('content')
<!-- Hero Section -->
<section class="h-hero">
  <div class="h-hero-overlay" aria-hidden="true"></div>

  <div class="h-hero-inner">
    <div>
      <h1>
        {!! $settings['hero_title'] ?? 'Mewujudkan Generasi <span class="h-grad">Cerdas, Kreatif &amp; Berkarakter</span>' !!}
      </h1>
      <p class="h-hero-desc">
        {{ $settings['hero_description'] ?? 'Selamat datang di portal resmi SD Negeri Negeri Lama.' }}
      </p>
      <div class="h-hero-btns">
      </div>
    </div>
  </div>
</section>

<!-- Fitur Unggulan -->
<section class="h-features">
  <div class="h-features-grid">
    @forelse($features as $feature)
    <div class="h-feat">
      <div class="h-feat-icon {{ $feature->icon_color_class ?? 'icon-blue' }}">
        <i class="{{ $feature->icon }}"></i>
      </div>
      <div>
        <h3>{{ $feature->title }}</h3>
        <p>{{ $feature->description }}</p>
      </div>
    </div>
    @empty
    <div class="h-feat">
      <div class="h-feat-icon icon-blue"><i class="fa-solid fa-laptop-code"></i></div>
      <div>
        <h3>Kelas Digital</h3>
        <p>Pembelajaran interaktif berbasis teknologi modern.</p>
      </div>
    </div>
    @endforelse
  </div>
</section>

<!-- Statistik Sekolah -->
<section class="h-stats">
  <div class="h-stats-grid">
    <div class="h-stat">
      <div class="h-stat-icon"><i class="fa-solid fa-user-graduate"></i></div>
      <strong>{{ $stats['students'] }}</strong>
      <span>Peserta Didik</span>
    </div>
    <div class="h-stat">
      <div class="h-stat-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
      <strong>{{ $stats['teachers'] }}</strong>
      <span>Guru Pengajar</span>
    </div>
    <div class="h-stat">
      <div class="h-stat-icon"><i class="fa-solid fa-circle-play"></i></div>
      <strong>{{ $stats['videos'] }}</strong>
      <span>Video Edukasi</span>
    </div>
    <div class="h-stat">
      <div class="h-stat-icon"><i class="fa-solid fa-book-bookmark"></i></div>
      <strong>{{ $stats['materials'] }}</strong>
      <span>Modul Materi</span>
    </div>
  </div>
</section>

<!-- Sambutan Kepala Sekolah -->
<section class="h-section" id="profil">
  <div class="h-principal-grid">
    <div>
      <div class="h-principal-photo">
        <i class="fa-solid fa-user-tie"></i>
        <span>Kepala Sekolah</span>
      </div>
    </div>
    <div class="h-principal-copy">
      <span class="h-eyebrow"><i class="fa-solid fa-quote-left"></i> Sambutan Kepala Sekolah</span>
      <h2>Membimbing dengan Hati, Mendidik dengan Prestasi</h2>
      <div class="h-quote">
        {{ $settings['principal_message'] ?? 'Selamat datang di SD Negeri Negeri Lama.' }}
      </div>
      <div class="h-principal-name">{{ $settings['principal_name'] ?? 'Drs. H. Ahmad Dahlan, M.Pd.' }}</div>
      <div class="h-principal-role">{{ $settings['principal_title'] ?? 'Kepala Sekolah SD Negeri Negeri Lama' }}</div>
    </div>
  </div>
</section>

<!-- Pengumuman -->
<section class="h-section h-section--tint" id="akademik">
  <div class="h-section-head">
    <span class="h-eyebrow"><i class="fa-solid fa-bullhorn"></i> Kabar Terbaru</span>
    <h2>Pusat Informasi &amp; Layanan</h2>
    <p>Akses cepat informasi pengumuman, agenda kegiatan, dan layanan akademik sekolah.</p>
  </div>

  <div class="h-ann-panel">
    <div class="h-ann-head">
      <h3><i class="fa-solid fa-bullhorn"></i> Pengumuman Terbaru</h3>
      <a href="{{ route('pengumuman.index') }}" class="h-ann-link">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
    </div>

    <div class="h-ann-list">
      @forelse($announcements as $announcement)
      <a href="{{ route('pengumuman.show', $announcement->slug) }}" class="h-ann">
        <div class="h-ann-date">
          <strong>{{ $announcement->published_at ? $announcement->published_at->format('d') : date('d') }}</strong>
          <span>{{ $announcement->published_at ? $announcement->published_at->format('M') : date('M') }}</span>
        </div>
        <div class="h-ann-body">
          <h4>{{ $announcement->title }}</h4>
          <p>{{ Str::limit($announcement->content, 110) }}</p>
        </div>
      </a>
      @empty
      <p class="h-ann-empty">Belum ada pengumuman terbaru.</p>
      @endforelse
    </div>
  </div>
</section>
<!-- Lokasi Sekolah -->
<section class="school-location-section" aria-labelledby="school-location-title">
  <script>
    // Pass school settings to welcome.js
    window.schoolLatitude = {{ $settings['school_latitude'] ?? '-3.695' }};
    window.schoolLongitude = {{ $settings['school_longitude'] ?? '128.18' }};
    window.schoolName = @json($settings['school_name'] ?? 'SD Negeri Negeri Lama');
    window.schoolAddress = @json($settings['address'] ?? 'Lokasi sekolah');
  </script>
  <div style="max-width: 1280px; margin: 0 auto 24px;">
    <span style="color: #16825d; font-weight: 700; font-size: 0.85rem;">LOKASI SEKOLAH</span>
    <h2 id="school-location-title" style="font-size: 2rem; font-weight: 800; color: var(--dark); margin: 8px 0;">Temukan {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}</h2>
    <p style="color: var(--muted); margin: 0;">Peta lokasi dan alamat sekolah untuk membantu kunjungan Anda.</p>
  </div>
  <div class="school-location-layout">
    <div id="school-public-map" role="application" aria-label="Peta lokasi sekolah"></div>
    <div class="school-location-copy">
      <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--dark); margin-bottom: 10px;">{{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}</h3>
      <p style="color: var(--muted); line-height: 1.7; margin: 0 0 20px;">{{ $settings['address'] ?? 'Alamat sekolah belum tersedia.' }}</p>
      <a href="https://www.openstreetmap.org/?mlat={{ $settings['school_latitude'] ?? '-3.695' }}&mlon={{ $settings['school_longitude'] ?? '128.18' }}#map=17/{{ $settings['school_latitude'] ?? '-3.695' }}/{{ $settings['school_longitude'] ?? '128.18' }}" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; gap: 8px; color: #1769d9; font-weight: 700; text-decoration: none;">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka peta lengkap
      </a>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('mentahan2/js/welcome.js') }}?v={{ filemtime(public_path('mentahan2/js/welcome.js')) ?: time() }}"></script>
@endsection
