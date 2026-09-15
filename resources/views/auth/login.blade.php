@extends('layouts.app')

@section('title', 'Login Portal - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div style="min-height: calc(100vh - 300px); display: flex; align-items: center; justify-content: center; padding: 60px 6%; background-image: linear-gradient(rgba(15, 23, 42, 0.58), rgba(30, 64, 175, 0.58)), url('{{ asset('mentahan/img/image.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
  <div style="background: #ffffff; border-radius: var(--radius); padding: 40px; border: 1px solid var(--border); box-shadow: var(--shadow-lg); width: 100%; max-width: 440px;">
    
    <div style="text-align: center; margin-bottom: 30px;">
      <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.8rem; margin: 0 auto 16px; box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);">
        <i class="fa-solid fa-graduation-cap"></i>
      </div>
      <h2 style="font-size: 1.6rem; font-weight: 800; color: var(--dark); margin-bottom: 6px;">Portal Masuk</h2>
      <p style="font-size: 0.9rem; color: var(--muted);">Masuk ke sistem akademis {{ $settings['school_name'] ?? 'SD Negeri Lama' }}</p>
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

    <form action="{{ route('login') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
      @csrf
      <div>
        <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
          <i class="fa-solid fa-envelope" style="color: var(--primary); margin-right: 6px;"></i> Alamat Email
        </label>
        <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@sdnegerilama.sch.id" style="width: 100%; padding: 14px 16px; border: 1px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
      </div>

      <div>
        <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 8px;">
          <i class="fa-solid fa-lock" style="color: var(--primary); margin-right: 6px;"></i> Kata Sandi
        </label>
        <input type="password" name="password" required placeholder="••••••••" style="width: 100%; padding: 14px 16px; border: 1px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
      </div>

      <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.85rem;">
        <label style="display: flex; align-items: center; gap: 8px; color: var(--muted); cursor: pointer;">
          <input type="checkbox" name="remember" style="accent-color: var(--primary);"> Ingat Saya
        </label>
        <a href="#" style="color: var(--primary); font-weight: 600;">Lupa Password?</a>
      </div>

      <button type="submit" class="btn-login" style="border: none; width: 100%; justify-content: center; padding: 14px; font-size: 1rem; cursor: pointer; border-radius: 10px; margin-top: 10px;">
        <i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang
      </button>
    </form>

    <div style="margin-top: 30px; text-align: center; font-size: 0.85rem; color: var(--muted); border-top: 1px solid var(--border); padding-top: 20px;">
      Bantu akun belajar? Hubungi <a href="{{ route('kontak') }}" style="color: var(--primary); font-weight: 700;">Administrator Sekolah</a>
    </div>

  </div>
</div>
@endsection
