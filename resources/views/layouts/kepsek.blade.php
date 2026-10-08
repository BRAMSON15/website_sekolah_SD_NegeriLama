<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Monitoring Kepala Sekolah - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))</title>

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="{{ asset('mentahan2/img/Logo1.svg') }}">
  <link rel="alternate icon" type="image/png" href="{{ asset('mentahan2/img/Logo1.png') }}">
  <link rel="shortcut icon" href="{{ asset('mentahan2/img/Logo1.png') }}">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- FontAwesome & Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Tailwind & Core Framework Styles -->
  @vite('resources/css/app.css')

  <!-- Custom Kepsek Layout Stylesheet (Loaded after Tailwind for layout priority) -->
  <link rel="stylesheet" href="{{ asset('mentahan2/css/kepsek.css') }}?v={{ @filemtime(public_path('mentahan2/css/kepsek.css')) ?: time() }}">

  @yield('styles')
</head>
<body>

  <!-- Sidebar Overlay for Mobile -->
  <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

  <!-- Sidebar Navigation -->
  <aside class="kepsek-sidebar" id="kepsekSidebar">
    <div class="kepsek-brand">
      <div class="kepsek-brand-logo">
        <img src="{{ asset('mentahan2/img/Logo1.svg') }}?v={{ @filemtime(public_path('mentahan2/img/Logo1.svg')) ?: time() }}" alt="Logo" onerror="this.onerror=null; this.src='{{ asset('mentahan2/img/Logo1.png') }}';">
      </div>
      <div class="kepsek-brand-text">
        <h2>{{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}</h2>
        <span>Supervisi & Monitoring</span>
      </div>
    </div>

    <nav class="kepsek-nav">
      <div class="nav-label">Menu Utama</div>

      <a href="{{ route('kepsek.dashboard') }}" class="kepsek-nav-link {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-gauge-high"></i>
        <span>Dashboard Eksekutif</span>
      </a>

      <div class="nav-label">Supervisi Akademik</div>

      <a href="{{ route('kepsek.monitoring.guru') }}" class="kepsek-nav-link {{ request()->routeIs('kepsek.monitoring.guru') ? 'active' : '' }}">
        <i class="fa-solid fa-chalkboard-user"></i>
        <span>Monitoring Guru</span>
      </a>

      <a href="{{ route('kepsek.monitoring.pembelajaran') }}" class="kepsek-nav-link {{ request()->routeIs('kepsek.monitoring.pembelajaran') ? 'active' : '' }}">
        <i class="fa-solid fa-book-open-reader"></i>
        <span>Video & Modul Ajar</span>
      </a>

      <div class="nav-label">Kesiswaan & Operasional</div>

      <a href="{{ route('kepsek.monitoring.ppdb') }}" class="kepsek-nav-link {{ request()->routeIs('kepsek.monitoring.ppdb') ? 'active' : '' }}">
        <i class="fa-solid fa-user-graduate"></i>
        <span>Pendaftar PPDB Baru</span>
      </a>

      <a href="{{ route('kepsek.monitoring.sistem') }}" class="kepsek-nav-link {{ request()->routeIs('kepsek.monitoring.sistem') ? 'active' : '' }}">
        <i class="fa-solid fa-server"></i>
        <span>Status Sistem & Web</span>
      </a>
    </nav>

    <div class="sidebar-footer">
      <div class="principal-card-mini">
        <div class="avatar">
          <i class="fa-solid fa-user-tie"></i>
        </div>
        <div class="info">
          <div class="name">{{ Auth::user()->name }}</div>
          <div class="role">Kepala Sekolah</div>
        </div>
      </div>
    </div>
  </aside>

  <!-- Main Content Wrap -->
  <div class="kepsek-main">
    <header class="kepsek-topbar">
      <div class="topbar-left">
        <button type="button" class="menu-toggle" onclick="toggleSidebar()" aria-label="Toggle Menu">
          <i class="fa-solid fa-bars"></i>
        </button>
        <div class="topbar-title">@yield('page-title', 'Dashboard Monitoring')</div>
        <span class="topbar-badge"><i class="fa-solid fa-shield-halved"></i> Kepala Sekolah</span>
      </div>

      <div class="topbar-right">
        <a href="{{ route('home') }}" target="_blank" class="btn-topbar-action btn-topbar-site" title="Buka Portal Beranda">
          <i class="fa-solid fa-globe"></i>
          <span>Website Sekolah</span>
        </a>
        <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
          @csrf
          <button type="submit" class="btn-topbar-action btn-topbar-logout" title="Keluar dari sesi monitoring">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Keluar</span>
          </button>
        </form>
      </div>
    </header>

    <main class="kepsek-content">
      @if(session('success'))
      <div style="background: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 14px 18px; border-radius: 10px; font-size: 0.9rem; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.1);">
        <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 1.15rem;"></i>
        <div>{{ session('success') }}</div>
      </div>
      @endif

      @yield('content')
    </main>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('kepsekSidebar');
      const overlay = document.getElementById('sidebarOverlay');
      if (sidebar && overlay) {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
      }
    }
  </script>
  @yield('scripts')
</body>
</html>
