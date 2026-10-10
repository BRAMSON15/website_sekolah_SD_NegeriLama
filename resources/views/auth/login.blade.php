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
          'title'       => 'Portal Masuk Guru - ' . ($settings['school_name'] ?? 'SD Negeri Lama'),
          'badge'       => 'Portal Dewan Guru',
          'badge_icon'  => 'fa-solid fa-chalkboard-user',
          'badge_style' => 'background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe;',
          'heading'     => 'Portal Guru Pengajar',
          'subtitle'    => 'Masuk ke ruang kerja digital guru untuk mengelola modul ajar, video edukasi, dan pengumuman sekolah.',
          'btn_text'    => 'Masuk Portal Guru',
          'btn_style'   => 'background: #2563eb; color: #ffffff;',
      ],
      'kepsek' => [
          'title'       => 'Portal Supervisi Kepala Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Lama'),
          'badge'       => 'Supervisi Eksekutif',
          'badge_icon'  => 'fa-solid fa-crown',
          'badge_style' => 'background: #fef3c7; color: #b45309; border: 1.5px solid #fcd34d;',
          'heading'     => 'Supervisi Kepala Sekolah',
          'subtitle'    => 'Panel eksekutif pemantauan mutu pendidikan, monitoring dewan guru, pendaftaran PPDB, dan status sistem.',
          'btn_text'    => 'Masuk Supervisi Kepsek',
          'btn_style'   => 'background: #0f172a; color: #ffffff;',
      ],
      'admin' => [
          'title'       => 'Portal Administrator - ' . ($settings['school_name'] ?? 'SD Negeri Lama'),
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
  <link rel="stylesheet" href="{{ asset('mentahan2/css/login.css') }}?v={{ filemtime(public_path('mentahan2/css/login.css')) }}">
@endsection

<div class="login-page-wrap" style="min-height: calc(100vh - 300px); display: flex; align-items: center; justify-content: center; padding: 60px 6%; background-image: linear-gradient(rgba(15, 23, 42, 0.62), rgba(30, 64, 175, 0.62)), url('{{ asset('mentahan2/img/image1.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
  <div class="login-card-box" style="background: #ffffff; border-radius: var(--radius); padding: 40px; border: 1px solid var(--border); box-shadow: var(--shadow-lg); width: 100%; max-width: 480px; box-sizing: border-box;">
    
    <div style="text-align: center; margin-bottom: 24px;">
      <div style="width: 68px; height: 68px; background: #ffffff; border: 1px solid var(--border); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08); padding: 8px; overflow: hidden;">
        <img src="{{ asset('mentahan2/img/Logo1.svg') }}" alt="Logo {{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}" style="width: 100%; height: 100%; object-fit: contain;">
      </div>

      <!-- Distinct Role Badge -->
      <div style="display: inline-flex; align-items: center; gap: 7px; padding: 4px 14px; border-radius: 20px; font-size: 0.74rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; {{ $currentConfig['badge_style'] }}">
        <i class="{{ $currentConfig['badge_icon'] }}"></i> {{ $currentConfig['badge'] }}
      </div>

      <h2 style="font-size: 1.55rem; font-weight: 800; color: var(--dark); margin-bottom: 6px;">{{ $currentConfig['heading'] }}</h2>
      <p style="font-size: 0.88rem; color: var(--muted); line-height: 1.45; margin: 0;">{{ $currentConfig['subtitle'] }}</p>
    </div>

    @auth
    <!-- Active Session Banner for Authenticated Users -->
    <div style="background: #eff6ff; border: 1.5px solid #bfdbfe; border-radius: 12px; padding: 14px 16px; margin-bottom: 22px; text-align: left;">
      <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
        <div>
          <div style="font-size: 0.72rem; text-transform: uppercase; font-weight: 800; color: #2563eb; letter-spacing: 0.5px; margin-bottom: 2px;">
            <i class="fa-solid fa-circle-check" style="color: #10b981;"></i> Sesi Sedang Masuk
          </div>
          <div style="font-size: 0.95rem; font-weight: 800; color: #1e3a8a;">
            {{ Auth::user()->name }}
            <span style="font-size: 0.72rem; font-weight: 700; background: #dbeafe; color: #1d4ed8; padding: 2px 8px; border-radius: 999px; margin-left: 6px;">{{ strtoupper(Auth::user()->role) }}</span>
          </div>
          <p style="font-size: 0.78rem; color: #64748b; margin: 4px 0 0; line-height: 1.4;">
            Anda sedang masuk pada sistem. Anda dapat langsung menuju ke dashboard akun Anda.
          </p>
        </div>
        <div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap; margin-top: 4px;">
          @if(in_array(Auth::user()->role, ['kepala_sekolah', 'kepsek']))
            <a href="{{ route('kepsek.dashboard') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; font-size: 0.8rem; font-weight: 700; border-radius: 8px; background: #0f172a; color: #fff; text-decoration: none;">
              <i class="fa-solid fa-user-tie"></i> Monitoring Kepsek
            </a>
          @elseif(Auth::user()->role === 'guru')
            <a href="{{ route('guru.dashboard') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; font-size: 0.8rem; font-weight: 700; border-radius: 8px; background: #2563eb; color: #fff; text-decoration: none;">
              <i class="fa-solid fa-chalkboard-user"></i> Portal Guru
            </a>
          @elseif(Auth::user()->role === 'admin')
            <a href="{{ route('dashboard') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; font-size: 0.8rem; font-weight: 700; border-radius: 8px; background: #2563eb; color: #fff; text-decoration: none;">
              <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
          @else
            <a href="{{ route('siswa.beranda') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; font-size: 0.8rem; font-weight: 700; border-radius: 8px; background: #2563eb; color: #fff; text-decoration: none;">
              <i class="fa-solid fa-graduation-cap"></i> Ruang Belajar
            </a>
          @endif
          <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
            @csrf
            <button type="submit" style="display: inline-flex; align-items: center; gap: 5px; padding: 7px 12px; font-size: 0.8rem; font-weight: 700; border-radius: 8px; background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; cursor: pointer;">
              <i class="fa-solid fa-right-from-bracket"></i> Keluar
            </button>
          </form>
        </div>
      </div>
    </div>
    @endauth

    @if (session('success'))
    <div style="background: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 12px 16px; border-radius: 8px; font-size: 0.86rem; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
      <i class="fa-solid fa-circle-check" style="font-size: 1.1rem; color: #10b981;"></i>
      <div>{{ session('success') }}</div>
    </div>
    @endif

    @if ($errors->any())
    <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 12px 16px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 20px;">
      <ul style="margin: 0; padding-left: 16px;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <!-- Role Form Renders Exclusively Based on URL Link (No Switcher Tabs) -->
    @if ($roleKey === 'admin')
      <!-- ================= FORM LOGIN ADMIN ================= -->
      <form id="form-login-admin" action="{{ route('login') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf
        <input type="hidden" name="login_type" value="admin">
        <div>
          <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
            <i class="fa-solid fa-envelope" style="color: #1e40af; margin-right: 6px;"></i> Email atau Username Admin
          </label>
          <input type="text" name="email" value="{{ old('email') }}" placeholder="admin@sdnegerilama.sch.id" required style="width: 100%; box-sizing: border-box; padding: 14px 16px; border: 1px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none;">
        </div>

        <div>
          <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
            <i class="fa-solid fa-lock" style="color: #1e40af; margin-right: 6px;"></i> Kata Sandi
          </label>
          <div class="password-input-wrapper" style="box-sizing: border-box; border: 1px solid var(--border); border-radius: 10px; background: #fff;">
            <input type="password" name="password" placeholder="••••••••" required style="width: 100%; box-sizing: border-box; padding: 14px 16px; border: none; border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none; background: transparent;">
            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility(this)">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
          <span style="display: block; font-size: 0.76rem; color: var(--muted); margin-top: 5px;">*Akses khusus Administrator Pengelola Website SD Negeri Lama.</span>
        </div>

        <button type="submit" class="btn-login" style="border: none; width: 100%; justify-content: center; padding: 14px; font-size: 1rem; cursor: pointer; border-radius: 10px; {{ $currentConfig['btn_style'] }}">
          <i class="fa-solid fa-right-to-bracket"></i> {{ $currentConfig['btn_text'] }}
        </button>
      </form>

    @elseif ($roleKey === 'kepsek')
      <!-- ================= FORM LOGIN KEPALA SEKOLAH ================= -->
      <form id="form-login-kepsek" action="{{ route('login') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf
        <input type="hidden" name="login_type" value="kepala_sekolah">
        <div>
          <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
            <i class="fa-solid fa-user-tie" style="color: #0f172a; margin-right: 6px;"></i> NIP, Email, atau Nama Kepala Sekolah
          </label>
          <input type="text" name="kepsek_identifier" value="{{ old('kepsek_identifier') }}" placeholder="Contoh: 197505081999031001 atau kepsek@sdnegerilama.sch.id" required style="width: 100%; box-sizing: border-box; padding: 14px 16px; border: 1px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none;">
        </div>

        <div>
          <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
            <i class="fa-solid fa-lock" style="color: #0f172a; margin-right: 6px;"></i> Kata Sandi
          </label>
          <div class="password-input-wrapper" style="box-sizing: border-box; border: 1px solid var(--border); border-radius: 10px; background: #fff;">
            <input type="password" name="kepsek_password" placeholder="••••••••" required style="width: 100%; box-sizing: border-box; padding: 14px 16px; border: none; border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none; background: transparent;">
            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility(this)">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
          <span style="display: block; font-size: 0.76rem; color: var(--muted); margin-top: 5px;">*Akses terbatas pimpinan satuan pendidikan SD Negeri Lama.</span>
        </div>

        <button type="submit" class="btn-login" style="border: none; width: 100%; justify-content: center; padding: 14px; font-size: 1rem; cursor: pointer; border-radius: 10px; {{ $currentConfig['btn_style'] }}">
          <i class="fa-solid fa-building-columns" style="margin-right: 6px;"></i> {{ $currentConfig['btn_text'] }}
        </button>
      </form>

    @else
      <!-- ================= FORM LOGIN GURU (DEFAULT) ================= -->
      <form id="form-login-guru" action="{{ route('login') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf
        <input type="hidden" name="login_type" value="guru">
        <div>
          <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
            <i class="fa-solid fa-user-tie" style="color: var(--primary); margin-right: 6px;"></i> Nama Lengkap, NIP, atau Email Guru
          </label>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso, S.Pd atau 198507122010011002" required style="width: 100%; box-sizing: border-box; padding: 14px 16px; border: 1px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none;">
        </div>

        <div>
          <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
            <i class="fa-solid fa-id-card" style="color: var(--primary); margin-right: 6px;"></i> NIP / Kata Sandi
          </label>
          <div class="password-input-wrapper" style="box-sizing: border-box; border: 1px solid var(--border); border-radius: 10px; background: #fff;">
            <input type="password" name="nip" placeholder="Masukkan NIP atau kata sandi guru" required style="width: 100%; box-sizing: border-box; padding: 14px 16px; border: none; border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none; background: transparent;">
            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility(this)">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
          <span style="display: block; font-size: 0.76rem; color: var(--muted); margin-top: 5px;">*Gunakan NIP terdaftar atau kata sandi yang telah diatur untuk masuk.</span>
        </div>

        <button type="submit" class="btn-login" style="border: none; width: 100%; justify-content: center; padding: 14px; font-size: 1rem; cursor: pointer; border-radius: 10px; {{ $currentConfig['btn_style'] }}">
          <i class="fa-solid fa-chalkboard-user"></i> {{ $currentConfig['btn_text'] }}
        </button>
      </form>
    @endif

  </div>
</div>
@endsection

@section('scripts')
  <script src="{{ asset('mentahan2/js/login.js') }}?v={{ filemtime(public_path('mentahan2/js/login.js')) }}"></script>
@endsection
