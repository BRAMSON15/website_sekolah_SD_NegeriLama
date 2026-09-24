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

    /* Responsive Header & Brand for Tablets & Mobile */
    @media (max-width: 768px) {
      .navbar {
        height: 68px !important;
        padding: 0 16px !important;
      }
      .brand {
        gap: 10px !important;
        text-decoration: none !important;
      }
      .brand-logo {
        width: 42px !important;
        height: 42px !important;
        border-radius: 10px !important;
        padding: 3px !important;
      }
      .brand-text strong {
        font-size: 1rem !important;
        line-height: 1.2 !important;
        white-space: nowrap !important;
      }
      .brand-text span {
        font-size: 0.65rem !important;
        letter-spacing: 0.5px !important;
        white-space: nowrap !important;
      }
      .btn-login {
        padding: 8px 16px !important;
        font-size: 0.85rem !important;
        border-radius: 8px !important;
        gap: 6px !important;
        white-space: nowrap !important;
      }
    }

    @media (max-width: 576px) {
      .navbar {
        height: 62px !important;
        padding: 0 12px !important;
      }
      .brand {
        gap: 8px !important;
        min-width: 0 !important;
      }
      .brand-logo {
        width: 38px !important;
        height: 38px !important;
        border-radius: 8px !important;
        padding: 2px !important;
      }
      .brand-text {
        min-width: 0 !important;
      }
      .brand-text strong {
        font-size: 0.85rem !important;
        line-height: 1.15 !important;
        letter-spacing: -0.2px !important;
        white-space: nowrap !important;
      }
      .brand-text span {
        font-size: 0.58rem !important;
        letter-spacing: 0.2px !important;
        line-height: 1.1 !important;
        white-space: nowrap !important;
      }
      .btn-login {
        padding: 6px 12px !important;
        font-size: 0.78rem !important;
        border-radius: 7px !important;
        gap: 5px !important;
        white-space: nowrap !important;
      }
      .btn-login i {
        font-size: 0.8rem !important;
      }
    }

    @media (max-width: 360px) {
      .navbar {
        height: 58px !important;
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
        font-size: 0.78rem !important;
      }
      .brand-text span {
        font-size: 0.52rem !important;
      }
      .btn-login {
        padding: 5px 10px !important;
        font-size: 0.72rem !important;
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
        <a class="btn-login" href="{{ route('dashboard') }}">
          <i class="fa-solid fa-gauge"></i> Dashboard
        </a>
      @else
        <a class="btn-login" href="{{ route('login') }}">
          <i class="fa-solid fa-right-to-bracket"></i> Portal Login
        </a>
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

      <div class="footer-col">
        <h4>Navigasi</h4>
        <ul>
          <li><a href="{{ route('home') }}">Beranda</a></li>
          <li><a href="{{ route('profil') }}">Profil Sekolah</a></li>
          <li><a href="{{ route('akademik') }}">Akademik</a></li>
          <li><a href="{{ route('ppdb') }}">Informasi PPDB</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Layanan</h4>
        <ul>
          <li><a href="#">Portal Siswa</a></li>
          <li><a href="#">Portal Guru</a></li>
          <li><a href="#">Perpustakaan Online</a></li>
          <li><a href="#">E-Learning</a></li>
        </ul>
      </div>

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
