@extends('layouts.app')

@php
  $roleKey = $role ?? 'guru';
  if (in_array($roleKey, ['kepala_sekolah', 'kepsek'])) {
      $roleKey = 'kepsek';
  } elseif ($roleKey === 'admin') {
      $roleKey = 'admin';
  } else {
      $roleKey = 'guru';
  }

  $roleConfig = [
      'guru' => [
          'title'       => 'Portal Masuk Guru - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'),
          'badge'       => 'Portal Dewan Guru',
          'badge_icon'  => 'fa-solid fa-chalkboard-user',
          'badge_class' => 'badge-guru',
          'heading'     => 'Portal Guru Pengajar',
          'subtitle'    => 'Masuk ke ruang kerja digital guru untuk mengelola modul ajar, video edukasi, dan materi pembelajaran.',
          'btn_text'    => 'Masuk Portal Guru',
          'btn_class'   => 'btn-login-guru',
          'icon'        => 'fa-solid fa-chalkboard-user',
          'role_class'  => 'role-guru',
      ],
      'kepsek' => [
          'title'       => 'Portal Supervisi Kepala Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'),
          'badge'       => 'Supervisi Eksekutif',
          'badge_icon'  => 'fa-solid fa-crown',
          'badge_class' => 'badge-kepsek',
          'heading'     => 'Supervisi Kepala Sekolah',
          'subtitle'    => 'Panel eksekutif pemantauan mutu pendidikan, monitoring dewan guru, pendaftaran PPDB, dan status sistem.',
          'btn_text'    => 'Masuk Supervisi Kepsek',
          'btn_class'   => 'btn-login-kepsek',
          'icon'        => 'fa-solid fa-user-tie',
          'role_class'  => 'role-kepsek',
      ],
      'admin' => [
          'title'       => 'Portal Administrator - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'),
          'badge'       => 'Portal Administrator',
          'badge_icon'  => 'fa-solid fa-user-shield',
          'badge_class' => 'badge-admin',
          'heading'     => 'Administrator Portal',
          'subtitle'    => 'Masuk sebagai pengelola sistem untuk administrasi website sekolah, data akun guru, dan publikasi berita.',
          'btn_text'    => 'Masuk Panel Admin',
          'btn_class'   => 'btn-login-admin',
          'icon'        => 'fa-solid fa-shield-halved',
          'role_class'  => 'role-admin',
      ],
  ];

  $currentConfig = $roleConfig[$roleKey];
@endphp

@section('title', $currentConfig['title'])

@section('styles')
  <link rel="stylesheet" href="{{ asset('mentahan2/css/login.css') }}?v={{ filemtime(public_path('mentahan2/css/login.css')) ?: time() }}">
@endsection

@section('content')
<div class="login-page-wrap">
  <div class="login-card-box {{ $currentConfig['role_class'] }}">
    
    <!-- Card Header Branding -->
    <div class="login-card-header">
      <div class="login-logo-wrap">
        <img src="{{ asset('mentahan2/img/Logo1.svg') }}" alt="Logo {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}" onerror="this.onerror=null; this.src='{{ asset('mentahan2/img/Logo1.png') }}';">
      </div>

      <div class="login-badge {{ $currentConfig['badge_class'] }}">
        <i class="{{ $currentConfig['badge_icon'] }}"></i>
        <span>{{ $currentConfig['badge'] }}</span>
      </div>

      <h1 class="login-title">{{ $currentConfig['heading'] }}</h1>
      <p class="login-subtitle">{{ $currentConfig['subtitle'] }}</p>
    </div>

    @auth
    <!-- Active Session Banner for Logged-in Users -->
    <div class="active-session-banner">
      <div class="session-tag">
        <i class="fa-solid fa-circle-check" style="color: #10b981;"></i> Sesi Masuk Aktif
      </div>
      <div class="session-user">
        <span>{{ Auth::user()->name }}</span>
        <span class="session-role">{{ strtoupper(Auth::user()->role) }}</span>
      </div>
      <p class="session-desc">
        Anda saat ini sedang dalam sesi aktif. Ingin langsung menuju panel?
      </p>
      <div class="active-session-actions">
        @if(in_array(Auth::user()->role, ['kepala_sekolah', 'kepsek']))
          <a href="{{ route('kepsek.dashboard') }}" class="btn-session-dash">
            <i class="fa-solid fa-gauge-high"></i> Buka Monitoring
          </a>
        @elseif(Auth::user()->role === 'guru')
          <a href="{{ route('guru.dashboard') }}" class="btn-session-dash">
            <i class="fa-solid fa-chalkboard-user"></i> Buka Portal Guru
          </a>
        @elseif(Auth::user()->role === 'admin')
          <a href="{{ route('dashboard') }}" class="btn-session-dash">
            <i class="fa-solid fa-gauge"></i> Buka Dashboard Admin
          </a>
        @else
          <a href="{{ route('siswa.beranda') }}" class="btn-session-dash">
            <i class="fa-solid fa-graduation-cap"></i> Buka Ruang Belajar
          </a>
        @endif

        <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
          @csrf
          <button type="submit" class="btn-session-logout">
            <i class="fa-solid fa-right-from-bracket"></i> Keluar
          </button>
        </form>
      </div>
    </div>
    @endauth

    @if (session('success'))
    <div class="login-alert login-alert-success">
      <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 1.1rem; margin-top: 1px;"></i>
      <div>{{ session('success') }}</div>
    </div>
    @endif

    @if ($errors->any())
    <div class="login-alert login-alert-danger">
      <i class="fa-solid fa-circle-exclamation" style="color: #ef4444; font-size: 1.1rem; margin-top: 1px; flex-shrink: 0;"></i>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <!-- Form Section -->
    @if ($roleKey === 'admin')
      <!-- ================= FORM LOGIN ADMIN ================= -->
      <form id="form-login-admin" action="{{ route('login') }}" method="POST" class="login-form">
        @csrf
        <input type="hidden" name="login_type" value="admin">
        
        <div class="form-group">
          <label class="form-label" for="admin-email">
            <i class="fa-solid fa-envelope"></i>
            <span>Email atau Username</span>
          </label>
          <div class="input-wrapper">
            <div class="input-icon-box">
              <i class="fa-solid fa-envelope"></i>
            </div>
            <input type="text" id="admin-email" name="email" value="{{ old('email') }}" placeholder="Contoh: admin@sdnegerilama.sch.id" required autofocus class="input-field input-with-icon">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="admin-password">
            <i class="fa-solid fa-lock"></i>
            <span>Kata Sandi</span>
          </label>
          <div class="input-wrapper password-input-wrapper">
            <div class="input-icon-box">
              <i class="fa-solid fa-lock"></i>
            </div>
            <input type="password" id="admin-password" name="password" placeholder="Masukkan kata sandi admin" required class="input-field input-with-icon">
            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility(this)" title="Tampilkan kata sandi" aria-label="Tampilkan kata sandi">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
          <span class="form-helper">
            <i class="fa-solid fa-shield-halved" style="font-size: 0.7rem; color: #4f46e5;"></i> Akses khusus Administrator Sistem.
          </span>
        </div>

        <button type="submit" class="btn-submit {{ $currentConfig['btn_class'] }}">
          <i class="fa-solid fa-right-to-bracket"></i>
          <span>{{ $currentConfig['btn_text'] }}</span>
        </button>
      </form>

    @elseif ($roleKey === 'kepsek')
      <!-- ================= FORM LOGIN KEPALA SEKOLAH ================= -->
      <form id="form-login-kepsek" action="{{ route('login') }}" method="POST" class="login-form">
        @csrf
        <input type="hidden" name="login_type" value="kepala_sekolah">
        
        <div class="form-group">
          <label class="form-label" for="kepsek-identifier">
            <i class="fa-solid fa-user-tie"></i>
            <span>NIP, Email, atau Nama</span>
          </label>
          <div class="input-wrapper">
            <div class="input-icon-box">
              <i class="fa-solid fa-id-badge"></i>
            </div>
            <input type="text" id="kepsek-identifier" name="kepsek_identifier" value="{{ old('kepsek_identifier') }}" placeholder="Contoh: 197505081999031001" required autofocus class="input-field input-with-icon">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="kepsek-password">
            <i class="fa-solid fa-lock"></i>
            <span>Kata Sandi</span>
          </label>
          <div class="input-wrapper password-input-wrapper">
            <div class="input-icon-box">
              <i class="fa-solid fa-lock"></i>
            </div>
            <input type="password" id="kepsek-password" name="kepsek_password" placeholder="Masukkan kata sandi" required class="input-field input-with-icon">
            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility(this)" title="Tampilkan kata sandi" aria-label="Tampilkan kata sandi">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
          <span class="form-helper">
            <i class="fa-solid fa-lock" style="font-size: 0.7rem; color: #d97706;"></i> Akses terbatas untuk pimpinan satuan pendidikan.
          </span>
        </div>

        <button type="submit" class="btn-submit {{ $currentConfig['btn_class'] }}">
          <i class="fa-solid fa-building-columns"></i>
          <span>{{ $currentConfig['btn_text'] }}</span>
        </button>
      </form>

    @else
      <!-- ================= FORM LOGIN GURU (DEFAULT) ================= -->
      <form id="form-login-guru" action="{{ route('login') }}" method="POST" class="login-form">
        @csrf
        <input type="hidden" name="login_type" value="guru">
        
        <div class="form-group">
          <label class="form-label" for="guru-name">
            <i class="fa-solid fa-user-tie"></i>
            <span>Nama Lengkap, NIP, atau Email</span>
          </label>
          <div class="input-wrapper">
            <div class="input-icon-box">
              <i class="fa-solid fa-user-check"></i>
            </div>
            <input type="text" id="guru-name" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso atau NIP guru" required autofocus class="input-field input-with-icon">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="guru-nip">
            <i class="fa-solid fa-key"></i>
            <span>NIP / Kata Sandi</span>
          </label>
          <div class="input-wrapper password-input-wrapper">
            <div class="input-icon-box">
              <i class="fa-solid fa-lock"></i>
            </div>
            <input type="password" id="guru-nip" name="nip" placeholder="Masukkan NIP atau kata sandi Anda" required class="input-field input-with-icon">
            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility(this)" title="Tampilkan kata sandi" aria-label="Tampilkan kata sandi">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
          <span class="form-helper">
            <i class="fa-solid fa-circle-info" style="font-size: 0.7rem; color: #2563eb;"></i> Gunakan NIP atau kata sandi yang telah didaftarkan.
          </span>
        </div>

        <button type="submit" class="btn-submit {{ $currentConfig['btn_class'] }}">
          <i class="fa-solid fa-chalkboard-user"></i>
          <span>{{ $currentConfig['btn_text'] }}</span>
        </button>
      </form>
    @endif

    <!-- Card Footer / Back Link -->
    <div class="login-card-footer">
      <a href="{{ route('home') }}" class="back-home-link">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Kembali ke Beranda Utama</span>
      </a>
    </div>

  </div>
</div>
@endsection

@section('scripts')
  <script src="{{ asset('mentahan2/js/login.js') }}?v={{ filemtime(public_path('mentahan2/js/login.js')) ?: time() }}"></script>
@endsection
