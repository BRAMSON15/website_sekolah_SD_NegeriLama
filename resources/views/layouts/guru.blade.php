<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Guru - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))</title>

    <!-- Anti-Flicker Preload Script for Sidebar -->
    <script>
        (function () {
            try {
                var closed = localStorage.getItem('sd_guru_sidebar_closed');
                if (closed === 'true' && window.innerWidth >= 993) {
                    document.documentElement.classList.add('sidebar-closed');
                    if (document.body) {
                        document.body.classList.add('sidebar-closed');
                    }
                }
            } catch (e) {}
        })();
    </script>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('mentahan2/img/Logo1.svg') }}">
    <link rel="alternate icon" type="image/png" href="{{ asset('mentahan2/img/Logo1.png') }}">
    <link rel="shortcut icon" href="{{ asset('mentahan2/img/Logo1.png') }}">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome & Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Mentahan2 Guru Stylesheet -->
    <link rel="stylesheet" href="{{ asset('mentahan2/css/style1.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/css/guru.css') }}">

    @yield('styles')
</head>

<body>

<div class="dashboard">

    <!-- ================= SIDEBAR ================= -->
    <aside class="sidebar" id="guruSidebar">

        <div class="school-logo">
            <div class="logo-icon">
                <img src="{{ asset('mentahan2/img/Logo1.svg') }}?v={{ @filemtime(public_path('mentahan2/img/Logo1.svg')) ?: time() }}" alt="Logo {{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}" onerror="this.onerror=null; this.src='{{ asset('mentahan2/img/Logo1.png') }}';">
            </div>

            <div style="flex: 1; min-width: 0;">
                <h2 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}</h2>
                <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;">Bermutu • Berkarakter • Berprestasi</span>
            </div>

            <button type="button" class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Tutup Sidebar" title="Tutup Sidebar">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
        </div>

        <nav class="menu">

            <a href="{{ route('guru.dashboard') }}" class="menu-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('guru.materi') }}" class="menu-item {{ request()->routeIs('guru.materi*') ? 'active' : '' }}">
                <i class="fa-solid fa-book"></i>
                <span>Materi Pembelajaran</span>
            </a>

            <a href="{{ route('guru.video') }}" class="menu-item {{ request()->routeIs('guru.video*') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-play"></i>
                <span>Video Edukasi</span>
            </a>

            <a href="{{ route('guru.pengumuman') }}" class="menu-item {{ request()->routeIs('guru.pengumuman*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Pengumuman Sekolah</span>
            </a>

            <div style="font-size: 10px; font-weight: 700; letter-spacing: 0.8px; color: #8ba9d3; margin: 18px 16px 6px; text-transform: uppercase;">
                WEBSITE SEKOLAH
            </div>

            <a href="{{ route('home') }}" class="menu-item" target="_blank">
                <i class="fa-solid fa-globe"></i>
                <span>Beranda Utama</span>
                <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 11px; margin-left: auto; opacity: 0.7;"></i>
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

    <!-- Mobile Sidebar Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>


    <!-- ================= MAIN ================= -->
    <main class="main">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left-wrap">
                <button type="button" class="menu-toggle-btn" id="sidebarToggleBtn" aria-label="Buka/Tutup Sidebar" title="Buka/Tutup Sidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Cari kelas, materi, atau video...">
                </div>
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

<!-- Sidebar Toggle Controller Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const body = document.body;
        const toggleBtn = document.getElementById("sidebarToggleBtn");
        const closeBtn = document.getElementById("sidebarCloseBtn");
        const backdrop = document.getElementById("sidebarBackdrop");
        const STORAGE_KEY = "sd_guru_sidebar_closed";

        // Initial check for desktop
        if (window.innerWidth >= 993) {
            const isClosed = localStorage.getItem(STORAGE_KEY) === "true";
            if (isClosed) {
                body.classList.add("sidebar-closed");
            } else {
                body.classList.remove("sidebar-closed");
            }
        }

        function toggleSidebar() {
            if (window.innerWidth >= 993) {
                // Desktop toggle
                const willClose = !body.classList.contains("sidebar-closed");
                body.classList.toggle("sidebar-closed", willClose);
                localStorage.setItem(STORAGE_KEY, willClose ? "true" : "false");
            } else {
                // Mobile toggle
                const willOpen = !body.classList.contains("sidebar-open");
                body.classList.toggle("sidebar-open", willOpen);
                if (backdrop) {
                    backdrop.classList.toggle("active", willOpen);
                }
            }
        }

        function closeSidebar() {
            if (window.innerWidth >= 993) {
                body.classList.add("sidebar-closed");
                localStorage.setItem(STORAGE_KEY, "true");
            } else {
                body.classList.remove("sidebar-open");
                if (backdrop) {
                    backdrop.classList.remove("active");
                }
            }
        }

        if (toggleBtn) {
            toggleBtn.addEventListener("click", function (e) {
                e.stopPropagation();
                toggleSidebar();
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener("click", function (e) {
                e.stopPropagation();
                closeSidebar();
            });
        }

        if (backdrop) {
            backdrop.addEventListener("click", function () {
                closeSidebar();
            });
        }

        // Close on Escape key
        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape") {
                if (body.classList.contains("sidebar-open")) {
                    closeSidebar();
                }
            }
        });

        // Window resize handler
        let resizeTimer;
        window.addEventListener("resize", function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                if (window.innerWidth >= 993) {
                    if (backdrop) backdrop.classList.remove("active");
                    body.classList.remove("sidebar-open");
                    const isClosed = localStorage.getItem(STORAGE_KEY) === "true";
                    body.classList.toggle("sidebar-closed", isClosed);
                } else {
                    body.classList.remove("sidebar-closed");
                }
            }, 100);
        });
    });
</script>

@yield('scripts')
</body>
</html>
