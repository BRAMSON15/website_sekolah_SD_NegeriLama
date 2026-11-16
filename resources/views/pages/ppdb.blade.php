@extends('layouts.app')

@section('title', 'Pendaftaran PPDB - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
@php
  $isOpen = ($settings['ppdb_status'] ?? 'open') === 'open';

  // Smart resolution for title & description based on admin open/closed status
  $rawTitle = trim($settings['ppdb_batch_title'] ?? '');
  $rawDesc  = trim($settings['ppdb_batch_desc'] ?? '');

  if ($isOpen) {
    $bannerTitle = !empty($rawTitle) ? $rawTitle : 'PPDB Gelombang II Telah Dibuka!';
    $bannerDesc  = !empty($rawDesc) ? $rawDesc : 'Segera daftarkan putra-putri Anda untuk mendapatkan pendidikan terbaik di SD Negeri Lama.';
  } else {
    // When closed, avoid displaying contradictory "dibuka" text
    if (empty($rawTitle) || (stripos($rawTitle, 'dibuka') !== false && stripos($rawTitle, 'tutup') === false)) {
      $bannerTitle = 'Pendaftaran PPDB Saat Ini Ditutup';
    } else {
      $bannerTitle = $rawTitle;
    }

    if (empty($rawDesc) || (stripos($rawDesc, 'dibuka') !== false && stripos($rawDesc, 'tutup') === false)) {
      $bannerDesc = 'Pendaftaran online untuk periode ini resmi ditutup. Informasi pembukaan gelombang berikutnya akan diumumkan di halaman ini.';
    } else {
      $bannerDesc = $rawDesc;
    }
  }
@endphp

<div class="pv-hero" style="background-image: linear-gradient(rgba(15, 23, 42, 0.62), rgba(30, 64, 175, 0.6)), url('{{ asset('mentahan2/img/image1.png') }}');">
  <div class="pv-hero-inner">
    <span class="pv-hero-chip"><i class="fa-solid fa-bullhorn"></i> Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</span>
    <h1>Penerimaan Peserta Didik Baru</h1>
    <p>Daftarkan putra-putri Anda di {{ $settings['school_name'] ?? 'SD Negeri Lama' }} dan berikan mereka pendidikan terbaik untuk masa depan yang gemilang.</p>
    <div class="pv-hero-btns">
      @if($isOpen)
        <a href="{{ route('ppdb.register') }}" class="pv-btn pv-btn--gold"><i class="fa-solid fa-paper-plane"></i> Daftar Sekarang Online</a>
      @endif
      <a href="#syarat" class="pv-btn" style="background: rgba(255,255,255,0.14); color: #ffffff; border: 1px solid rgba(255,255,255,0.4); backdrop-filter: blur(6px);"><i class="fa-solid fa-list-check"></i> Lihat Syarat</a>
    </div>
  </div>
</div>

<div class="pv-wrap">
  @if(session('error'))
  <div class="pv-alert" style="display: flex; margin: 0 0 20px;">
    <i class="fa-solid fa-circle-exclamation" style="font-size: 1.1rem; color: #ef4444; flex-shrink: 0;"></i>
    <span>{{ session('error') }}</span>
  </div>
  @endif

  <div class="pv-banner {{ $isOpen ? 'pv-banner--open' : 'pv-banner--closed' }}">
    <div style="flex: 1; min-width: 260px;">
      @if($isOpen)
        <span class="pv-status-pill pv-status-pill--open"><i class="fa-solid fa-circle-check"></i> Pendaftaran Dibuka</span>
      @else
        <span class="pv-status-pill pv-status-pill--closed"><i class="fa-solid fa-circle-xmark"></i> Pendaftaran Ditutup</span>
      @endif
      <h2 class="pv-banner-title"><i class="fa-solid fa-bullhorn"></i> {{ $bannerTitle }}</h2>
      <p class="pv-banner-text">{{ $bannerDesc }}</p>
    </div>

    @if($isOpen)
      <a href="{{ route('ppdb.register') }}" class="pv-btn pv-btn--primary pv-btn--inline"><i class="fa-solid fa-paper-plane"></i> Isi Formulir Pendaftaran</a>
    @else
      <button type="button" class="pv-btn pv-btn--disabled pv-btn--inline" disabled><i class="fa-solid fa-lock"></i> Pendaftaran Ditutup</button>
    @endif
  </div>

  @if(!empty($settings['ppdb_requirements']))
  <div class="pv-card" id="syarat">
    <h2 class="pv-title"><i class="fa-solid fa-list-check"></i> Syarat Pendaftaran</h2>
    @php
      $reqs = array_filter(array_map('trim', explode("\n", $settings['ppdb_requirements'])));
    @endphp
    <ul class="pv-check-list">
      @foreach($reqs as $req)
        <li>{{ $req }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  @if(!empty($settings['ppdb_step_1_title']) && !empty($settings['ppdb_step_2_title']))
  <div class="pv-card">
    <h2 class="pv-title"><i class="fa-solid fa-timeline"></i> Alur Pendaftaran</h2>
    <div class="pv-steps">
      <div class="pv-step">
        <div class="pv-step-num">1</div>
        <h4>{{ $settings['ppdb_step_1_title'] }}</h4>
        <p>{{ $settings['ppdb_step_1_desc'] ?? 'Langkah pertama pendaftaran' }}</p>
      </div>
      @if(!empty($settings['ppdb_step_2_title']))
      <div class="pv-step">
        <div class="pv-step-num">2</div>
        <h4>{{ $settings['ppdb_step_2_title'] }}</h4>
        <p>{{ $settings['ppdb_step_2_desc'] ?? 'Langkah kedua pendaftaran' }}</p>
      </div>
      @endif
      @if(!empty($settings['ppdb_step_3_title']))
      <div class="pv-step">
        <div class="pv-step-num">3</div>
        <h4>{{ $settings['ppdb_step_3_title'] }}</h4>
        <p>{{ $settings['ppdb_step_3_desc'] ?? 'Langkah ketiga pendaftaran' }}</p>
      </div>
      @endif
      @if(!empty($settings['ppdb_step_4_title']))
      <div class="pv-step">
        <div class="pv-step-num">4</div>
        <h4>{{ $settings['ppdb_step_4_title'] }}</h4>
        <p>{{ $settings['ppdb_step_4_desc'] ?? 'Langkah keempat pendaftaran' }}</p>
      </div>
      @endif
    </div>
  </div>
  @endif

  <div class="pv-card pv-card--gradient" style="text-align: center; margin-bottom: 0;">
    <span class="pv-eyebrow"><i class="fa-solid fa-circle-question"></i> Butuh Bantuan?</span>
    <h2 class="pv-title pv-title--center" style="justify-content: center;"><i class="fa-solid fa-headset"></i> Hubungi Kami</h2>
    <p style="color: var(--muted); max-width: 520px; margin: 0 auto 18px; line-height: 1.7; font-size: 0.95rem;">
      Punya pertanyaan seputar PPDB? Tim kami siap membantu pada jam kerja melalui telepon, WhatsApp, atau kunjungan langsung ke sekolah.
    </p>
    <a href="{{ route('kontak') }}" class="pv-btn pv-btn--primary pv-btn--inline"><i class="fa-solid fa-address-book"></i> Lihat Kontak Sekolah</a>
  </div>
</div>
@endsection
