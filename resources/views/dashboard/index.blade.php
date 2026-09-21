@extends('layouts.admin')

@section('title', 'Dashboard Admin - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
@if (session('success'))
<div class="alert-custom-success">
    <span><i class="fa fa-check-circle"></i> {{ session('success') }}</span>
    <button type="button" onclick="this.parentElement.remove()">×</button>
</div>
@endif

<!-- Hero Section -->
<div class="hero">
  <div class="hero-copy">
    <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>
    <p>Kelola data sekolah dan pusat informasi {{ $settings['school_name'] ?? 'SD NEGERI LAMA' }} dengan mudah dan efisien melalui panel kontrol admin ini.</p>
    <a href="{{ route('admin.informasi') }}" class="primary-btn" style="display: inline-block; text-decoration: none;">
      <i class="fa fa-info-circle"></i> &nbsp; Kelola Informasi Sekolah
    </a>
  </div>
  <div class="hero-school"></div>
</div>

<!-- Stats Section -->
<div class="stats">
  <article class="stat-card blue">
    <div class="stat-icon"><i class="bi bi-megaphone-fill"></i></div>
    <div>
      <span>Total Pengumuman</span>
      <strong>{{ $stats['announcements'] }}</strong>
      <small>↗ <em>{{ $stats['activeAnnouncements'] }} Aktif</em></small>
    </div>
    <a href="{{ route('admin.pengumuman.index') }}" class="arrow"><i class="bi bi-arrow-right"></i></a>
  </article>

  <article class="stat-card green">
    <div class="stat-icon"><i class="bi bi-grid-fill"></i></div>
    <div>
      <span>Fitur / Layanan</span>
      <strong>{{ $stats['features'] }}</strong>
      <small>↗ <em>Terbuka Publik</em></small>
    </div>
    <a href="{{ route('admin.fitur.index') }}" class="arrow"><i class="bi bi-arrow-right"></i></a>
  </article>

  <article class="stat-card purple">
    <div class="stat-icon"><i class="bi bi-gear-wide-connected"></i></div>
    <div>
      <span>Pengaturan Sistem</span>
      <strong>{{ $stats['settings'] }}</strong>
      <small>↗ <em>Terverifikasi</em></small>
    </div>
    <a href="{{ route('admin.informasi') }}" class="arrow"><i class="bi bi-arrow-right"></i></a>
  </article>

  <article class="stat-card orange">
    <div class="stat-icon"><i class="bi bi-person-badge-fill"></i></div>
    <div>
      <span>Peran Pengguna</span>
      <strong>{{ ucfirst(Auth::user()->role) }}</strong>
      <small>Status: Active</small>
    </div>
    <span class="arrow"><i class="bi bi-arrow-right"></i></span>
  </article>
</div>

<!-- Two Columns Section -->
<div class="two-columns">
  <!-- Announcement Panel -->
  <section class="panel">
    <div class="panel-head">
      <h2><i class="fa fa-bullhorn" style="color: #8c6ce5; margin-right: 6px;"></i> Pengumuman Terbaru</h2>
      <a href="{{ route('admin.pengumuman.index') }}">Lihat Semua</a>
    </div>
    @forelse($recentAnnouncements as $item)
    <div class="announcement">
      <div class="mini-icon {{ $loop->index % 2 == 0 ? 'purple-bg' : 'blue-bg' }}">
        <i class="bi {{ $loop->index % 2 == 0 ? 'bi-bell-fill' : 'bi-megaphone-fill' }}" style="font-size: 16px; color: {{ $loop->index % 2 == 0 ? '#8c6ce5' : '#1769d9' }};"></i>
      </div>
      <div>
        <strong>{{ $item->title }}</strong>
        <span><i class="fa fa-calendar-alt"></i> {{ $item->published_at ? $item->published_at->format('d M Y') : 'Draft' }}</span>
        <p>{{ Str::limit(strip_tags($item->content), 65) }}</p>
      </div>
      <a href="{{ route('admin.pengumuman.index') }}" style="text-decoration: none; color: inherit; display: inline-flex; align-items: center;"><i class="bi bi-chevron-right" style="font-size: 13px; color: #6885aa;"></i></a>
    </div>
    @empty
    <div style="padding: 30px; text-align: center; color: var(--muted);">
      <p>Belum ada pengumuman terbaru.</p>
    </div>
    @endforelse
  </section>

  <!-- Interactive Map Panel -->
  <section class="panel">
    <div class="panel-head">
      <h2><i class="fa fa-map-marked-alt" style="color: #45bd8d; margin-right: 6px;"></i> Peta Lokasi Pulau Ambon</h2>
      <a href="https://www.openstreetmap.org/?mlat=-3.695&mlon=128.18#map=11/-3.695/128.18" target="_blank" rel="noopener">Buka Peta Komplit</a>
    </div>
    <div style="padding: 15px;">
      <div class="dashboard-map-container">
        <div id="ambon-map"></div>
      </div>
    </div>
  </section>
</div>

<!-- Feature Grid Section -->
<div class="feature-grid">
  <a href="{{ route('admin.pengumuman.index') }}" class="feature blue-feature" style="text-decoration: none;">
    <div class="feature-icon"><i class="bi bi-megaphone-fill"></i></div>
    <div>
      <strong>Kelola Pengumuman</strong>
      <p>Buat, edit, dan publikasikan informasi terbaru untuk publik.</p>
    </div>
    <b><i class="bi bi-arrow-right"></i></b>
  </a>
  <a href="{{ route('admin.fitur.index') }}" class="feature green-feature" style="text-decoration: none;">
    <div class="feature-icon"><i class="bi bi-grid-fill"></i></div>
    <div>
      <strong>Layanan & Fitur</strong>
      <p>Atur daftar program unggulan dan fasilitas sekolah.</p>
    </div>
    <b><i class="bi bi-arrow-right"></i></b>
  </a>
  <a href="{{ route('admin.informasi') }}" class="feature purple-feature" style="text-decoration: none;">
    <div class="feature-icon"><i class="bi bi-gear-wide-connected"></i></div>
    <div>
      <strong>Pusat Informasi</strong>
      <p>Akses ringkasan lengkap data dan modul pengelolaan.</p>
    </div>
    <b><i class="bi bi-arrow-right"></i></b>
  </a>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof L === 'undefined' || !document.getElementById('ambon-map')) {
            return;
        }

        const ambonMap = L.map('ambon-map', {
            scrollWheelZoom: false,
            zoomControl: true
        }).setView([-3.695, 128.18], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(ambonMap);

        const marker = L.marker([-3.695, 128.18]).addTo(ambonMap)
            .bindPopup('<strong>Ambon</strong><br>Pusat Kota Ambon');
            
        marker.openPopup();

        function refreshMapSize() {
            ambonMap.invalidateSize();
        }

        setTimeout(refreshMapSize, 250);
        window.addEventListener('resize', refreshMapSize);

        const mapEl = document.getElementById('ambon-map');
        if (window.ResizeObserver && mapEl) {
            new ResizeObserver(refreshMapSize).observe(mapEl);
        }
    });
</script>
@endsection
