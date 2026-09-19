@extends('layouts.app')

@section('title', 'Login Portal - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div style="min-height: calc(100vh - 300px); display: flex; align-items: center; justify-content: center; padding: 60px 6%; background-image: linear-gradient(rgba(15, 23, 42, 0.58), rgba(30, 64, 175, 0.58)), url('{{ asset('mentahan2/img/image1.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
  <div style="background: #ffffff; border-radius: var(--radius); padding: 40px; border: 1px solid var(--border); box-shadow: var(--shadow-lg); width: 100%; max-width: 460px;">
    
    <div style="text-align: center; margin-bottom: 30px;">
      <div style="width: 68px; height: 68px; background: #ffffff; border: 1px solid var(--border); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08); padding: 8px; overflow: hidden;">
        <img src="{{ asset('mentahan2/img/Logo1.svg') }}" alt="Logo {{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}" style="width: 100%; height: 100%; object-fit: contain;">
      </div>
      <h2 style="font-size: 1.6rem; font-weight: 800; color: var(--dark); margin-bottom: 6px;">Portal Masuk</h2>
      <p style="font-size: 0.9rem; color: var(--muted);">Masuk ke sistem akademis {{ $settings['school_name'] ?? 'SD Negeri Lama' }}</p>
    </div>

    <!-- Login Type Selector Tabs -->
    <div style="display: flex; background: #f1f5f9; padding: 4px; border-radius: 10px; margin-bottom: 24px;">
      <button type="button" id="tab-admin" onclick="switchLoginTab('admin')" style="flex: 1; padding: 10px; border: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; background: #ffffff; color: var(--primary); box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: 0.2s;">
        <i class="fa-solid fa-user-shield"></i> Admin / Staff
      </button>
      <button type="button" id="tab-guru" onclick="switchLoginTab('guru')" style="flex: 1; padding: 10px; border: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; background: transparent; color: var(--muted); transition: 0.2s;">
        <i class="fa-solid fa-chalkboard-user"></i> Portal Guru
      </button>
    </div>

    @if ($errors->any())
    <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 12px 16px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 20px;">
      <ul style="margin: 0; padding-left: 16px;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <!-- Form Login Admin -->
    <form id="form-login-admin" action="{{ route('login') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
      @csrf
      <input type="hidden" name="login_type" value="admin">
      <div>
        <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
          <i class="fa-solid fa-envelope" style="color: var(--primary); margin-right: 6px;"></i> Alamat Email
        </label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@sdnegerilama.sch.id" style="width: 100%; padding: 14px 16px; border: 1px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none;">
      </div>

      <div>
        <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
          <i class="fa-solid fa-lock" style="color: var(--primary); margin-right: 6px;"></i> Kata Sandi
        </label>
        <input type="password" name="password" placeholder="••••••••" style="width: 100%; padding: 14px 16px; border: 1px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none;">
      </div>

      <button type="submit" class="btn-login" style="border: none; width: 100%; justify-content: center; padding: 14px; font-size: 1rem; cursor: pointer; border-radius: 10px;">
        <i class="fa-solid fa-right-to-bracket"></i> Masuk Admin
      </button>
    </form>

    <!-- Form Login Guru -->
    <form id="form-login-guru" action="{{ route('login') }}" method="POST" style="display: none; flex-direction: column; gap: 20px;">
      @csrf
      <input type="hidden" name="login_type" value="guru">
      <div>
        <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
          <i class="fa-solid fa-user-tie" style="color: var(--primary); margin-right: 6px;"></i> Nama Lengkap Guru
        </label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap dengan Gelar" style="width: 100%; padding: 14px 16px; border: 1px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none;">
      </div>

      <div>
        <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
          <i class="fa-solid fa-id-card" style="color: var(--primary); margin-right: 6px;"></i> NIP (Nomor Induk Pegawai)
        </label>
        <input type="password" name="nip" placeholder="Masukkan NIP sebagai password" style="width: 100%; padding: 14px 16px; border: 1px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none;">
      </div>

      <button type="submit" class="btn-login" style="border: none; width: 100%; justify-content: center; padding: 14px; font-size: 1rem; cursor: pointer; border-radius: 10px;">
        <i class="fa-solid fa-chalkboard-user"></i> Masuk Portal Guru
      </button>
    </form>

    <div style="margin-top: 30px; text-align: center; font-size: 0.85rem; color: var(--muted); border-top: 1px solid var(--border); padding-top: 20px;">
      Belum memiliki akun guru? Hubungi <a href="{{ route('kontak') }}" style="color: var(--primary); font-weight: 700;">Administrator Sekolah</a>
    </div>

  </div>
</div>

<script>
  function switchLoginTab(type) {
    const tabAdmin = document.getElementById('tab-admin');
    const tabGuru = document.getElementById('tab-guru');
    const formAdmin = document.getElementById('form-login-admin');
    const formGuru = document.getElementById('form-login-guru');

    if (type === 'guru') {
      tabGuru.style.background = '#ffffff';
      tabGuru.style.color = 'var(--primary)';
      tabGuru.style.boxShadow = '0 2px 4px rgba(0,0,0,0.05)';
      
      tabAdmin.style.background = 'transparent';
      tabAdmin.style.color = 'var(--muted)';
      tabAdmin.style.boxShadow = 'none';

      formAdmin.style.display = 'none';
      formGuru.style.display = 'flex';
    } else {
      tabAdmin.style.background = '#ffffff';
      tabAdmin.style.color = 'var(--primary)';
      tabAdmin.style.boxShadow = '0 2px 4px rgba(0,0,0,0.05)';
      
      tabGuru.style.background = 'transparent';
      tabGuru.style.color = 'var(--muted)';
      tabGuru.style.boxShadow = 'none';

      formGuru.style.display = 'none';
      formAdmin.style.display = 'flex';
    }
  }

  // Auto switch tab if old('login_type') === 'guru'
  @if(old('login_type') === 'guru')
    switchLoginTab('guru');
  @endif
</script>
@endsection
