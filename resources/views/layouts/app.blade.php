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
    </div>
  </header>

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

</body>
</html>
