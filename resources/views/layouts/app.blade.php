<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'SD Negeri Lama')</title>
  <!-- Google Fonts & FontAwesome -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{asset('mentahan/css/style2.css')}}">
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
        <i class="fa-solid fa-graduation-cap"></i>
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
      <a class="btn-login" href="#">
        <i class="fa-solid fa-right-to-bracket"></i> Portal Login
      </a>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-grid">
      <div class="footer-brand">
        <h3><i class="fa-solid fa-graduation-cap"></i> {{ $settings['school_name'] ?? 'SD Negeri Lama' }}</h3>
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
