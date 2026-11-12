<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Monitoring Guru - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))</title>

  <link rel="icon" type="image/svg+xml" href="{{ asset('mentahan2/img/Logo1.svg') }}">
  <link rel="alternate icon" type="image/png" href="{{ asset('mentahan2/img/Logo1.png') }}">
  <link rel="shortcut icon" href="{{ asset('mentahan2/img/Logo1.png') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <!-- Tailwind CSS (Vite) -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    :root {
      --mon-primary: #1769d9;
      --mon-ink: #0f172a;
      --mon-muted: #64748b;
      --mon-line: #e2e8f0;
    }

    body {
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', sans-serif;
      background: #f4f7fb;
      color: var(--mon-ink);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .mon-topbar {
      position: sticky;
      top: 0;
      z-index: 1030;
      background: #ffffff;
      border-bottom: 1px solid var(--mon-line);
      box-shadow: 0 6px 18px -14px rgba(15, 23, 42, 0.35);
    }

    .mon-topbar-inner {
      display: flex;
      align-items: center;
      gap: 14px;
      min-height: 66px;
      padding: 8px 20px;
      max-width: 1440px;
      margin: 0 auto;
    }

    .mon-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      color: var(--mon-ink);
      flex-shrink: 0;
    }

    .mon-brand img {
      width: 38px;
      height: 38px;
      object-fit: contain;
    }

    .mon-brand strong {
      display: block;
      font-size: 0.94rem;
      font-weight: 800;
      line-height: 1.15;
    }

    .mon-brand small {
      display: block;
      font-size: 0.66rem;
      font-weight: 700;
      letter-spacing: 0.06em;
      color: var(--mon-muted);
      text-transform: uppercase;
    }

    .mon-nav {
      display: flex;
      align-items: center;
      gap: 4px;
      margin-left: 8px;
      overflow-x: auto;
      scrollbar-width: none;
    }

    .mon-nav::-webkit-scrollbar {
      display: none;
    }

    .mon-nav a {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 8px 13px;
      border-radius: 9px;
      font-size: 0.82rem;
      font-weight: 600;
      color: #475569;
      text-decoration: none;
      white-space: nowrap;
      transition: background 0.15s ease, color 0.15s ease;
    }

    .mon-nav a:hover {
      background: #eff6ff;
      color: var(--mon-primary);
    }

    .mon-nav a.active {
      background: #e8f0fe;
      color: var(--mon-primary);
      font-weight: 700;
    }

    .mon-user {
      display: flex;
      align-items: center;
      gap: 9px;
      margin-left: auto;
      flex-shrink: 0;
    }

    .mon-avatar {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      display: grid;
      place-items: center;
      background: linear-gradient(135deg, #1769d9, #8c6ce5);
      color: #ffffff;
      font-size: 0.8rem;
      font-weight: 800;
      text-transform: uppercase;
    }

    .mon-user-text {
      line-height: 1.15;
    }

    .mon-user-text strong {
      display: block;
      font-size: 0.8rem;
      font-weight: 700;
    }

    .mon-user-text small {
      font-size: 0.68rem;
      color: var(--mon-muted);
      text-transform: capitalize;
    }

    .mon-logout {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 12px;
      border-radius: 8px;
      border: 1px solid #fecaca;
      background: #fef2f2;
      color: #dc2626;
      font-size: 0.78rem;
      font-weight: 700;
      cursor: pointer;
      transition: background 0.15s ease;
    }

    .mon-logout:hover {
      background: #fee2e2;
    }

    .mon-main {
      flex: 1;
      width: 100%;
    }

    .mon-footer {
      padding: 16px 20px;
      text-align: center;
      font-size: 0.75rem;
      color: var(--mon-muted);
      border-top: 1px solid var(--mon-line);
      background: #ffffff;
    }

    .mon-footer a {
      color: var(--mon-primary);
      text-decoration: none;
      font-weight: 600;
    }

    @media (max-width: 991.98px) {
      .mon-topbar-inner {
        flex-wrap: wrap;
        padding: 8px 14px;
      }

      .mon-nav {
        order: 3;
        width: 100%;
        margin-left: 0;
        padding-bottom: 4px;
      }

      .mon-brand small {
        display: none;
      }
    }

    @media (max-width: 575.98px) {
      .mon-user-text {
        display: none;
      }

      .mon-logout span {
        display: none;
      }
    }
  </style>

  @stack('styles')
</head>
<body>
  <header class="mon-topbar">
    <div class="mon-topbar-inner">
      <a href="{{ route('kepsek.dashboard') }}" class="mon-brand">
        <img src="{{ asset('mentahan2/img/Logo1.svg') }}" alt="Logo {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}" onerror="this.onerror=null; this.src='{{ asset('mentahan2/img/Logo1.png') }}';">
        <span>
          <strong>{{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}</strong>
          <small>Monitoring Kepala Sekolah</small>
        </span>
      </a>

      <nav class="mon-nav" aria-label="Navigasi monitoring">
        <a href="{{ route('kepsek.dashboard') }}" class="{{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}">
          <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>
        <a href="{{ route('kepsek.monitoring.activity') }}" class="{{ request()->routeIs('kepsek.monitoring.activity') ? 'active' : '' }}">
          <i class="fa-solid fa-wave-square"></i> Aktivitas Guru
        </a>
        <a href="{{ route('kepsek.monitoring.performance') }}" class="{{ request()->routeIs('kepsek.monitoring.performance') ? 'active' : '' }}">
          <i class="fa-solid fa-chart-line"></i> Performa Guru
        </a>
        <a href="{{ route('home') }}" target="_blank" rel="noopener">
          <i class="fa-solid fa-globe"></i> Website
          <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 9px; opacity: 0.65;"></i>
        </a>
      </nav>

      <div class="mon-user">
        <div class="mon-avatar" aria-hidden="true">{{ mb_substr(Auth::user()->name ?? 'K', 0, 1) }}</div>
        <div class="mon-user-text">
          <strong>{{ Auth::user()->name ?? 'Kepala Sekolah' }}</strong>
          <small>{{ str_replace('_', ' ', Auth::user()->role ?? 'kepala sekolah') }}</small>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
          @csrf
          <button type="submit" class="mon-logout" title="Keluar dari akun">
            <i class="fa-solid fa-right-from-bracket"></i> <span>Keluar</span>
          </button>
        </form>
      </div>
    </div>
  </header>

  <main class="mon-main">
    @yield('content')
  </main>

  <footer class="mon-footer">
    &copy; {{ date('Y') }} {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }} &middot;
    <a href="{{ route('home') }}">Kembali ke website sekolah</a>
  </footer>

  @stack('scripts')
</body>
</html>
