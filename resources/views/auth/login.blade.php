@extends('layouts.app')

@section('title', 'Login Portal Guru & Admin - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<style>
  @media (max-width: 576px) {
    .login-page-wrap {
      padding: 24px 12px !important;
      min-height: auto !important;
    }
    .login-card-box {
      padding: 24px 16px !important;
      border-radius: 14px !important;
      width: 100% !important;
      max-width: 100% !important;
    }
  }
</style>

<div class="login-page-wrap" style="min-height: calc(100vh - 300px); display: flex; align-items: center; justify-content: center; padding: 60px 6%; background-image: linear-gradient(rgba(15, 23, 42, 0.58), rgba(30, 64, 175, 0.58)), url('{{ asset('mentahan2/img/image1.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
  <div class="login-card-box" style="background: #ffffff; border-radius: var(--radius); padding: 40px; border: 1px solid var(--border); box-shadow: var(--shadow-lg); width: 100%; max-width: 480px; box-sizing: border-box;">
    
    <div style="text-align: center; margin-bottom: 26px;">
      <div style="width: 68px; height: 68px; background: #ffffff; border: 1px solid var(--border); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08); padding: 8px; overflow: hidden;">
        <img src="{{ asset('mentahan2/img/Logo1.svg') }}" alt="Logo {{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}" style="width: 100%; height: 100%; object-fit: contain;">
      </div>
      <h2 style="font-size: 1.6rem; font-weight: 800; color: var(--dark); margin-bottom: 6px;">Portal Masuk</h2>
      <p style="font-size: 0.9rem; color: var(--muted);">Masuk ke portal pengelolaan Guru dan Administrator {{ $settings['school_name'] ?? 'SD Negeri Lama' }}</p>
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
            Pilih tab di bawah untuk ganti login, atau kembali ke halaman akun Anda.
          </p>
        </div>
        <div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap; margin-top: 4px;">
          @if(Auth::user()->role === 'guru')
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

    <!-- Login Type Selector Tabs (Hanya Guru & Admin) -->
    <div style="display: flex; background: #f1f5f9; padding: 4px; border-radius: 10px; margin-bottom: 24px; gap: 4px;">
      <button type="button" id="tab-guru" onclick="switchLoginTab('guru')" style="flex: 1; padding: 11px 8px; border: none; border-radius: 8px; font-weight: 700; font-size: 0.9rem; cursor: pointer; background: #ffffff; color: var(--primary); box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: 0.2s;">
        <i class="fa-solid fa-chalkboard-user"></i> Guru Pengajar
      </button>
      <button type="button" id="tab-admin" onclick="switchLoginTab('admin')" style="flex: 1; padding: 11px 8px; border: none; border-radius: 8px; font-weight: 700; font-size: 0.9rem; cursor: pointer; background: transparent; color: var(--muted); transition: 0.2s;">
        <i class="fa-solid fa-user-shield"></i> Administrator
      </button>
    </div>

    <!-- Form Login Guru (Default Aktif) -->
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
        <input type="password" name="nip" placeholder="Masukkan NIP atau kata sandi guru" required style="width: 100%; box-sizing: border-box; padding: 14px 16px; border: 1px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none;">
        <span style="display: block; font-size: 0.76rem; color: var(--muted); margin-top: 5px;">*Gunakan NIP terdaftar (atau kata sandi yang telah diatur) untuk masuk.</span>
      </div>

      <button type="submit" class="btn-login" style="border: none; width: 100%; justify-content: center; padding: 14px; font-size: 1rem; cursor: pointer; border-radius: 10px;">
        <i class="fa-solid fa-chalkboard-user"></i> Masuk Portal Guru
      </button>
    </form>

    <!-- Form Login Admin -->
    <form id="form-login-admin" action="{{ route('login') }}" method="POST" style="display: none; flex-direction: column; gap: 20px;">
      @csrf
      <input type="hidden" name="login_type" value="admin">
      <div>
        <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
          <i class="fa-solid fa-envelope" style="color: var(--primary); margin-right: 6px;"></i> Email atau Username Admin
        </label>
        <input type="text" name="email" value="{{ old('email') }}" placeholder="admin@sdnegerilama.sch.id" style="width: 100%; box-sizing: border-box; padding: 14px 16px; border: 1px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none;">
      </div>

      <div>
        <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
          <i class="fa-solid fa-lock" style="color: var(--primary); margin-right: 6px;"></i> Kata Sandi
        </label>
        <input type="password" name="password" placeholder="••••••••" style="width: 100%; box-sizing: border-box; padding: 14px 16px; border: 1px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none;">
      </div>

      <button type="submit" class="btn-login" style="border: none; width: 100%; justify-content: center; padding: 14px; font-size: 1rem; cursor: pointer; border-radius: 10px;">
        <i class="fa-solid fa-right-to-bracket"></i> Masuk Admin
      </button>
    </form>

    <!-- Interactive Quick Credentials Guide (Guru & Admin) -->
    <div style="margin-top: 24px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 10px; padding: 12px 14px; font-size: 0.8rem; color: #475569;">
      <div style="font-weight: 700; color: #1e293b; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
        <i class="fa-solid fa-circle-info" style="color: #2563eb;"></i> Akun Uji Coba:
      </div>
      <div id="hint-guru">
        <strong>Guru:</strong> Nama / NIP: <code>198507122010011002</code> (Budi Santoso) &bull; Sandi: <code>198507122010011002</code>
      </div>
      <div id="hint-admin" style="display: none;">
        <strong>Admin:</strong> Email: <code>admin@sdnegerilama.sch.id</code> &bull; Sandi: <code>password123</code>
      </div>
    </div>

    <!-- Student NISN Access Information Box -->
    <div style="margin-top: 20px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 12px 14px; text-align: center; font-size: 0.84rem; color: #1e40af;">
      <i class="fa-solid fa-graduation-cap" style="color: #2563eb; margin-right: 6px;"></i> Siswa ingin mengakses materi & video? <a href="{{ route('akademik') }}" style="color: #1d4ed8; font-weight: 700; text-decoration: underline;">Masukkan NISN di Halaman Akademik</a>
    </div>

    <div style="margin-top: 20px; text-align: center; font-size: 0.85rem; color: var(--muted); border-top: 1px solid var(--border); padding-top: 16px;">
      Belum terdaftar atau lupa akun? Hubungi <a href="{{ route('kontak') }}" style="color: var(--primary); font-weight: 700;">Administrator / Pengelola Sekolah</a>
    </div>

  </div>
</div>

<script>
  function switchLoginTab(type) {
    const tabGuru = document.getElementById('tab-guru');
    const tabAdmin = document.getElementById('tab-admin');

    const formGuru = document.getElementById('form-login-guru');
    const formAdmin = document.getElementById('form-login-admin');

    const hintGuru = document.getElementById('hint-guru');
    const hintAdmin = document.getElementById('hint-admin');

    // Reset tabs
    [tabGuru, tabAdmin].forEach(tab => {
      if (tab) {
        tab.style.background = 'transparent';
        tab.style.color = 'var(--muted)';
        tab.style.boxShadow = 'none';
      }
    });

    // Hide forms and hints
    [formGuru, formAdmin].forEach(form => {
      if (form) form.style.display = 'none';
    });
    [hintGuru, hintAdmin].forEach(hint => {
      if (hint) hint.style.display = 'none';
    });

    if (type === 'admin') {
      tabAdmin.style.background = '#ffffff';
      tabAdmin.style.color = 'var(--primary)';
      tabAdmin.style.boxShadow = '0 2px 4px rgba(0,0,0,0.05)';
      formAdmin.style.display = 'flex';
      if (hintAdmin) hintAdmin.style.display = 'block';
    } else {
      tabGuru.style.background = '#ffffff';
      tabGuru.style.color = 'var(--primary)';
      tabGuru.style.boxShadow = '0 2px 4px rgba(0,0,0,0.05)';
      formGuru.style.display = 'flex';
      if (hintGuru) hintGuru.style.display = 'block';
    }
  }

  // Auto switch tab based on query param ?role= / ?tab= or old('login_type') (default: guru)
  const activeTab = "{{ request('role', request('tab', old('login_type', 'guru'))) }}";
  switchLoginTab(activeTab);
</script>
@endsection
