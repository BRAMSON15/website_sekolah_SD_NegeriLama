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
  @vite('resources/css/app.css')

  <style>
    :root {
      --primary: #1e3a8a;
      --primary-dark: #0f172a;
      --primary-light: #3b82f6;
      --gold: #d97706;
      --gold-light: #fef3c7;
      --gold-border: #fcd34d;
      --bg: #f8fafc;
      --card-bg: #ffffff;
      --border: #e2e8f0;
      --text-dark: #0f172a;
      --text-muted: #64748b;
      --success: #10b981;
      --danger: #ef4444;
      --warning: #f59e0b;
      --info: #0284c7;
      --sidebar-w: 260px;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
      background: var(--bg);
      color: var(--text-dark);
      min-height: 100vh;
      display: flex;
    }

    /* Sidebar Layout */
    .kepsek-sidebar {
      width: var(--sidebar-w);
      background: #0f172a;
      color: #f8fafc;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      z-index: 1000;
      display: flex;
      flex-direction: column;
      box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .kepsek-brand {
      padding: 24px 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .kepsek-brand-logo {
      width: 44px;
      height: 44px;
      background: #ffffff;
      border-radius: 12px;
      padding: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .kepsek-brand-logo img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .kepsek-brand-text h2 {
      font-size: 0.95rem;
      font-weight: 800;
      color: #ffffff;
      line-height: 1.2;
      letter-spacing: -0.3px;
    }

    .kepsek-brand-text span {
      font-size: 0.68rem;
      color: #94a3b8;
      font-weight: 600;
      display: block;
      margin-top: 2px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .kepsek-nav {
      flex: 1;
      padding: 16px 12px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .nav-label {
      font-size: 0.68rem;
      font-weight: 800;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      padding: 12px 12px 6px;
    }

    .kepsek-nav-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 11px 14px;
      border-radius: 10px;
      color: #94a3b8;
      text-decoration: none;
      font-size: 0.88rem;
      font-weight: 600;
      transition: all 0.2s ease;
    }

    .kepsek-nav-link:hover {
      background: rgba(255, 255, 255, 0.06);
      color: #ffffff;
      transform: translateX(3px);
    }

    .kepsek-nav-link.active {
      background: linear-gradient(135deg, #1e3a8a, #2563eb);
      color: #ffffff;
      box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
      font-weight: 700;
    }

    .kepsek-nav-link i {
      width: 20px;
      text-align: center;
      font-size: 1.05rem;
    }

    .sidebar-footer {
      padding: 16px;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      background: rgba(0, 0, 0, 0.2);
    }

    .principal-card-mini {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .principal-card-mini .avatar {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: linear-gradient(135deg, #d97706, #f59e0b);
      color: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      flex-shrink: 0;
    }

    .principal-card-mini .info {
      flex: 1;
      min-width: 0;
    }

    .principal-card-mini .name {
      font-size: 0.82rem;
      font-weight: 700;
      color: #ffffff;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .principal-card-mini .role {
      font-size: 0.68rem;
      color: #f59e0b;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }

    /* Main Container */
    .kepsek-main {
      margin-left: var(--sidebar-w);
      flex: 1;
      min-width: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Topbar */
    .kepsek-topbar {
      height: 70px;
      background: #ffffff;
      border-bottom: 1px solid var(--border);
      padding: 0 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 900;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .topbar-left {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .topbar-title {
      font-size: 1.15rem;
      font-weight: 800;
      color: var(--text-dark);
      letter-spacing: -0.3px;
    }

    .topbar-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: var(--gold-light);
      border: 1px solid var(--gold-border);
      color: #b45309;
      font-size: 0.72rem;
      font-weight: 800;
      padding: 4px 10px;
      border-radius: 20px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .topbar-right {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .btn-topbar-action {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 14px;
      border-radius: 8px;
      font-size: 0.82rem;
      font-weight: 700;
      text-decoration: none;
      transition: all 0.2s;
    }

    .btn-topbar-site {
      background: #f1f5f9;
      border: 1px solid var(--border);
      color: #334155;
    }
    .btn-topbar-site:hover {
      background: #e2e8f0;
      color: #0f172a;
    }

    .btn-topbar-logout {
      background: #fef2f2;
      border: 1px solid #fecaca;
      color: #dc2626;
      cursor: pointer;
    }
    .btn-topbar-logout:hover {
      background: #fee2e2;
      border-color: #ef4444;
    }

    .menu-toggle {
      display: none;
      background: transparent;
      border: none;
      font-size: 1.25rem;
      color: var(--text-dark);
      cursor: pointer;
    }

    /* Content Area */
    .kepsek-content {
      padding: 28px;
      flex: 1;
    }

    /* Mobile Responsive */
    @media (max-width: 992px) {
      .kepsek-sidebar {
        transform: translateX(-100%);
      }
      .kepsek-sidebar.open {
        transform: translateX(0);
      }
      .kepsek-main {
        margin-left: 0;
      }
      .menu-toggle {
        display: block;
      }
      .kepsek-topbar {
        padding: 0 16px;
      }
      .kepsek-content {
        padding: 16px;
      }
    }

    .sidebar-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.5);
      backdrop-filter: blur(2px);
      z-index: 995;
    }
    .sidebar-overlay.active {
      display: block;
    }

    /* Print Styles */
    @media print {
      .kepsek-sidebar, .kepsek-topbar, .sidebar-overlay, .no-print {
        display: none !important;
      }
      .kepsek-main {
        margin-left: 0 !important;
      }
      body {
        background: #ffffff !important;
      }
      .kepsek-content {
        padding: 0 !important;
      }
    }
  </style>
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
