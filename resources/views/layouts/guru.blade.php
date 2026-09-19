<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Guru - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('mentahan2/img/Logo1.svg') }}">
    <link rel="alternate icon" type="image/png" href="{{ asset('mentahan2/img/Logo1.png') }}">
    <link rel="shortcut icon" href="{{ asset('mentahan2/img/Logo1.png') }}">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Custom Mentahan2 Guru Stylesheet -->
    <link rel="stylesheet" href="{{ asset('mentahan2/css/style1.css') }}">
    
    <style>
        .logout-link-btn {
            color: #ef5350;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 8px;
            background: #fdf2f2;
            text-decoration: none;
            transition: 0.2s;
        }
        .logout-link-btn:hover {
            background: #fde8e8;
        }
    </style>
</head>

<body>

<div class="dashboard">

    <!-- ================= SIDEBAR ================= -->
    <aside class="sidebar">

        <div class="school-logo">
            <div class="logo-icon">
                <img src="{{ asset('mentahan2/img/Logo1.svg') }}?v={{ @filemtime(public_path('mentahan2/img/Logo1.svg')) ?: time() }}" alt="Logo {{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}" onerror="this.onerror=null; this.src='{{ asset('mentahan2/img/Logo1.png') }}';">
            </div>

            <div>
                <h2>{{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}</h2>
                <span>Bermutu • Berkarakter • Berprestasi</span>
            </div>
        </div>

        <nav class="menu">

            <a href="{{ route('guru.dashboard') }}" class="menu-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>

            <a href="#" class="menu-item">
                <i class="fa-solid fa-users"></i>
                <span>Kelas Saya</span>
            </a>

            <a href="#" class="menu-item">
                <i class="fa-solid fa-book"></i>
                <span>Materi Pembelajaran</span>
            </a>

            <a href="#" class="menu-item">
                <i class="fa-solid fa-circle-play"></i>
                <span>Video Edukasi</span>
            </a>

            <a href="#" class="menu-item">
                <i class="fa-solid fa-clipboard-check"></i>
                <span>Tugas & Penilaian</span>
            </a>

            <a href="#" class="menu-item">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Kalender Akademik</span>
            </a>

            <a href="{{ route('pengumuman.index') }}" class="menu-item">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Pengumuman Sekolah</span>
            </a>

        </nav>

        <div class="sidebar-quote">
            <p>
                "Mendidik hari ini,<br>
                untuk masa depan<br>
                yang lebih baik."
            </p>

            <div class="books">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

    </aside>


    <!-- ================= MAIN ================= -->
    <main class="main">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Cari kelas, materi, atau video...">
            </div>

            <div class="top-right">

                <div class="notification">
                    <i class="fa-regular fa-bell"></i>
                    <span>3</span>
                </div>

                <div class="profile">
                    <div class="profile-photo">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>

                    <div class="profile-info">
                        <strong>{{ Auth::user()->name }}</strong>
                        <small>{{ Auth::user()->subject ?: 'Guru Pengajar' }}</small>
                    </div>

                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <a href="#" class="logout-link-btn" onclick="event.preventDefault(); document.getElementById('logout-form-guru').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </a>
                <form id="logout-form-guru" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </div>

        </header>


        <!-- CONTENT -->
        <section class="content">
            @yield('content')
        </section>

    </main>

</div>

@yield('scripts')
</body>
</html>
