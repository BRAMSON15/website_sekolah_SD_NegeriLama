<!doctype html>
<html class="no-js" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard Admin - SD Negeri Lama')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- favicon ============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('mentahan2/nalika/img/favicon.ico') }}">
    <!-- Google Fonts ============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- FontAwesome & Nalika CSS ============================================ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/nalika-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/owl.transitions.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/meanmenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/morrisjs/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/scrollbar/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/metisMenu/metisMenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/metisMenu/metisMenu-vertical.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/calendar/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/calendar/fullcalendar.print.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mentahan2/nalika/css/responsive.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        .dashboard-map-frame {
            height: 432px;
            overflow: hidden;
            background: #d9e2e8;
        }

        .dashboard-map-frame iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        #ambon-map {
            width: 100%;
            height: 100%;
            min-height: 432px;
        }

        .admin-status-line {
            margin-top: 18px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, .08);
            color: #9da8bd;
            font-size: 12px;
        }

        .admin-quick-actions {
            display: flex;
            gap: 10px;
            margin-top: 16px;
        }

        .admin-quick-actions a {
            display: flex;
            flex: 1;
            min-height: 52px;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border: 1px solid rgba(255, 255, 255, .08);
            color: #fff;
            font-size: 11px;
        }

        .admin-quick-actions a:hover {
            border-color: #24caa1;
            color: #24caa1;
        }

        .admin-quick-actions i {
            color: #24caa1;
            font-size: 16px;
        }

        .admin-panel-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 16px;
        }

        .admin-panel-heading h4 {
            margin-bottom: 0;
        }

        .panel-eyebrow {
            display: block;
            margin-bottom: 6px;
            color: #24caa1;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .admin-profile-meta {
            display: grid;
            gap: 8px;
            margin: 0 0 18px;
            color: #8d93a8;
            font-size: 12px;
        }

        .admin-profile-meta i {
            width: 18px;
            color: #24caa1;
        }

        @media (max-width: 767px) {
            .dashboard-map-frame {
                height: 300px;
            }

            #ambon-map {
                min-height: 300px;
            }

            .admin-panel-heading {
                display: block;
            }

            .admin-panel-heading .btn {
                display: inline-block;
                margin-top: 12px;
            }

            .admin-quick-actions {
                display: block;
            }

            .admin-quick-actions a + a {
                margin-top: 8px;
            }
        }

        @media (min-width: 1170px) {
            .left-sidebar-pro,
            #sidebar {
                width: 240px;
            }

            #sidebar {
                min-width: 240px;
            }

            .all-content-wrapper {
                margin-left: 240px;
            }

            .mini-navbar .all-content-wrapper {
                margin-left: 80px;
            }
        }
    </style>

    <script src="{{ asset('mentahan2/nalika/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    @yield('styles')
</head>

<body>
    <!-- Left Sidebar Pro -->
    <div class="left-sidebar-pro">
        <nav id="sidebar" class="">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}"><img class="main-logo" src="{{ asset('mentahan2/nalika/img/logo/logo.png') }}" alt="" /></a>
                <strong><a href="{{ route('dashboard') }}"><img src="{{ asset('mentahan2/nalika/img/logo/logosn.png') }}" alt="" /></a></strong>
            </div>
            <div class="nalika-profile">
                <div class="profile-dtl">
                    <div style="width: 75px; height: 75px; background: #152036; border: 2px solid #242a33; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; color: #3b82f6; font-size: 32px;">
                        <i class="fa fa-user-circle"></i>
                    </div>
                    <h2>{{ Auth::user()->name }} <span class="min-dtn">({{ ucfirst(Auth::user()->role) }})</span></h2>
                </div>
                <div class="profile-social-dtl">
                    <ul class="dtl-social">
                        <li><a href="#"><i class="icon nalika-facebook"></i></a></li>
                        <li><a href="#"><i class="icon nalika-twitter"></i></a></li>
                        <li><a href="#"><i class="icon nalika-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="left-custom-menu-adp-wrap comment-scrollbar">
                <nav class="sidebar-nav left-sidebar-menu-pro">
                    <ul class="metismenu" id="menu1">
                        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a title="Dashboard" href="{{ route('dashboard') }}">
                                <i class="icon nalika-home icon-wrap"></i>
                                <span class="mini-click-non">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a title="Lihat Website" href="{{ route('home') }}" target="_blank">
                                <i class="icon nalika-earth icon-wrap"></i>
                                <span class="mini-click-non">Lihat Website</span>
                            </a>
                        </li>
                        <li>
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <i class="icon nalika-mail icon-wrap"></i>
                                <span class="mini-click-non">Kelola Informasi</span>
                            </a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="Pengumuman" href="{{ route('pengumuman.index') }}"><span class="mini-sub-pro">Pengumuman</span></a></li>
                                <li><a title="Keunggulan" href="{{ route('home') }}#akademik"><span class="mini-sub-pro">Fitur / Layanan</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>
    </div>

    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="logo-pro">
                        <a href="{{ route('dashboard') }}"><img class="main-logo" src="{{ asset('mentahan2/nalika/img/logo/logo.png') }}" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-advance-area">
            <div class="header-top-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="header-top-wraper">
                                <div class="row">
                                    <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                        <div class="menu-switcher-pro">
                                            <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                                <i class="icon nalika-menu-task"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                        <div class="header-top-menu tabl-d-n hd-search-rp">
                                            <div class="breadcome-heading">
                                                <form role="search" class="">
                                                    <input type="text" placeholder="Search..." class="form-control">
                                                    <a href=""><i class="fa fa-search"></i></a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                        <div class="header-right-info">
                                            <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                                <li class="nav-item">
                                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                                        <i class="icon nalika-user"></i>
                                                        <span class="admin-name">{{ Auth::user()->name }}</span>
                                                        <i class="icon nalika-down-arrow nalika-angle-dw"></i>
                                                    </a>
                                                    <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                                        <li><a href="{{ route('home') }}" target="_blank"><span class="icon nalika-home author-log-ic"></span> Lihat Website</a></li>
                                                        <li>
                                                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                                <span class="icon nalika-unlocked author-log-ic"></span> Log Out
                                                            </a>
                                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                @csrf
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Breadcome area -->
            <div class="breadcome-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="breadcomb-wp">
                                            <div class="breadcomb-icon">
                                                <i class="icon nalika-home"></i>
                                            </div>
                                            <div class="breadcomb-ctn">
                                                <h2>Dashboard Management</h2>
                                                <p>Selamat datang di Panel Admin <span class="bread-ntd">{{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="section-admin container-fluid">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="footer-copyright-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-copy-right">
                            <p>Copyright © {{ date('Y') }} {{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}. Template Nalika Bootstrap Admin.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts ============================================ -->
    <script src="{{ asset('mentahan2/nalika/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/wow.min.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/jquery-price-slider.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/jquery.meanmenu.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/scrollbar/mCustomScrollbar-active.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/metisMenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/metisMenu/metisMenu-active.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/sparkline/jquery.charts-sparkline.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/calendar/moment.min.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/calendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/calendar/fullcalendar-active.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/flot/curvedLines.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/flot/flot-active.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/plugins.js') }}"></script>
    <script src="{{ asset('mentahan2/nalika/js/main.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @yield('scripts')
</body>

</html>
