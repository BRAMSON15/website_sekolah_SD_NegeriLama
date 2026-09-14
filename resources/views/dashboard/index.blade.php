@extends('layouts.app')

@section('title', 'Dashboard - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Dashboard {{ ucfirst($user->role ?? 'Siswa') }}</h1>
  <p>Selamat datang kembali, <strong>{{ $user->name }}</strong>! ({{ $user->email }})</p>
</div>

<div class="page-content">
  @if (session('success'))
  <div style="background: #dcfce7; border-left: 4px solid #16a34a; color: #15803d; padding: 14px 20px; border-radius: 8px; font-weight: 600; margin-bottom: 30px;">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
  </div>
  @endif

  <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    <!-- Main Content -->
    <div>
      <div class="card-box">
        <h2 style="font-size: 1.3rem; color: var(--primary); margin-bottom: 16px;">
          <i class="fa-solid fa-gauge-high"></i> Ringkasan Akun
        </h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px;">
          <div style="background: var(--light-bg); padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 2rem; color: var(--primary);"><i class="fa-solid fa-id-card"></i></div>
            <div style="font-weight: 700; margin-top: 8px;">Role Akun</div>
            <div style="font-size: 0.85rem; color: var(--muted); text-transform: uppercase; font-weight: 800;">{{ $user->role ?? 'Siswa' }}</div>
          </div>
          <div style="background: var(--light-bg); padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 2rem; color: var(--accent);"><i class="fa-solid fa-clock"></i></div>
            <div style="font-weight: 700; margin-top: 8px;">Status Login</div>
            <div style="font-size: 0.85rem; color: #16a34a; font-weight: 800;">Aktif</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar / Logout -->
    <div>
      <div class="card-box" style="text-align: center;">
        <div style="width: 70px; height: 70px; background: var(--primary-light); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 16px;">
          <i class="fa-solid fa-user-graduate"></i>
        </div>
        <h3 style="font-size: 1.1rem; font-weight: 800;">{{ $user->name }}</h3>
        <p style="font-size: 0.85rem; color: var(--muted); margin-bottom: 20px;">{{ $user->email }}</p>

        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" style="background: #ef4444; color: #ffffff; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 700; cursor: pointer; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; font-family: inherit;">
            <i class="fa-solid fa-right-from-bracket"></i> Keluar (Logout)
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
