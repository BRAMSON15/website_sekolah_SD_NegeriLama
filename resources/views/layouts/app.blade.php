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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('mentahan2/css/style2.css') }}?v={{ filemtime(public_path('mentahan2/css/style2.css')) ?: time() }}">
  <link rel="stylesheet" href="{{ asset('mentahan2/css/app.css') }}?v={{ filemtime(public_path('mentahan2/css/app.css')) ?: time() }}">
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
      @auth
        @if(Auth::user()->role === 'siswa')
          <a href="{{ route('siswa.beranda') }}" class="{{ request()->routeIs('siswa.*') ? 'active' : '' }}" style="color: #2563eb; font-weight: 700;"><i class="fa-solid fa-graduation-cap"></i> Ruang Belajar</a>
        @endif
      @endauth
      <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil') ? 'active' : '' }}"><i class="fa-solid fa-school"></i> Profil</a>
      <a href="{{ route('akademik') }}" class="{{ request()->routeIs('akademik') ? 'active' : '' }}"><i class="fa-solid fa-book-open"></i> Akademik</a>
      <a href="{{ route('fasilitas') }}" class="{{ request()->routeIs('fasilitas') ? 'active' : '' }}"><i class="fa-solid fa-building"></i> Fasilitas</a>
      <a href="{{ route('ppdb') }}" class="{{ request()->routeIs('ppdb') ? 'active' : '' }}"><i class="fa-solid fa-user-plus"></i> PPDB</a>
      <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}"><i class="fa-solid fa-address-book"></i> Kontak</a>
    </nav>

    <div class="nav-actions">
      @auth
        @if(in_array(Auth::user()->role, ['kepala_sekolah', 'kepsek']))
          <a class="btn-login" href="{{ route('kepsek.dashboard') }}" title="Monitoring Kepala Sekolah" style="background: #0f172a; border-color: #334155;">
            <i class="fa-solid fa-user-tie"></i>
            <span class="btn-login-text">Monitoring Kepsek</span>
          </a>
        @elseif(Auth::user()->role === 'siswa')
          <a class="btn-login" href="{{ route('siswa.beranda') }}" title="Ruang Belajar Siswa">
            <i class="fa-solid fa-graduation-cap"></i>
            <span class="btn-login-text">Ruang Belajar</span>
          </a>
        @elseif(Auth::user()->role === 'guru')
          <a class="btn-login" href="{{ route('guru.dashboard') }}" title="Dashboard Guru">
            <i class="fa-solid fa-chalkboard-user"></i>
            <span class="btn-login-text">Portal Guru</span>
          </a>
        @else
          <a class="btn-login" href="{{ route('dashboard') }}" title="Masuk Dashboard">
            <i class="fa-solid fa-gauge"></i>
            <span class="btn-login-text">Dashboard</span>
          </a>
        @endif

        <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline-flex;">
          @csrf
          <button type="submit" class="btn-nav-logout" title="Keluar dari akun">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span class="btn-logout-text">Keluar</span>
          </button>
        </form>
      @else
        <a class="btn-login" href="{{ route('login.guru') }}" title="Portal Guru">
          <i class="fa-solid fa-right-to-bracket"></i>
          <span class="btn-login-text">Portal Guru</span>
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

        @auth
        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 10px 12px; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
          <div style="min-width: 0; flex: 1;">
            <div style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Masuk Sebagai:</div>
            <div style="font-size: 0.86rem; font-weight: 700; color: #1e3a8a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->name }}</div>
          </div>
          <span style="font-size: 0.7rem; font-weight: 800; background: #2563eb; color: #ffffff; padding: 2px 8px; border-radius: 999px;">{{ strtoupper(Auth::user()->role) }}</span>
        </div>
        @endauth

        <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
          <div class="mobile-nav-icon"><i class="fa-solid fa-house"></i></div>
          <div class="mobile-nav-text">
            <span class="title">Beranda</span>
            <span class="desc">Halaman utama informasi sekolah</span>
          </div>
          <i class="fa-solid fa-chevron-right arrow-icon"></i>
        </a>

        @auth
          @if(in_array(Auth::user()->role, ['kepala_sekolah', 'kepsek']))
          <a href="{{ route('kepsek.dashboard') }}" class="mobile-nav-link {{ request()->routeIs('kepsek.*') ? 'active' : '' }}" style="background: #f8fafc; border: 1px solid #cbd5e1;">
            <div class="mobile-nav-icon" style="background: #0f172a; color: #fff;"><i class="fa-solid fa-user-tie"></i></div>
            <div class="mobile-nav-text">
              <span class="title" style="color: #0f172a; font-weight: 800;">Monitoring Kepala Sekolah</span>
              <span class="desc">Supervisi guru, presensi, & media</span>
            </div>
            <i class="fa-solid fa-chevron-right arrow-icon" style="color: #0f172a;"></i>
          </a>
          @elseif(Auth::user()->role === 'siswa')
          <a href="{{ route('siswa.beranda') }}" class="mobile-nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}" style="background: #eff6ff; border: 1px solid #bfdbfe;">
            <div class="mobile-nav-icon" style="background: #2563eb; color: #fff;"><i class="fa-solid fa-graduation-cap"></i></div>
            <div class="mobile-nav-text">
              <span class="title" style="color: #1e40af; font-weight: 800;">Ruang Belajar Siswa</span>
              <span class="desc">Akses video edukasi & modul materi</span>
            </div>
            <i class="fa-solid fa-chevron-right arrow-icon" style="color: #2563eb;"></i>
          </a>
          @endif
        @endauth

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
            @if(in_array(Auth::user()->role, ['kepala_sekolah', 'kepsek']))
              <a class="mobile-btn-portal" href="{{ route('kepsek.dashboard') }}" style="background: #0f172a;">
                <i class="fa-solid fa-user-tie"></i> Monitoring Kepala Sekolah
              </a>
            @elseif(Auth::user()->role === 'siswa')
              <a class="mobile-btn-portal" href="{{ route('siswa.beranda') }}">
                <i class="fa-solid fa-graduation-cap"></i> Masuk Ruang Belajar Siswa
              </a>
            @elseif(Auth::user()->role === 'guru')
              <a class="mobile-btn-portal" href="{{ route('guru.dashboard') }}">
                <i class="fa-solid fa-chalkboard-user"></i> Masuk Portal Guru
              </a>
            @else
              <a class="mobile-btn-portal" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-gauge"></i> Masuk ke Dashboard
              </a>
            @endif

            <div style="margin-top: 8px;">
              <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px; background: #fef2f2; border: 1.5px solid #fecaca; color: #dc2626; font-weight: 700; font-size: 0.82rem; padding: 10px 12px; border-radius: 9px; cursor: pointer;">
                  <i class="fa-solid fa-right-from-bracket"></i> Keluar dari Akun
                </button>
              </form>
            </div>
          @else
            <a class="mobile-btn-portal" href="{{ route('login.guru') }}">
              <i class="fa-solid fa-right-to-bracket"></i> Portal Masuk Guru
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
  <script src="{{ asset('mentahan2/js/nav-mobile.js') }}?v={{ filemtime(public_path('mentahan2/js/nav-mobile.js')) ?: time() }}"></script>
  @yield('scripts')
</body>
</html>
