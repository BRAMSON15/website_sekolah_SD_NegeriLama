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
          'badge_style' => 'background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe;',
          'heading'     => 'Portal Guru Pengajar',
          'subtitle'    => 'Masuk ke ruang kerja digital guru untuk mengelola modul ajar, video edukasi, dan pengumuman sekolah.',
          'btn_text'    => 'Masuk Portal Guru',
          'btn_style'   => 'background: #2563eb; color: #ffffff;',
      ],
      'kepsek' => [
          'title'       => 'Portal Supervisi Kepala Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'),
          'badge'       => 'Supervisi Eksekutif',
          'badge_icon'  => 'fa-solid fa-crown',
          'badge_style' => 'background: #fef3c7; color: #b45309; border: 1.5px solid #fcd34d;',
          'heading'     => 'Supervisi Kepala Sekolah',
          'subtitle'    => 'Panel eksekutif pemantauan mutu pendidikan, monitoring dewan guru, pendaftaran PPDB, dan status sistem.',
          'btn_text'    => 'Masuk Supervisi Kepsek',
          'btn_style'   => 'background: #0f172a; color: #ffffff;',
      ],
      'admin' => [
          'title'       => 'Portal Administrator - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'),
          'badge'       => 'Portal Administrator',
          'badge_icon'  => 'fa-solid fa-user-shield',
          'badge_style' => 'background: #e0e7ff; color: #4338ca; border: 1.5px solid #c7d2fe;',
          'heading'     => 'Administrator Portal',
          'subtitle'    => 'Masuk sebagai pengelola sistem untuk administrasi website sekolah, data akun guru, dan publikasi berita.',
          'btn_text'    => 'Masuk Panel Admin',
          'btn_style'   => 'background: #1e40af; color: #ffffff;',
      ],
  ];

  $currentConfig = $roleConfig[$roleKey];
@endphp

@section('title', $currentConfig['title'])

@section('styles')
  <link rel="stylesheet" href="{{ asset('mentahan2/css/login.css') }}?v={{ filemtime(public_path('mentahan2/css/login.css')) ?: time() }}">
  <style>
    .login-form { display: flex; flex-direction: column; gap: 10px; }
    .form-group { display: flex; flex-direction: column; }
    .form-label { display: block; font-weight: 700; font-size: 0.72rem; color: var(--dark); margin-bottom: 4px; }
    .form-input { width: 100%; box-sizing: border-box; padding: 8px 10px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit; font-size: 0.85rem; outline: none; transition: border-color 0.2s; }
    .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1); }
    .form-helper { display: block; font-size: 0.65rem; color: var(--muted); margin-top: 3px; }
    .form-submit { border: none; width: 100%; padding: 9px; font-size: 0.88rem; cursor: pointer; border-radius: 8px; font-weight: 700; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 6px; }
    .form-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }
    
    @media (max-width: 576px) {
      .login-form { gap: 12px; }
      .form-label { font-size: 0.70rem; margin-bottom: 5px; }
      .form-input { padding: 10px 12px; font-size: 0.88rem; }
      .form-helper { font-size: 0.62rem; margin-top: 4px; }
      .form-submit { padding: 11px; font-size: 0.90rem; }
    }
    
    @media (max-width: 380px) {
      .login-form { gap: 14px; }
      .form-label { font-size: 0.68rem; }
      .form-input { padding: 10px; font-size: 0.85rem; }
      .form-helper { font-size: 0.60rem; }
    }
  </style>
@endsection

@section('content')
<div class="login-page-wrap" style="min-height: calc(100vh - 300px); display: flex; align-items: center; justify-content: center; padding: 24px 3%; background-image: linear-gradient(rgba(15, 23, 42, 0.62), rgba(30, 64, 175, 0.62)), url('{{ asset('mentahan2/img/image1.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
  <div class="login-card-box" style="background: #ffffff; border-radius: var(--radius); padding: 22px; border: 1px solid var(--border); box-shadow: var(--shadow-lg); width: 100%; max-width: 420px; box-sizing: border-box;">
    
    <!-- Card Header -->
    <div style="text-align: center; margin-bottom: 14px;">
      <div style="width: 56px; height: 56px; background: #ffffff; border: 1px solid var(--border); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06); padding: 6px; overflow: hidden;">
        <img src="{{ asset('mentahan2/img/Logo1.svg') }}" alt="Logo {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}" style="width: 100%; height: 100%; object-fit: contain;">
      </div>

      <!-- Distinct Role Badge -->
      <div style="display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 14px; font-size: 0.62rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.2px; margin-bottom: 4px; {{ $currentConfig['badge_style'] }}">
        <i class="{{ $currentConfig['badge_icon'] }}"></i> {{ $currentConfig['badge'] }}
      </div>

      <h2 style="font-size: 1.15rem; font-weight: 800; color: var(--dark); margin: 0 0 4px 0; line-height: 1.3;">{{ $currentConfig['heading'] }}</h2>
      <p style="font-size: 0.75rem; color: var(--muted); line-height: 1.4; margin: 0;">{{ $currentConfig['subtitle'] }}</p>
    </div>

    @auth
    <!-- Active Session Banner for Authenticated Users -->
    <div style="background: #eff6ff; border: 1.5px solid #bfdbfe; border-radius: 8px; padding: 9px 11px; margin-bottom: 12px; text-align: left;">
      <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; flex-wrap: wrap;">
        <div>
          <div style="font-size: 0.60rem; text-transform: uppercase; font-weight: 800; color: #2563eb; letter-spacing: 0.3px; margin-bottom: 2px;">
            <i class="fa-solid fa-circle-check" style="color: #10b981;"></i> Sesi Masuk
          </div>
          <div style="font-size: 0.85rem; font-weight: 800; color: #1e3a8a;">
            {{ Auth::user()->name }}
            <span style="font-size: 0.62rem; font-weight: 700; background: #dbeafe; color: #1d4ed8; padding: 2px 6px; border-radius: 999px; margin-left: 4px;">{{ strtoupper(Auth::user()->role) }}</span>
          </div>
          <p style="font-size: 0.67rem; color: #64748b; margin: 3px 0 0; line-height: 1.3;">
            Anda sedang masuk. Langsung ke dashboard?
          </p>
        </div>
        <div style="display: flex; gap: 4px; align-items: center; flex-wrap: wrap; margin-top: 2px;">
          @if(in_array(Auth::user()->role, ['kepala_sekolah', 'kepsek']))
            <a href="{{ route('kepsek.dashboard') }}" style="display: inline-flex; align-items: center; gap: 4px; padding: 5px 8px; font-size: 0.67rem; font-weight: 700; border-radius: 5px; background: #0f172a; color: #fff; text-decoration: none;">
              <i class="fa-solid fa-user-tie"></i> Monitoring
            </a>
          @elseif(Auth::user()->role === 'guru')
            <a href="{{ route('guru.dashboard') }}" style="display: inline-flex; align-items: center; gap: 4px; padding: 5px 8px; font-size: 0.67rem; font-weight: 700; border-radius: 5px; background: #2563eb; color: #fff; text-decoration: none;">
              <i class="fa-solid fa-chalkboard-user"></i> Portal
            </a>
          @elseif(Auth::user()->role === 'admin')
            <a href="{{ route('dashboard') }}" style="display: inline-flex; align-items: center; gap: 4px; padding: 5px 8px; font-size: 0.67rem; font-weight: 700; border-radius: 5px; background: #2563eb; color: #fff; text-decoration: none;">
              <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
          @else
            <a href="{{ route('siswa.beranda') }}" style="display: inline-flex; align-items: center; gap: 4px; padding: 5px 8px; font-size: 0.67rem; font-weight: 700; border-radius: 5px; background: #2563eb; color: #fff; text-decoration: none;">
              <i class="fa-solid fa-graduation-cap"></i> Belajar
            </a>
          @endif
          <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
            @csrf
            <button type="submit" style="display: inline-flex; align-items: center; gap: 3px; padding: 5px 7px; font-size: 0.67rem; font-weight: 700; border-radius: 5px; background: #fee2e2; border: 0.5px solid #fecaca; color: #dc2626; cursor: pointer;">
              <i class="fa-solid fa-right-from-bracket"></i> Keluar
            </button>
          </form>
        </div>
      </div>
    </div>
    @endauth

    @if (session('success'))
    <div style="background: #ecfdf5; border-left: 3px solid #10b981; color: #065f46; padding: 8px 10px; border-radius: 6px; font-size: 0.73rem; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
      <i class="fa-solid fa-circle-check" style="font-size: 0.9rem; color: #10b981; flex-shrink: 0;"></i>
      <div>{{ session('success') }}</div>
    </div>
    @endif

    @if ($errors->any())
    <div style="background: #fef2f2; border-left: 3px solid #ef4444; color: #991b1b; padding: 8px 10px; border-radius: 6px; font-size: 0.73rem; margin-bottom: 12px;">
      <ul style="margin: 0; padding-left: 14px; line-height: 1.5;">
        @foreach ($errors->all() as $error)
          <li style="margin-bottom: 3px;">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <!-- Role Form Renders Exclusively Based on URL Link (No Switcher Tabs) -->
    @if ($roleKey === 'admin')
      <!-- ================= FORM LOGIN ADMIN ================= -->
      <form id="form-login-admin" action="{{ route('login') }}" method="POST" class="login-form">
        @csrf
        <input type="hidden" name="login_type" value="admin">
        <div class="form-group">
          <label class="form-label">
            <i class="fa-solid fa-envelope" style="color: #1e40af; margin-right: 4px;"></i> Email atau Username
          </label>
          <input type="text" name="email" value="{{ old('email') }}" placeholder="admin@sdnegerilama.sch.id" required class="form-input">
        </div>

        <div class="form-group">
          <label class="form-label">
            <i class="fa-solid fa-lock" style="color: #1e40af; margin-right: 4px;"></i> Kata Sandi
          </label>
          <div class="password-input-wrapper" style="box-sizing: border-box; border: 1px solid var(--border); border-radius: 8px; background: #fff; display: flex; align-items: center;">
            <input type="password" name="password" placeholder="••••••••" required style="flex: 1; box-sizing: border-box; padding: 8px 10px; border: none; border-radius: 8px; font-family: inherit; font-size: 0.85rem; outline: none; background: transparent;">
            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility(this)" style="padding: 8px 10px; background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 0.9rem;">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
          <span class="form-helper">*Akses khusus Administrator.</span>
        </div>

        <button type="submit" class="form-submit" style="{{ $currentConfig['btn_style'] }}">
          <i class="fa-solid fa-right-to-bracket"></i> {{ $currentConfig['btn_text'] }}
        </button>
      </form>

    @elseif ($roleKey === 'kepsek')
      <!-- ================= FORM LOGIN KEPALA SEKOLAH ================= -->
      <form id="form-login-kepsek" action="{{ route('login') }}" method="POST" class="login-form">
        @csrf
        <input type="hidden" name="login_type" value="kepala_sekolah">
        <div class="form-group">
          <label class="form-label">
            <i class="fa-solid fa-user-tie" style="color: #0f172a; margin-right: 4px;"></i> NIP, Email, atau Nama
          </label>
          <input type="text" name="kepsek_identifier" value="{{ old('kepsek_identifier') }}" placeholder="Contoh: 197505081999031001" required class="form-input">
        </div>

        <div class="form-group">
          <label class="form-label">
            <i class="fa-solid fa-lock" style="color: #0f172a; margin-right: 4px;"></i> Kata Sandi
          </label>
          <div class="password-input-wrapper" style="box-sizing: border-box; border: 1px solid var(--border); border-radius: 8px; background: #fff; display: flex; align-items: center;">
            <input type="password" name="kepsek_password" placeholder="••••••••" required style="flex: 1; box-sizing: border-box; padding: 8px 10px; border: none; border-radius: 8px; font-family: inherit; font-size: 0.85rem; outline: none; background: transparent;">
            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility(this)" style="padding: 8px 10px; background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 0.9rem;">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
          <span class="form-helper">*Akses terbatas pimpinan satuan pendidikan.</span>
        </div>

        <button type="submit" class="form-submit" style="{{ $currentConfig['btn_style'] }}">
          <i class="fa-solid fa-building-columns"></i> {{ $currentConfig['btn_text'] }}
        </button>
      </form>

    @else
      <!-- ================= FORM LOGIN GURU (DEFAULT) ================= -->
      <form id="form-login-guru" action="{{ route('login') }}" method="POST" class="login-form">
        @csrf
        <input type="hidden" name="login_type" value="guru">
        <div class="form-group">
          <label class="form-label">
            <i class="fa-solid fa-user-tie" style="color: var(--primary); margin-right: 4px;"></i> Nama, NIP, atau Email
          </label>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso atau 198507122010011002" required class="form-input">
        </div>

        <div class="form-group">
          <label class="form-label">
            <i class="fa-solid fa-id-card" style="color: var(--primary); margin-right: 4px;"></i> NIP / Kata Sandi
          </label>
          <div class="password-input-wrapper" style="box-sizing: border-box; border: 1px solid var(--border); border-radius: 8px; background: #fff; display: flex; align-items: center;">
            <input type="password" name="nip" placeholder="Masukkan NIP atau kata sandi" required style="flex: 1; box-sizing: border-box; padding: 8px 10px; border: none; border-radius: 8px; font-family: inherit; font-size: 0.85rem; outline: none; background: transparent;">
            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility(this)" style="padding: 8px 10px; background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 0.9rem;">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
          <span class="form-helper">*Gunakan NIP atau kata sandi yang telah diatur.</span>
        </div>

        <button type="submit" class="form-submit" style="{{ $currentConfig['btn_style'] }}">
          <i class="fa-solid fa-chalkboard-user"></i> {{ $currentConfig['btn_text'] }}
        </button>
      </form>
    @endif

  </div>
</div>
@endsection

@section('scripts')
  <script src="{{ asset('mentahan2/js/login.js') }}?v={{ filemtime(public_path('mentahan2/js/login.js')) ?: time() }}"></script>
@endsection
