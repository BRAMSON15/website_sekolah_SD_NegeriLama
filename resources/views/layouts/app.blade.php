<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'SD Negeri Lama')</title>
  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="{{ asset('mentahan2/img/Logo1.svg') }}">
  <link rel="alternate icon" type="image/png" href="{{ asset('mentahan2/img/Logo1.png') }}">
  <link rel="shortcut icon" href="{{ asset('mentahan2/img/Logo1.png') }}">

  <!-- Google Fonts & FontAwesome -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{asset('mentahan/css/style2.css')}}">
  <style>
    html, body {
      overflow-x: hidden;
      max-width: 100%;
    }
    .brand-logo {
      width: 48px;
      height: 48px;
      background: #ffffff !important;
      border: 1px solid var(--border);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      padding: 4px;
      flex-shrink: 0;
    }
    .brand-logo img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      display: block;
    }
    .page-header {
      background-image: linear-gradient(rgba(15, 23, 42, 0.58), rgba(30, 64, 175, 0.58)), url('{{ asset('mentahan2/img/image1.png') }}') !important;
      background-size: cover !important;
      background-position: center !important;
      background-repeat: no-repeat !important;
      color: #ffffff !important;
    }
    .page-header h1 {
      color: #ffffff !important;
      text-shadow: 0 2px 8px rgba(15, 23, 42, 0.55);
    }
    .page-header p {
      color: #eff0f0 !important;
      text-shadow: 0 1px 4px rgba(15, 23, 42, 0.55);
    }

    /* Header Action Controls */
    .nav-actions {
      display: flex !important;
      align-items: center !important;
      gap: 12px !important;
      flex-shrink: 0 !important;
      flex-wrap: nowrap !important;
    }

    /* Subpage Layout Grids */
    .kontak-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
    }
    .announcement-detail-grid {
      display: grid;
      grid-template-columns: 2.5fr 1fr;
      gap: 30px;
    }

    /* Responsive Header & Brand for Tablets & Mobile */
    @media (max-width: 768px) {
      .navbar {
        height: 64px !important;
        padding: 0 14px !important;
      }
      .brand {
        gap: 10px !important;
        min-width: 0 !important;
        flex: 1 !important;
        overflow: hidden !important;
        text-decoration: none !important;
      }
      .brand-logo {
        width: 40px !important;
        height: 40px !important;
        border-radius: 9px !important;
        padding: 3px !important;
        flex-shrink: 0 !important;
      }
      .brand-text {
        min-width: 0 !important;
        flex: 1 !important;
        overflow: hidden !important;
      }
      .brand-text strong {
        font-size: 0.92rem !important;
        line-height: 1.2 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
      }
      .brand-text span {
        font-size: 0.62rem !important;
        letter-spacing: 0.4px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
      }
      .nav-actions {
        gap: 8px !important;
        flex-shrink: 0 !important;
      }
      .nav-actions .btn-login {
        padding: 0 14px !important;
        height: 38px !important;
        font-size: 0.82rem !important;
        border-radius: 9px !important;
        gap: 6px !important;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
      }
    }

    @media (max-width: 576px) {
      .navbar {
        height: 60px !important;
        padding: 0 10px !important;
      }
      .brand {
        gap: 8px !important;
      }
      .brand-logo {
        width: 36px !important;
        height: 36px !important;
        border-radius: 8px !important;
        padding: 2px !important;
      }
      .brand-text strong {
        font-size: 0.82rem !important;
        line-height: 1.15 !important;
        letter-spacing: -0.2px !important;
      }
      .brand-text span {
        font-size: 0.54rem !important;
        letter-spacing: 0.2px !important;
      }
      .nav-actions {
        gap: 6px !important;
      }
      /* On mobile screens, hide text in header login button to prevent overlap & keep 36x36px icon */
      .nav-actions .btn-login {
        width: 36px !important;
        height: 36px !important;
        padding: 0 !important;
        border-radius: 8px !important;
        justify-content: center !important;
        gap: 0 !important;
      }
      .nav-actions .btn-login .btn-login-text {
        display: none !important;
      }
      .nav-actions .btn-login i {
        font-size: 0.95rem !important;
        margin: 0 !important;
      }
      .mobile-nav-toggle {
        width: 36px !important;
        height: 36px !important;
        font-size: 1rem !important;
        border-radius: 8px !important;
      }
    }

    @media (max-width: 360px) {
      .navbar {
        height: 56px !important;
        padding: 0 8px !important;
      }
      .brand {
        gap: 6px !important;
      }
      .brand-logo {
        width: 32px !important;
        height: 32px !important;
      }
      .brand-text strong {
        font-size: 0.76rem !important;
      }
      .brand-text span {
        font-size: 0.5rem !important;
      }
      .nav-actions .btn-login {
        width: 34px !important;
        height: 34px !important;
      }
      .mobile-nav-toggle {
        width: 34px !important;
        height: 34px !important;
        font-size: 0.9rem !important;
        border-radius: 6px !important;
      }
    }

    /* Comprehensive Mobile Adaptation for Beranda & Public Pages */
    @media (max-width: 768px) {
      .home-hero {
        padding: 40px 5% 60px !important;
        grid-template-columns: 1fr !important;
        gap: 24px !important;
      }
      .home-hero h1 {
        font-size: clamp(1.75rem, 6.5vw, 2.4rem) !important;
        line-height: 1.25 !important;
        margin-bottom: 14px !important;
      }
      .home-hero p {
        font-size: 0.95rem !important;
        line-height: 1.6 !important;
        margin-bottom: 22px !important;
      }
      .home-hero .hero-buttons {
        flex-direction: column !important;
        gap: 10px !important;
        width: 100% !important;
      }
      .home-hero .hero-buttons a {
        width: 100% !important;
        box-sizing: border-box !important;
        justify-content: center !important;
        text-align: center !important;
        padding: 12px 18px !important;
        font-size: 0.92rem !important;
      }
      .home-features {
        margin-top: 14px !important;
        padding: 0 5% !important;
      }
      .features-grid {
        grid-template-columns: 1fr !important;
        gap: 10px !important;
      }
      .features-grid > div {
        padding: 16px 14px !important;
        border-radius: 12px !important;
      }
      .principal-section {
        padding: 45px 5% !important;
      }
      .principal-grid {
        grid-template-columns: 1fr !important;
        gap: 24px !important;
      }
      .principal-grid > div:first-child > div {
        width: 220px !important;
        height: 250px !important;
        margin: 0 auto !important;
      }
      .principal-grid h2 {
        font-size: 1.45rem !important;
        line-height: 1.35 !important;
        margin-bottom: 12px !important;
      }
      .principal-grid p {
        font-size: 0.92rem !important;
        line-height: 1.7 !important;
        margin-bottom: 18px !important;
      }
      .information-section {
        padding: 45px 5% !important;
      }
      .information-section > div:first-child {
        margin-bottom: 24px !important;
      }
      .information-section h2 {
        font-size: 1.5rem !important;
      }
      .information-section p {
        font-size: 0.9rem !important;
      }
      .information-grid {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
      }
      .announcement-panel, .quick-access-panel {
        padding: 18px 14px !important;
        border-radius: 14px !important;
      }
      .announcement-item {
        padding: 12px 10px !important;
        gap: 12px !important;
      }
      .learning-media-section {
        padding: 45px 5% !important;
      }
      .learning-media-section > div:first-child {
        margin-bottom: 24px !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 14px !important;
      }
      .learning-media-section h2 {
        font-size: 1.5rem !important;
        line-height: 1.3 !important;
      }
      .learning-media-section p {
        font-size: 0.9rem !important;
      }
      .learning-filter-scroll {
        display: flex !important;
        gap: 8px !important;
        overflow-x: auto !important;
        width: 100% !important;
        padding-bottom: 6px !important;
        -webkit-overflow-scrolling: touch !important;
        flex-wrap: nowrap !important;
      }
      .learning-filter-scroll a {
        flex-shrink: 0 !important;
        padding: 8px 14px !important;
        font-size: 0.8rem !important;
        white-space: nowrap !important;
      }
      .learning-showcase-grid {
        grid-template-columns: 1fr !important;
        gap: 16px !important;
      }

      /* Subpage Layouts Mobile Adaptation (Kontak, Pengumuman, Fasilitas, PPDB, Akademik) */
      .page-header {
        padding: 42px 5% !important;
      }
      .page-header h1 {
        font-size: clamp(1.6rem, 5.5vw, 2.2rem) !important;
        margin-bottom: 8px !important;
      }
      .page-header p {
        font-size: 0.92rem !important;
        line-height: 1.5 !important;
      }
      .page-content {
        padding: 30px 4% !important;
      }
      .card-box {
        padding: 22px 18px !important;
        border-radius: 14px !important;
        margin-bottom: 20px !important;
      }
      .card-box iframe {
        max-width: 100% !important;
        width: 100% !important;
      }
      .kontak-grid,
      .announcement-detail-grid {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
      }
    }

    /* Mobile Navigation Dropdown & Toggle Button */
    .mobile-nav-toggle {
      display: none;
      width: 40px;
      height: 40px;
      padding: 0;
      border-radius: 9px;
      border: 1.5px solid #cbd5e1;
      background: #ffffff;
      color: #1e3a8a;
      font-size: 1.15rem;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      flex-shrink: 0;
      outline: none;
    }
    .mobile-nav-toggle:hover {
      background: #eff6ff;
      border-color: #3b82f6;
      color: #1d4ed8;
    }
    .mobile-nav-toggle.is-active {
      background: #1e3a8a;
      border-color: #1e3a8a;
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
    }
    .mobile-nav-toggle i {
      transition: transform 0.22s ease;
    }
    .mobile-nav-toggle.is-active i {
      transform: rotate(90deg);
    }

    .mobile-nav-dropdown {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      width: 100%;
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 2px solid #e2e8f0;
      box-shadow: 0 20px 30px -6px rgba(15, 23, 42, 0.18);
      z-index: 1005;
      overflow: hidden;
      max-height: 0;
      opacity: 0;
      pointer-events: none;
      transform: translateY(-8px);
      transition: max-height 0.32s cubic-bezier(0.4, 0, 0.2, 1), 
                  opacity 0.25s ease, 
                  transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .mobile-nav-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.48);
      backdrop-filter: blur(3px);
      -webkit-backdrop-filter: blur(3px);
      z-index: 999;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.25s ease;
    }

    @media (max-width: 768px) {
      .mobile-nav-toggle {
        display: inline-flex !important;
      }
      .mobile-nav-dropdown {
        display: block !important;
      }
      .mobile-nav-dropdown.is-open {
        max-height: 85vh;
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0);
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
      }
      .mobile-nav-overlay.is-visible {
        display: block !important;
        opacity: 1;
        pointer-events: auto;
      }
    }

    .mobile-nav-inner {
      padding: 14px 16px 18px;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .mobile-nav-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 4px 6px 10px;
      border-bottom: 1px solid #f1f5f9;
      margin-bottom: 4px;
      font-size: 0.76rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: #64748b;
    }
    .mobile-nav-header i {
      color: #3b82f6;
      margin-right: 4px;
    }
    .mobile-nav-school {
      font-size: 0.72rem;
      color: #94a3b8;
      font-weight: 600;
    }

    .mobile-nav-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 12px;
      border-radius: 12px;
      text-decoration: none;
      color: #1e293b;
      font-weight: 600;
      font-size: 0.92rem;
      transition: all 0.18s ease;
      background: transparent;
      border: 1px solid transparent;
    }
    .mobile-nav-link:hover {
      background: #f8fafc;
      border-color: #e2e8f0;
      color: #1d4ed8;
      transform: translateX(2px);
    }
    .mobile-nav-link.active {
      background: #eff6ff;
      border-color: #bfdbfe;
      color: #1d4ed8;
      font-weight: 700;
    }

    .mobile-nav-icon {
      width: 36px;
      height: 36px;
      border-radius: 9px;
      background: #f1f5f9;
      color: #3b82f6;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      flex-shrink: 0;
      transition: all 0.18s ease;
    }
    .mobile-nav-link:hover .mobile-nav-icon {
      background: #dbeafe;
      color: #1d4ed8;
    }
    .mobile-nav-link.active .mobile-nav-icon {
      background: #2563eb;
      color: #ffffff;
      box-shadow: 0 4px 10px rgba(37, 99, 235, 0.28);
    }
    .mobile-nav-link.ppdb-link .mobile-nav-icon {
      background: #ecfdf5;
      color: #059669;
    }
    .mobile-nav-link.ppdb-link.active .mobile-nav-icon {
      background: #059669;
      color: #ffffff;
    }

    .mobile-nav-text {
      display: flex;
      flex-direction: column;
      flex: 1;
      min-width: 0;
    }
    .mobile-nav-text .title {
      font-size: 0.92rem;
      line-height: 1.25;
      color: inherit;
    }
    .mobile-nav-text .desc {
      font-size: 0.72rem;
      color: #64748b;
      font-weight: 400;
      line-height: 1.2;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .mobile-nav-link.active .mobile-nav-text .desc {
      color: #3b82f6;
    }

    .mobile-nav-link .arrow-icon {
      font-size: 0.72rem;
      color: #94a3b8;
      margin-left: auto;
      transition: transform 0.18s ease;
    }
    .mobile-nav-link:hover .arrow-icon {
      transform: translateX(3px);
      color: #1d4ed8;
    }

    .mobile-nav-badge {
      margin-left: auto;
      background: #10b981;
      color: #ffffff;
      font-size: 0.68rem;
      font-weight: 700;
      padding: 3px 8px;
      border-radius: 20px;
      letter-spacing: 0.4px;
      text-transform: uppercase;
      box-shadow: 0 2px 6px rgba(16, 185, 129, 0.35);
    }

    .mobile-nav-divider {
      height: 1px;
      background: #e2e8f0;
      margin: 6px 0;
    }

    .mobile-nav-footer {
      padding-top: 4px;
    }
    .mobile-btn-portal {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      background: linear-gradient(135deg, #1e3a8a, #2563eb);
      color: #ffffff !important;
      font-weight: 700;
      font-size: 0.88rem;
      padding: 11px 16px;
      border-radius: 10px;
      text-decoration: none;
      box-shadow: 0 4px 14px rgba(37, 99, 235, 0.28);
      transition: all 0.2s ease;
    }
    .mobile-btn-portal:hover {
      background: linear-gradient(135deg, #172554, #1d4ed8);
      transform: translateY(-1px);
    }

    @media (max-width: 576px) {
      .mobile-nav-toggle {
        width: 35px !important;
        height: 35px !important;
        font-size: 1.05rem !important;
        border-radius: 8px !important;
      }
      .mobile-nav-inner {
        padding: 10px 12px 14px;
      }
      .mobile-nav-link {
        padding: 8px 10px;
        gap: 10px;
      }
      .mobile-nav-icon {
        width: 32px;
        height: 32px;
        font-size: 0.9rem;
      }
      .page-header {
        padding: 32px 4% !important;
      }
      .page-content {
        padding: 20px 3% !important;
      }
      .card-box {
        padding: 18px 14px !important;
      }
      .announcement-archive-item {
        gap: 12px !important;
      }
      .announcement-archive-badge {
        min-width: 60px !important;
        padding: 10px 8px !important;
      }
    }

    @media (max-width: 360px) {
      .mobile-nav-toggle {
        width: 30px !important;
        height: 30px !important;
        font-size: 0.9rem !important;
        border-radius: 6px !important;
      }
      .mobile-nav-text .desc {
        display: none;
      }
    }
  </style>
  @yield('styles')
</head>
<body>

  <!-- Top Bar -->
  <div class="top-bar">
    <div class="top-info">
      <span><i class="fa-solid fa-phone"></i> {{ $settings['phone'] ?? '(021) 555-0192' }}</span>
      <span><i class="fa-solid fa-envelope"></i> {{ $settings['email'] ?? 'info@sdnegerilama.sch.id' }}</span>
      <span><i class="fa-solid fa-location-dot"></i> {{ $settings['address'] ?? 'Jl. Pendidikan No. 45, Indonesia' }}</span>
    </div>
    <div class="social-links">
      <a href="{{ $settings['facebook'] ?? '#' }}"><i class="fa-brands fa-facebook"></i></a>
      <a href="{{ $settings['instagram'] ?? '#' }}"><i class="fa-brands fa-instagram"></i></a>
      <a href="{{ $settings['youtube'] ?? '#' }}"><i class="fa-brands fa-youtube"></i></a>
    </div>
  </div>

  <!-- Header / Navbar -->
  <header class="navbar">
    <a href="{{ route('home') }}" class="brand">
      <div class="brand-logo">
        <img src="{{ asset('mentahan2/img/Logo1.svg') }}?v={{ @filemtime(public_path('mentahan2/img/Logo1.svg')) ?: time() }}" alt="Logo {{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}" onerror="this.onerror=null; this.src='{{ asset('mentahan2/img/Logo1.png') }}';">
      </div>
      <div class="brand-text">
        <strong>{{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}</strong>
        <span>{{ $settings['school_tagline'] ?? 'UNGGUL & BERKARAKTER' }}</span>
      </div>
    </a>

    <nav class="nav-menu">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Beranda</a>
      <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil') ? 'active' : '' }}"><i class="fa-solid fa-school"></i> Profil</a>
      <a href="{{ route('akademik') }}" class="{{ request()->routeIs('akademik') ? 'active' : '' }}"><i class="fa-solid fa-book-open"></i> Akademik</a>
      <a href="{{ route('fasilitas') }}" class="{{ request()->routeIs('fasilitas') ? 'active' : '' }}"><i class="fa-solid fa-building"></i> Fasilitas</a>
      <a href="{{ route('ppdb') }}" class="{{ request()->routeIs('ppdb') ? 'active' : '' }}"><i class="fa-solid fa-user-plus"></i> PPDB</a>
      <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}"><i class="fa-solid fa-address-book"></i> Kontak</a>
    </nav>

    <div class="nav-actions">
      @auth
        <a class="btn-login" href="{{ route('dashboard') }}" title="Masuk Dashboard">
          <i class="fa-solid fa-gauge"></i>
          <span class="btn-login-text">Dashboard</span>
        </a>
      @else
        @if(!request()->routeIs('login'))
        <a class="btn-login" href="{{ route('login') }}" title="Portal Login">
          <i class="fa-solid fa-right-to-bracket"></i>
          <span class="btn-login-text">Portal Login</span>
        </a>
        @endif
      @endauth

      <!-- Mobile Menu Toggle Button -->
      <button type="button" class="mobile-nav-toggle" id="mobileNavToggle" aria-label="Buka Menu Navigasi" aria-expanded="false" title="Menu Navigasi">
        <i class="fa-solid fa-bars" id="mobileNavIcon"></i>
      </button>
    </div>

    <!-- Mobile Navigation Dropdown Tray -->
    <div class="mobile-nav-dropdown" id="mobileNavDropdown" aria-hidden="true">
      <div class="mobile-nav-inner">
        <div class="mobile-nav-header">
          <span><i class="fa-solid fa-compass"></i> Menu Navigasi</span>
          <span class="mobile-nav-school">{{ $settings['school_name'] ?? 'SD Negeri Lama' }}</span>
        </div>

        <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
          <div class="mobile-nav-icon"><i class="fa-solid fa-house"></i></div>
          <div class="mobile-nav-text">
            <span class="title">Beranda</span>
            <span class="desc">Halaman utama informasi sekolah</span>
          </div>
          <i class="fa-solid fa-chevron-right arrow-icon"></i>
        </a>

        <a href="{{ route('profil') }}" class="mobile-nav-link {{ request()->routeIs('profil') ? 'active' : '' }}">
          <div class="mobile-nav-icon"><i class="fa-solid fa-school"></i></div>
          <div class="mobile-nav-text">
            <span class="title">Profil Sekolah</span>
            <span class="desc">Visi, misi, sejarah, & kepemimpinan</span>
          </div>
          <i class="fa-solid fa-chevron-right arrow-icon"></i>
        </a>

        <a href="{{ route('akademik') }}" class="mobile-nav-link {{ request()->routeIs('akademik') ? 'active' : '' }}">
          <div class="mobile-nav-icon"><i class="fa-solid fa-book-open"></i></div>
          <div class="mobile-nav-text">
            <span class="title">Akademik & Kurikulum</span>
            <span class="desc">Kurikulum Merdeka & kegiatan belajar</span>
          </div>
          <i class="fa-solid fa-chevron-right arrow-icon"></i>
        </a>

        <a href="{{ route('fasilitas') }}" class="mobile-nav-link {{ request()->routeIs('fasilitas') ? 'active' : '' }}">
          <div class="mobile-nav-icon"><i class="fa-solid fa-building"></i></div>
          <div class="mobile-nav-text">
            <span class="title">Fasilitas Sarpras</span>
            <span class="desc">Lab komputer ANBK, perpus, & ruang kelas</span>
          </div>
          <i class="fa-solid fa-chevron-right arrow-icon"></i>
        </a>

        <a href="{{ route('ppdb') }}" class="mobile-nav-link ppdb-link {{ request()->routeIs('ppdb') ? 'active' : '' }}">
          <div class="mobile-nav-icon ppdb-icon"><i class="fa-solid fa-user-plus"></i></div>
          <div class="mobile-nav-text">
            <span class="title">PPDB Online</span>
            <span class="desc">Pendaftaran siswa baru & bukti cetak PDF</span>
          </div>
          <span class="mobile-nav-badge">Buka</span>
        </a>

        <a href="{{ route('kontak') }}" class="mobile-nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}">
          <div class="mobile-nav-icon"><i class="fa-solid fa-address-book"></i></div>
          <div class="mobile-nav-text">
            <span class="title">Kontak & Lokasi</span>
            <span class="desc">Alamat, telepon, email, & media sosial</span>
          </div>
          <i class="fa-solid fa-chevron-right arrow-icon"></i>
        </a>

        <div class="mobile-nav-divider"></div>

        <div class="mobile-nav-footer">
          @auth
            <a class="mobile-btn-portal" href="{{ route('dashboard') }}">
              <i class="fa-solid fa-gauge"></i> Masuk ke Dashboard
            </a>
          @else
            <a class="mobile-btn-portal" href="{{ route('login') }}">
              <i class="fa-solid fa-right-to-bracket"></i> Portal Login Guru & Admin
            </a>
          @endauth
        </div>
      </div>
    </div>
  </header>

  <!-- Mobile Backdrop Overlay -->
  <div class="mobile-nav-overlay" id="mobileNavOverlay"></div>

  <main>
    @yield('content')
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-grid">
      <div class="footer-brand">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
          <div style="width: 42px; height: 42px; background: #ffffff; border-radius: 10px; display: flex; align-items: center; justify-content: center; padding: 4px; overflow: hidden; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
            <img src="{{ asset('mentahan2/img/Logo1.svg') }}" alt="Logo {{ $settings['school_name'] ?? 'SD Negeri Lama' }}" style="width: 100%; height: 100%; object-fit: contain;">
          </div>
          <h3 style="margin: 0; font-size: 1.3rem; font-weight: 800; color: #ffffff;">{{ $settings['school_name'] ?? 'SD Negeri Lama' }}</h3>
        </div>
        <p>Sekolah Dasar unggulan yang mencetak generasi bertakwa, cerdas, berkarakter, dan siap menghadapi era digital.</p>
      </div>

      <!-- <div class="footer-col">
        <h4>Navigasi</h4>
        <ul>
          <li><a href="{{ route('home') }}">Beranda</a></li>
          <li><a href="{{ route('profil') }}">Profil Sekolah</a></li>
          <li><a href="{{ route('akademik') }}">Akademik</a></li>
          <li><a href="{{ route('ppdb') }}">Informasi PPDB</a></li>
        </ul>
      </div> -->

      <!-- <div class="footer-col">
        <h4>Layanan</h4>
        <ul>
          <li><a href="#">Portal Siswa</a></li>
          <li><a href="#">Portal Guru</a></li>
          <li><a href="#">Perpustakaan Online</a></li>
          <li><a href="#">E-Learning</a></li>
        </ul>
      </div> -->

      <div class="footer-col">
        <h4>Kontak Kami</h4>
        <ul>
          <li><i class="fa-solid fa-location-dot"></i> {{ $settings['address'] ?? 'Jl. Pendidikan No. 45' }}</li>
          <li><i class="fa-solid fa-phone"></i> {{ $settings['phone'] ?? '(021) 555-0192' }}</li>
          <li><i class="fa-solid fa-envelope"></i> {{ $settings['email'] ?? 'info@sdnegerilama.sch.id' }}</li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; {{ date('Y') }} {{ $settings['school_name'] ?? 'SD Negeri Lama' }}. All Rights Reserved.</p>
      <p>Maju Bersama Mendidik Bangsa</p>
    </div>
  </footer>

  <!-- Script for Mobile Navigation Dropdown Interactivity -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggleBtn = document.getElementById('mobileNavToggle');
      const navDropdown = document.getElementById('mobileNavDropdown');
      const navOverlay = document.getElementById('mobileNavOverlay');
      const navIcon = document.getElementById('mobileNavIcon');

      if (!toggleBtn || !navDropdown) return;

      function toggleMenu(forceState) {
        const shouldOpen = forceState !== undefined ? forceState : !navDropdown.classList.contains('is-open');

        if (shouldOpen) {
          navDropdown.classList.add('is-open');
          toggleBtn.classList.add('is-active');
          toggleBtn.setAttribute('aria-expanded', 'true');
          navDropdown.setAttribute('aria-hidden', 'false');
          if (navOverlay) navOverlay.classList.add('is-visible');
          if (navIcon) {
            navIcon.classList.remove('fa-bars');
            navIcon.classList.add('fa-xmark');
          }
        } else {
          navDropdown.classList.remove('is-open');
          toggleBtn.classList.remove('is-active');
          toggleBtn.setAttribute('aria-expanded', 'false');
          navDropdown.setAttribute('aria-hidden', 'true');
          if (navOverlay) navOverlay.classList.remove('is-visible');
          if (navIcon) {
            navIcon.classList.remove('fa-xmark');
            navIcon.classList.add('fa-bars');
          }
        }
      }

      // Toggle click
      toggleBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        toggleMenu();
      });

      // Overlay click to close
      if (navOverlay) {
        navOverlay.addEventListener('click', function () {
          toggleMenu(false);
        });
      }

      // Close when clicking outside of navbar & dropdown
      document.addEventListener('click', function (e) {
        if (!navDropdown.contains(e.target) && !toggleBtn.contains(e.target)) {
          toggleMenu(false);
        }
      });

      // Close on Escape key press
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && navDropdown.classList.contains('is-open')) {
          toggleMenu(false);
        }
      });

      // Auto close when clicking any navigation link inside dropdown
      const links = navDropdown.querySelectorAll('a');
      links.forEach(function (link) {
        link.addEventListener('click', function () {
          toggleMenu(false);
        });
      });

      // Auto close if window resized above mobile breakpoint (768px)
      window.addEventListener('resize', function () {
        if (window.innerWidth > 768 && navDropdown.classList.contains('is-open')) {
          toggleMenu(false);
        }
      });
    });
  </script>
</body>
</html>
