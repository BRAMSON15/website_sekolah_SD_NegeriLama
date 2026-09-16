<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Admin - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))</title>
  
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('mentahan2/nalika/img/favicon.ico') }}">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- FontAwesome & Leaflet -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
  
  <!-- Custom Mentahan2 Stylesheet -->
  <link rel="stylesheet" href="{{ asset('mentahan2/css/style.css') }}">
  
  <style>
    /* Custom enhancements for responsiveness & theme integration */
    .brand-title-wrap h2 {
      font-size: 16px;
      font-weight: 700;
      color: #ffffff;
      margin: 0 0 2px 0;
    }
    .brand-title-wrap span {
      font-size: 11px;
      color: #9eb6d6;
    }
    .nav-item-icon {
      font-size: 16px;
      width: 22px;
      text-align: center;
      display: inline-block;
    }
    .user-avatar-circle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #2676df;
      color: #fff;
      display: grid;
      place-items: center;
      font-size: 18px;
      font-weight: 700;
    }
    .topbar-right-controls {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .logout-btn-link {
      color: #ef5350;
      font-size: 13px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 6px 12px;
      border-radius: 8px;
      background: #fdf2f2;
      transition: background 0.2s ease;
    }
    .logout-btn-link:hover {
      background: #fde8e8;
      color: #d32f2f;
    }
    .dashboard-map-container {
      width: 100%;
      height: 380px;
      border-radius: 12px;
      overflow: hidden;
      margin-top: 15px;
      border: 1px solid var(--line);
    }
    #ambon-map {
      width: 100%;
      height: 100%;
    }
    
    /* Legacy Nalika Subpages Compatibility CSS */
    .information-home { padding: 5px 0 30px; }
    .information-hero {
      min-height: 140px;
      border-radius: 16px;
      padding: 25px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: linear-gradient(105deg, #e7f2ff, #cfe6ff);
      border: 1px solid #d9eafa;
      margin-bottom: 22px;
    }
    .information-hero h2 { font-size: 24px; color: #123b72; margin-bottom: 6px; }
    .information-hero p { color: #6682a8; font-size: 14px; margin: 0; }
    .information-hero-icon { font-size: 55px; color: #1769d9; opacity: 0.85; }
    .panel-eyebrow { font-size: 10px; font-weight: 700; letter-spacing: 0.8px; color: #1769d9; display: block; margin-bottom: 5px; }

    .information-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px; }
    .information-stat-card {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 15px;
      padding: 20px;
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .information-stat-icon {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      display: grid;
      place-items: center;
      color: #fff;
      font-size: 20px;
      flex-shrink: 0;
    }
    .information-stat-icon-green { background: #45bd8d; }
    .information-stat-icon-blue { background: #1769d9; }
    .information-stat-icon-purple { background: #8c6ce5; }
    .information-stat-card span { display: block; font-size: 13px; color: #42618a; margin-bottom: 4px; }
    .information-stat-card strong { display: block; font-size: 24px; color: #122f58; }
    .information-stat-card small { color: #8097b5; font-size: 11px; }

    .information-panels { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 25px; }
    .information-panel {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 15px;
      padding: 22px;
      margin-bottom: 25px;
    }
    .information-panel-heading {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 18px;
      padding-bottom: 14px;
      border-bottom: 1px solid var(--line);
    }
    .information-panel-heading h3, .information-panel-heading h4 { font-size: 17px; color: #122f58; margin: 0; }
    .information-panel-heading p { font-size: 12px; color: #7390b5; margin-top: 3px; }

    .information-list-item, .information-feature-item {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 14px 0;
      border-bottom: 1px solid #edf2f8;
    }
    .information-list-item:last-child, .information-feature-item:last-child { border-bottom: none; }
    .information-list-icon {
      width: 40px;
      height: 40px;
      border-radius: 12px;
      background: #e5f0ff;
      color: #1769d9;
      display: grid;
      place-items: center;
      font-size: 16px;
      flex-shrink: 0;
    }
    .information-list-content { flex: 1; }
    .information-list-content h4, .information-feature-item h4 { font-size: 14px; color: #17345e; margin: 0 0 4px 0; }
    .information-list-content span, .information-feature-item p { font-size: 11px; color: #7390b5; margin: 0; }

    .information-status {
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 600;
    }
    .information-status-active { background: #def8ef; color: #07866a; }
    .information-status-muted { background: #f1f5fc; color: #7790b3; }

    .information-panel-footer {
      display: inline-block;
      margin-top: 15px;
      font-size: 12px;
      font-weight: 600;
      color: #1769d9;
    }

    /* Buttons & Form Controls */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      border-radius: 9px;
      font-size: 13px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: 0.2s;
      text-decoration: none;
    }
    .btn-primary { background: #1769d9; color: #fff; }
    .btn-primary:hover { background: #1254b3; }
    .btn-grey { background: #f1f6fc; color: #17345e; border: 1px solid var(--line); }
    .btn-grey:hover { background: #e2ecf8; }
    .btn-danger { background: #ef5350; color: #fff; }
    .btn-danger:hover { background: #d32f2f; }
    .btn-xs { padding: 5px 10px; font-size: 11px; border-radius: 6px; }

    .table-responsive { width: 100%; overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { text-align: left; padding: 12px 14px; font-size: 12px; color: #7390b5; border-bottom: 1px solid var(--line); background: #f8fafc; }
    td { padding: 14px; font-size: 13px; color: #17345e; border-bottom: 1px solid #edf2f8; vertical-align: middle; }
    tr:hover td { background: #fcfdfe; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .action-cell form { display: inline-block; margin-left: 4px; }
    .table-subtext { display: block; font-size: 11px; color: #8aa0bc; margin-top: 3px; }
    .feature-table-icon { display: inline-grid; width: 32px; height: 32px; place-items: center; border-radius: 8px; margin-right: 10px; vertical-align: middle; }

    /* Form Styles */
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #17345e; margin-bottom: 6px; }
    .form-control { width: 100%; padding: 10px 14px; border-radius: 9px; border: 1px solid var(--line); background: #fdfefe; font-size: 13px; color: #17345e; outline: none; }
    .form-control:focus { border-color: #1769d9; box-shadow: 0 0 0 3px rgba(23,105,217,0.1); }
    .form-hint { font-size: 11px; color: #7390b5; margin-top: 4px; display: block; }
    .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; }
    .checkbox { margin-top: 15px; font-size: 13px; color: #17345e; }

    @media (max-width: 900px) {
      .information-stats { grid-template-columns: 1fr; }
      .information-panels { grid-template-columns: 1fr; }
    }
  </style>

  @yield('styles')
</head>
<body>
  <div class="app">
    <!-- Sidebar -->
    <aside class="sidebar" id="appSidebar">
      <div class="brand">
        <div class="brand-logo">
          <img src="{{ asset('mentahan2/img/logo.svg') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
        <div class="brand-title-wrap">
          <h2>{{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}</h2>
          <span>Berilmu, Berkarakter, Berprestasi</span>
        </div>
      </div>

      <nav class="nav">
        <a class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
          <span class="nav-item-icon"><i class="fa fa-home"></i></span> Dashboard
        </a>

        <div class="nav-title">SISTEM INFORMASI</div>
        <a class="nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}" href="{{ route('admin.teachers.index') }}">
          <span class="nav-item-icon"><i class="fa fa-user-tie"></i></span> Kelola Akun Guru
        </a>
        <a class="nav-item {{ request()->routeIs('admin.informasi', 'admin.pengumuman.*', 'admin.fitur.*') ? 'active' : '' }}" href="{{ route('admin.informasi') }}">
          <span class="nav-item-icon"><i class="fa fa-bullhorn"></i></span> Kelola Informasi
        </a>
        <a class="nav-item {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}" href="{{ route('admin.pengumuman.index') }}" style="padding-left: 32px; font-size: 13px;">
          <span class="nav-item-icon"><i class="fa fa-list-alt"></i></span> Pengumuman
        </a>
        <a class="nav-item {{ request()->routeIs('admin.fitur.*') ? 'active' : '' }}" href="{{ route('admin.fitur.index') }}" style="padding-left: 32px; font-size: 13px;">
          <span class="nav-item-icon"><i class="fa fa-star"></i></span> Fitur / Layanan
        </a>

        <div class="nav-title">INFORMASI LAINNYA</div>
        <a class="nav-item" href="{{ route('pengumuman.index') }}">
          <span class="nav-item-icon"><i class="fa fa-newspaper"></i></span> Pengumuman Publik
        </a>
        <a class="nav-item" href="{{ route('profil') }}">
          <span class="nav-item-icon"><i class="fa fa-school"></i></span> Profil Sekolah
        </a>
        <a class="nav-item" href="{{ route('kontak') }}">
          <span class="nav-item-icon"><i class="fa fa-envelope"></i></span> Hubungi Kami
        </a>
      </nav>

      <div class="sidebar-footer">
        <div class="school-art">📖</div>
        <p>Pendidikan adalah investasi terbaik untuk masa depan anak bangsa.</p>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="main">
      <header class="topbar">
        <div style="display: flex; align-items: center; width: 50%;">
          <button class="menu-toggle-btn" id="sidebarToggleBtn" aria-label="Toggle Menu">
            <i class="fa fa-bars"></i>
          </button>
          <div class="search">
            <span>⌕</span>
            <input type="text" placeholder="Cari data pengumuman, fitur, atau informasi...">
          </div>
        </div>

        <div class="topbar-right-controls">
          <div class="profile-area">
            <div class="user-avatar-circle">
              <i class="fa fa-user"></i>
            </div>
            <div class="profile">
              <strong>{{ Auth::user()->name }}</strong>
              <small>{{ ucfirst(Auth::user()->role) }}</small>
            </div>
          </div>

          <a href="#" class="logout-btn-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out-alt"></i> <span>Keluar</span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </header>

      <section class="content">
        @yield('content')
      </section>
    </main>
  </div>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const toggleBtn = document.getElementById('sidebarToggleBtn');
      const sidebar = document.getElementById('appSidebar');

      if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() {
          sidebar.classList.toggle('mobile-open');
        });
      }
    });
  </script>

  @yield('scripts')
</body>
</html>
