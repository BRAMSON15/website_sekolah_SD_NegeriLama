<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Admin - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))</title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="{{ asset('mentahan2/img/Logo1.svg') }}">
  <link rel="alternate icon" type="image/png" href="{{ asset('mentahan2/img/Logo1.png') }}">
  <link rel="shortcut icon" href="{{ asset('mentahan2/img/Logo1.png') }}">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- FontAwesome, Bootstrap Icons, & Leaflet -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
  <link rel="stylesheet" href="{{ asset('mentahan2/css/app.css') }}">
  
  <!-- Custom Mentahan2 Stylesheet -->
  <link rel="stylesheet" href="{{ asset('mentahan2/css/style.css') }}">
  
  <script>
    (function() {
      try {
        if (localStorage.getItem('admin_sidebar_closed') === 'true' && window.innerWidth > 992) {
          document.documentElement.classList.add('sidebar-closed-preload');
        }
      } catch(e) {}
    })();
  </script>

 

  @yield('styles')
</head>
<body>
  <div class="app">
    <!-- Sidebar -->
    <aside class="sidebar" id="appSidebar">
      <div class="brand">
        <div class="brand-logo">
          <img src="{{ asset('mentahan2/img/Logo1.svg') }}?v={{ @filemtime(public_path('mentahan2/img/Logo1.svg')) ?: time() }}" alt="Logo {{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fa-solid fa-graduation-cap\' style=\'font-size: 22px; color: #1769e0;\'></i>';">
        </div>
        <div class="brand-title-wrap">
          <h2>{{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}</h2>
          <span>Berilmu, Berkarakter, Berprestasi</span>
        </div>
        <button type="button" class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Tutup Sidebar" title="Tutup Sidebar">
          <i class="fa-solid fa-chevron-left"></i>
        </button>
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
        <div class="nav-title">KELOLA KONTEN WEBSITE</div>
        <a class="nav-item {{ request()->routeIs('admin.website.profil*') ? 'active' : '' }}" href="{{ route('admin.website.profil') }}">
          <span class="nav-item-icon"><i class="fa fa-school"></i></span> Kelola Profil
        </a>
        <a class="nav-item {{ request()->routeIs('admin.website.akademik*') ? 'active' : '' }}" href="{{ route('admin.website.akademik') }}">
          <span class="nav-item-icon"><i class="fa fa-book-open"></i></span> Kelola Akademik
        </a>
        <a class="nav-item {{ request()->routeIs('admin.website.fasilitas*') ? 'active' : '' }}" href="{{ route('admin.website.fasilitas') }}">
          <span class="nav-item-icon"><i class="fa fa-building-columns"></i></span> Kelola Fasilitas
        </a>
        <a class="nav-item {{ request()->routeIs('admin.website.ppdb*') ? 'active' : '' }}" href="{{ route('admin.website.ppdb') }}">
          <span class="nav-item-icon"><i class="fa fa-id-card"></i></span> Kelola PPDB
        </a>
        <a class="nav-item {{ request()->routeIs('admin.ppdb.*') ? 'active' : '' }}" href="{{ route('admin.ppdb.index') }}" style="padding-left: 32px; font-size: 13px;">
          <span class="nav-item-icon"><i class="fa fa-users"></i></span> Data Pendaftar PPDB
        </a>
        <a class="nav-item {{ request()->routeIs('admin.website.kontak*') ? 'active' : '' }}" href="{{ route('admin.website.kontak') }}">
          <span class="nav-item-icon"><i class="fa fa-address-book"></i></span> Kelola Kontak
        </a>

        <div class="nav-title">LIHAT WEBSITE PUBLIK</div>
        <a class="nav-item" href="{{ route('home') }}" target="_blank">
          <span class="nav-item-icon"><i class="fa fa-globe"></i></span> Buka Beranda Utama <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 10px; margin-left: 4px; opacity: 0.7;"></i>
        </a>
      </nav>

      <div class="sidebar-footer">
        <div class="school-art">📖</div>
        <p>Pendidikan adalah investasi terbaik untuk masa depan anak bangsa.</p>
      </div>
    </aside>

    <!-- Mobile Sidebar Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Main Content -->
    <main class="main">
      <header class="topbar">
        <div class="topbar-left-controls">
          <button class="menu-toggle-btn" id="sidebarToggleBtn" aria-label="Buka/Tutup Sidebar" title="Buka/Tutup Sidebar">
            <i class="fa-solid fa-bars"></i>
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
  <script src="{{asset('mentahan2/js/app.js')}}"></script>
  @yield('scripts')
</body>
</html>
