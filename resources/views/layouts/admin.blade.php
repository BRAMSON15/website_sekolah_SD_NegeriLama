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

  <style>
    /* Anti-flicker preload state */
    html.sidebar-closed-preload .sidebar {
      transform: translateX(-100%) !important;
      transition: none !important;
    }
    html.sidebar-closed-preload .main {
      margin-left: 0 !important;
      width: 100% !important;
      transition: none !important;
    }

    /* Custom enhancements for responsiveness & theme integration */
    .brand {
      position: relative;
    }
    .brand-logo {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      background: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
      flex-shrink: 0;
      overflow: hidden;
      padding: 4px;
    }
    .brand-logo img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      display: block;
    }
    .brand-title-wrap {
      flex: 1;
      min-width: 0;
    }
    .brand-title-wrap h2 {
      font-size: 15px;
      font-weight: 700;
      color: #ffffff;
      margin: 0 0 2px 0;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .brand-title-wrap span {
      font-size: 10px;
      color: #9eb6d6;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      display: block;
    }
    .sidebar-close-btn {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.12);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: #ffffff;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      cursor: pointer;
      margin-left: auto;
      flex-shrink: 0;
      transition: all 0.2s ease;
    }
    .sidebar-close-btn:hover {
      background: rgba(255, 255, 255, 0.25);
      color: #ffffff;
      transform: scale(1.05);
    }
    .sidebar-close-btn:active {
      transform: scale(0.95);
    }
    .nav-item-icon {
      font-size: 16px;
      width: 22px;
      text-align: center;
      display: inline-block;
    }
    .user-avatar-circle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #2676df;
      color: #fff;
      display: grid;
      place-items: center;
      font-size: 18px;
      font-weight: 700;
    }
    .topbar-right-controls {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .logout-btn-link {
      color: #ef5350;
      font-size: 13px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 6px 12px;
      border-radius: 8px;
      background: #fdf2f2;
      transition: background 0.2s ease;
    }
    .logout-btn-link:hover {
      background: #fde8e8;
      color: #d32f2f;
    }
    .dashboard-map-container {
      position: relative;
      width: 100%;
      height: 380px;
      border-radius: 14px;
      overflow: hidden;
      margin-top: 15px;
      border: 1px solid var(--line);
      background: #f1f5fc;
      isolation: isolate; /* Traps Leaflet's high z-index inside this container */
      z-index: 1; /* Always beneath sidebar and topbar */
      transform: translateZ(0); /* Fixes border-radius clipping with CSS 3D transforms */
      contain: paint;
    }
    #ambon-map {
      width: 100%;
      height: 100%;
      z-index: 1;
    }
    .dashboard-map-container .leaflet-pane,
    .dashboard-map-container .leaflet-top,
    .dashboard-map-container .leaflet-bottom {
      z-index: 2 !important;
    }
    .dashboard-map-container .leaflet-popup-pane {
      z-index: 5 !important;
    }
    .dashboard-map-container .leaflet-control {
      z-index: 6 !important;
    }
    
    /* Legacy Nalika Subpages Compatibility CSS */
    .information-home { padding: 5px 0 30px; }
    .information-hero {
      min-height: 140px;
      border-radius: 16px;
      padding: 25px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      overflow: hidden;
      background-image: linear-gradient(rgba(15, 23, 42, 0.58), rgba(30, 64, 175, 0.58)), url('{{ asset('mentahan2/img/image1.png') }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      border: 1px solid #d9eafa;
      margin-bottom: 22px;
      position: relative;
    }
    .information-hero h2 { font-size: 24px; color: #ffffff; margin-bottom: 6px; font-weight: 700; }
    .information-hero p { color: #eff0f0; font-size: 14px; margin: 0; line-height: 1.6; }
    .information-hero-icon { font-size: 55px; color: #ffffff; opacity: 0.85; }
    .panel-eyebrow { font-size: 10px; font-weight: 700; letter-spacing: 0.8px; color: #1769d9; display: block; margin-bottom: 5px; }
    .information-hero .panel-eyebrow { color: #93c5fd; }
    .hero {
      background-image: linear-gradient(rgba(15, 23, 42, 0.58), rgba(30, 64, 175, 0.58)), url('{{ asset('mentahan2/img/image1.png') }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    /* Enhanced Bootstrap Icons in Stat Cards & Features */
    .stat-icon {
      font-size: 22px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.14);
    }
    .stat-icon i {
      font-size: 22px !important;
      line-height: 1 !important;
      display: inline-flex !important;
      align-items: center;
      justify-content: center;
    }
    .stat-card .arrow {
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
    }
    .feature-icon {
      font-size: 24px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
    }
    .feature-icon i {
      font-size: 24px !important;
      line-height: 1 !important;
    }
    .feature > b {
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
    }
    .mini-icon {
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
    }
    .mini-icon i {
      line-height: 1 !important;
    }

    .information-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px; }
    .information-stat-card {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 15px;
      padding: 20px;
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .information-stat-icon {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      display: grid;
      place-items: center;
      color: #fff;
      font-size: 20px;
      flex-shrink: 0;
    }
    .information-stat-icon-green { background: #45bd8d; }
    .information-stat-icon-blue { background: #1769d9; }
    .information-stat-icon-purple { background: #8c6ce5; }
    .information-stat-card span { display: block; font-size: 13px; color: #42618a; margin-bottom: 4px; }
    .information-stat-card strong { display: block; font-size: 24px; color: #122f58; }
    .information-stat-card small { color: #8097b5; font-size: 11px; }

    .information-panels { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 25px; }
    .information-panel {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 15px;
      padding: 22px;
      margin-bottom: 25px;
    }
    .information-panel-heading {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 18px;
      padding-bottom: 14px;
      border-bottom: 1px solid var(--line);
    }
    .information-panel-heading h3, .information-panel-heading h4 { font-size: 17px; color: #122f58; margin: 0; }
    .information-panel-heading p { font-size: 12px; color: #7390b5; margin-top: 3px; }

    .information-list-item, .information-feature-item {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 14px 0;
      border-bottom: 1px solid #edf2f8;
    }
    .information-list-item:last-child, .information-feature-item:last-child { border-bottom: none; }
    .information-list-icon {
      width: 40px;
      height: 40px;
      border-radius: 12px;
      background: #e5f0ff;
      color: #1769d9;
      display: grid;
      place-items: center;
      font-size: 16px;
      flex-shrink: 0;
    }
    .information-list-content { flex: 1; }
    .information-list-content h4, .information-feature-item h4 { font-size: 14px; color: #17345e; margin: 0 0 4px 0; }
    .information-list-content span, .information-feature-item p { font-size: 11px; color: #7390b5; margin: 0; }

    .information-status {
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 600;
    }
    .information-status-active { background: #def8ef; color: #07866a; }
    .information-status-muted { background: #f1f5fc; color: #7790b3; }

    .information-panel-footer {
      display: inline-block;
      margin-top: 15px;
      font-size: 12px;
      font-weight: 600;
      color: #1769d9;
    }

    /* Buttons & Form Controls */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      border-radius: 9px;
      font-size: 13px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: 0.2s;
      text-decoration: none;
    }
    .btn-primary { background: #1769d9; color: #fff; }
    .btn-primary:hover { background: #1254b3; }
    .btn-grey { background: #f1f6fc; color: #17345e; border: 1px solid var(--line); }
    .btn-grey:hover { background: #e2ecf8; }
    .btn-danger { background: #ef5350; color: #fff; }
    .btn-danger:hover { background: #d32f2f; }
    .btn-xs { padding: 5px 10px; font-size: 11px; border-radius: 6px; }

    /* Table Styles with Mobile Smooth Scroll */
    .table-responsive {
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      display: block;
      margin-bottom: 12px;
      border-radius: 10px;
    }
    table {
      width: 100%;
      min-width: 580px;
      border-collapse: collapse;
      margin-top: 8px;
    }
    th { text-align: left; padding: 12px 14px; font-size: 12px; color: #7390b5; border-bottom: 1px solid var(--line); background: #f8fafc; font-weight: 700; }
    td { padding: 13px 14px; font-size: 13px; color: #17345e; border-bottom: 1px solid #edf2f8; vertical-align: middle; }
    tr:hover td { background: #fcfdfe; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .action-cell form { display: inline-block; margin-left: 4px; }
    .table-subtext { display: block; font-size: 11px; color: #8aa0bc; margin-top: 3px; }
    .feature-table-icon { display: inline-grid; width: 32px; height: 32px; place-items: center; border-radius: 8px; margin-right: 10px; vertical-align: middle; }

    /* Form Styles */
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #17345e; margin-bottom: 6px; }
    .form-control { width: 100%; padding: 10px 14px; border-radius: 9px; border: 1px solid var(--line); background: #fdfefe; font-size: 13px; color: #17345e; outline: none; box-sizing: border-box; }
    .form-control:focus { border-color: #1769d9; box-shadow: 0 0 0 3px rgba(23,105,217,0.1); }
    .form-hint { font-size: 11px; color: #7390b5; margin-top: 4px; display: block; }
    .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; }
    .checkbox { margin-top: 15px; font-size: 13px; color: #17345e; }

    /* Bootstrap-Compatible Responsive Grid System */
    .row {
      display: flex;
      flex-wrap: wrap;
      margin-right: -10px;
      margin-left: -10px;
    }
    .row > [class*="col-"] {
      position: relative;
      width: 100%;
      padding-right: 10px;
      padding-left: 10px;
      box-sizing: border-box;
    }
    .col-12 { flex: 0 0 100%; max-width: 100%; }
    @media (min-width: 576px) {
      .col-sm-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
      .col-sm-6 { flex: 0 0 50%; max-width: 50%; }
      .col-sm-12 { flex: 0 0 100%; max-width: 100%; }
    }
    @media (min-width: 768px) {
      .col-md-3 { flex: 0 0 25%; max-width: 25%; }
      .col-md-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
      .col-md-5 { flex: 0 0 41.666667%; max-width: 41.666667%; }
      .col-md-6 { flex: 0 0 50%; max-width: 50%; }
      .col-md-7 { flex: 0 0 58.333333%; max-width: 58.333333%; }
      .col-md-8 { flex: 0 0 66.666667%; max-width: 66.666667%; }
      .col-md-12 { flex: 0 0 100%; max-width: 100%; }
    }
    @media (min-width: 992px) {
      .col-lg-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
      .col-lg-5 { flex: 0 0 41.666667%; max-width: 41.666667%; }
      .col-lg-7 { flex: 0 0 58.333333%; max-width: 58.333333%; }
      .col-lg-8 { flex: 0 0 66.666667%; max-width: 66.666667%; }
    }

    /* Prevention of horizontal page overflow */
    html, body {
      max-width: 100vw;
      overflow-x: hidden;
    }
    .app {
      max-width: 100vw;
      overflow-x: hidden;
      min-height: 100vh;
    }
    .main {
      min-width: 0;
      max-width: 100%;
    }
    .content {
      min-width: 0;
      max-width: 100%;
    }
    .two-columns, .panel {
      min-width: 0;
      max-width: 100%;
    }

    /* Sidebar and Topbar transition & layout */
    .sidebar {
      position: fixed;
      left: 0;
      top: 0;
      bottom: 0;
      width: 290px;
      transform: translateX(0);
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      z-index: 1050 !important;
    }
    .topbar {
      z-index: 1000 !important;
    }
    .main {
      margin-left: 290px;
      width: calc(100% - 290px);
      min-width: 0;
      max-width: 100%;
      transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Topbar Controls & Toggle Button */
    .topbar-left-controls {
      display: flex;
      align-items: center;
      gap: 12px;
      flex: 1;
      max-width: 520px;
    }
    .topbar-left-controls .search {
      flex: 1;
      width: auto;
      max-width: 460px;
    }

    /* Hamburger Menu Toggle Button */
    .menu-toggle-btn {
      display: inline-flex !important;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: #f1f6fc;
      border: 1px solid var(--line);
      color: #17345e;
      font-size: 16px;
      cursor: pointer;
      flex-shrink: 0;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .menu-toggle-btn:hover {
      background: #e2ecf8;
      color: #1769d9;
      transform: translateY(-1px);
      box-shadow: 0 4px 10px rgba(23, 105, 217, 0.12);
    }
    .menu-toggle-btn:active {
      transform: translateY(0);
    }

    /* Desktop Sidebar Closed State */
    @media (min-width: 993px) {
      body.sidebar-closed .sidebar {
        transform: translateX(-100%);
        box-shadow: none;
      }
      body.sidebar-closed .main {
        margin-left: 0 !important;
        width: 100% !important;
      }
      body.sidebar-closed .menu-toggle-btn {
        background: #1769d9;
        color: #ffffff;
        border-color: #1769d9;
        box-shadow: 0 4px 12px rgba(23, 105, 217, 0.25);
      }
      body.sidebar-closed .menu-toggle-btn:hover {
        background: #1254b3;
        border-color: #1254b3;
      }
    }

    /* Mobile Sidebar Backdrop */
    .sidebar-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(15, 35, 65, 0.45);
      backdrop-filter: blur(3px);
      z-index: 1040;
      opacity: 0;
      transition: opacity 0.25s ease;
    }
    .sidebar-backdrop.active {
      display: block;
      opacity: 1;
    }

    @media (max-width: 992px) {
      .sidebar {
        position: fixed !important;
        left: 0;
        top: 0;
        bottom: 0;
        width: min(285px, 84vw) !important;
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1050 !important;
        box-shadow: 4px 0 25px rgba(0, 0, 0, 0.25);
      }
      .sidebar.mobile-open {
        transform: translateX(0);
      }
      .sidebar .nav {
        display: flex !important;
        flex-direction: column;
      }
      .sidebar-footer {
        display: block !important;
      }
      .main {
        margin-left: 0 !important;
        width: 100% !important;
      }
      .app {
        display: block !important;
      }
      .dashboard-map-container {
        height: 320px;
      }
    }

    @media (max-width: 900px) {
      .information-stats { grid-template-columns: repeat(2, 1fr) !important; gap: 14px; }
      .information-panels { grid-template-columns: 1fr !important; gap: 18px; }
      .two-columns { grid-template-columns: 1fr !important; gap: 18px; }
    }

    @media (max-width: 768px) {
      .topbar {
        height: auto;
        min-height: 64px;
        padding: 12px 16px;
        flex-wrap: wrap;
        gap: 12px;
      }
      .topbar-left-controls {
        width: 100% !important;
        max-width: 100% !important;
      }
      .topbar-right-controls {
        width: 100%;
        justify-content: space-between;
      }
      .search {
        width: 100% !important;
        max-width: 100% !important;
      }
      .content {
        padding: 16px 14px 35px;
      }
      .hero, .information-hero {
        min-height: auto;
        padding: 22px 20px;
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
        text-align: left;
      }
      .hero-school, .information-hero-icon {
        display: none !important;
      }
      .hero h1, .information-hero h2 {
        font-size: 22px;
        line-height: 1.3;
      }
      .hero p, .information-hero p {
        font-size: 13px;
        line-height: 1.6;
        max-width: 100%;
      }
      .information-hero > div:last-child {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
      }
      .stats {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 14px;
        margin: 16px 0;
      }
      .stat-card {
        padding: 16px 14px;
        min-height: auto;
        border-radius: 12px;
      }
      .stat-card strong {
        font-size: 22px;
        margin-bottom: 6px;
      }
      .feature-grid {
        grid-template-columns: 1fr;
        gap: 14px;
      }
      .dashboard-map-container {
        height: 280px;
      }
    }

    @media (max-width: 576px) {
      .topbar {
        padding: 10px 12px;
        gap: 10px;
      }
      .topbar-left-controls {
        gap: 8px;
      }
      .menu-toggle-btn {
        width: 38px;
        height: 38px;
        font-size: 15px;
        border-radius: 8px;
      }
      .search {
        height: 38px;
        padding: 0 12px;
        border-radius: 10px;
      }
      .search span {
        font-size: 18px;
      }
      .search input {
        font-size: 12px;
      }
      .topbar-right-controls {
        gap: 8px;
      }
      .user-avatar-circle {
        width: 34px;
        height: 34px;
        font-size: 14px;
      }
      .profile strong {
        font-size: 12px;
        max-width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
      }
      .profile small {
        font-size: 10px;
      }
      .logout-btn-link {
        padding: 6px 10px;
        font-size: 12px;
        border-radius: 7px;
        gap: 5px;
      }
      .content {
        padding: 12px 10px 30px;
      }
      .hero, .information-hero {
        padding: 18px 14px;
        border-radius: 12px;
        gap: 12px;
      }
      .hero h1, .information-hero h2 {
        font-size: 19px;
      }
      .hero p, .information-hero p {
        font-size: 12px;
        line-height: 1.5;
      }
      .information-hero > div:last-child {
        flex-direction: column;
        align-items: stretch !important;
        gap: 8px;
      }
      .information-hero .btn,
      .hero .primary-btn {
        width: 100%;
        justify-content: center;
        text-align: center;
        box-sizing: border-box;
      }
      .stats, .information-stats {
        grid-template-columns: 1fr !important;
        gap: 10px;
      }
      .stat-card, .information-stat-card {
        padding: 14px;
        min-height: auto;
      }
      .stat-card strong, .information-stat-card strong {
        font-size: 20px;
      }
      .panel, .information-panel {
        padding: 16px 12px;
        border-radius: 12px;
        margin-bottom: 14px;
      }
      .panel-head, .information-panel-heading {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        min-height: auto;
        padding: 10px 0;
      }
      .announcement {
        grid-template-columns: 36px 1fr auto;
        gap: 10px;
        margin: 0;
        padding: 10px 0;
      }
      .mini-icon {
        width: 36px;
        height: 36px;
      }
      .form-actions {
        flex-direction: column-reverse;
        gap: 8px;
        width: 100%;
      }
      .form-actions .btn {
        width: 100%;
        justify-content: center;
      }
      .dashboard-map-container {
        height: 230px;
        border-radius: 10px;
      }
    }

    @media (max-width: 380px) {
      .profile {
        display: none;
      }
    }
  </style>

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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const toggleBtn = document.getElementById('sidebarToggleBtn');
      const closeBtn = document.getElementById('sidebarCloseBtn');
      const sidebar = document.getElementById('appSidebar');
      const backdrop = document.getElementById('sidebarBackdrop');

      const isMobile = function() {
        return window.innerWidth <= 992;
      };

      // Restore saved desktop state from localStorage
      const savedClosedState = localStorage.getItem('admin_sidebar_closed') === 'true';
      if (!isMobile() && savedClosedState) {
        document.body.classList.add('sidebar-closed');
      }
      document.documentElement.classList.remove('sidebar-closed-preload');

      function updateToggleTooltip() {
        if (!toggleBtn) return;
        const isClosed = isMobile()
          ? !sidebar.classList.contains('mobile-open')
          : document.body.classList.contains('sidebar-closed');

        const titleText = isClosed ? 'Buka Sidebar' : 'Tutup Sidebar';
        toggleBtn.setAttribute('title', titleText);
        toggleBtn.setAttribute('aria-label', titleText);
      }

      function toggleSidebar() {
        if (isMobile()) {
          const isOpen = sidebar.classList.toggle('mobile-open');
          if (backdrop) {
            backdrop.classList.toggle('active', isOpen);
          }
        } else {
          document.body.classList.toggle('sidebar-closed');
          const isClosed = document.body.classList.contains('sidebar-closed');
          localStorage.setItem('admin_sidebar_closed', isClosed ? 'true' : 'false');
          // Trigger resize for Leaflet map & responsive components
          setTimeout(function() {
            window.dispatchEvent(new Event('resize'));
          }, 320);
        }
        updateToggleTooltip();
      }

      function closeSidebar() {
        if (isMobile()) {
          sidebar.classList.remove('mobile-open');
          if (backdrop) {
            backdrop.classList.remove('active');
          }
        } else {
          document.body.classList.add('sidebar-closed');
          localStorage.setItem('admin_sidebar_closed', 'true');
          setTimeout(function() {
            window.dispatchEvent(new Event('resize'));
          }, 320);
        }
        updateToggleTooltip();
      }

      if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
      }
      if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
      }
      if (backdrop) {
        backdrop.addEventListener('click', closeSidebar);
      }

      // Close on Escape key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          if (isMobile() && sidebar.classList.contains('mobile-open')) {
            closeSidebar();
          }
        }
      });

      // Handle screen resize between mobile and desktop
      let prevIsMobile = isMobile();
      window.addEventListener('resize', function() {
        const currentlyMobile = isMobile();
        if (currentlyMobile !== prevIsMobile) {
          prevIsMobile = currentlyMobile;
          if (currentlyMobile) {
            sidebar.classList.remove('mobile-open');
            if (backdrop) backdrop.classList.remove('active');
          } else {
            const isClosed = localStorage.getItem('admin_sidebar_closed') === 'true';
            document.body.classList.toggle('sidebar-closed', isClosed);
          }
          updateToggleTooltip();
        }
      });

      updateToggleTooltip();
    });
  </script>

  @yield('scripts')
</body>
</html>
