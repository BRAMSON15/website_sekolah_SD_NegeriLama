@extends('layouts.app')

@section('title', 'Pendaftaran PPDB - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<style>
  .ppdb-header { margin-bottom: 8px; }
  .ppdb-header-badge { padding: 4px 12px; font-size: 0.8rem; gap: 6px; }
  .ppdb-header-title { font-size: 1.5rem; margin-bottom: 8px; }
  .ppdb-header-text { color: var(--muted); }
  .ppdb-btn { padding: 14px 28px; font-size: 1rem; }
  .ppdb-req-list { padding-left: 20px; line-height: 2; }
  .ppdb-req-item { margin-bottom: 0; }
  .ppdb-step-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 200px), 1fr)); gap: 16px; text-align: center; }
  .ppdb-step { background: var(--light-bg); padding: 20px; border-radius: 12px; }
  .ppdb-step-num { width: 40px; height: 40px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 800; }
  .ppdb-step-title { font-size: 1rem; margin-bottom: 4px; }
  .ppdb-step-desc { font-size: 0.85rem; color: var(--muted); }
  
  @media (max-width: 768px) {
    .ppdb-header-title { font-size: 1.3rem; }
    .ppdb-step-grid { gap: 12px; }
    .ppdb-step { padding: 16px; }
    .ppdb-step-title { font-size: 0.92rem; }
    .ppdb-step-desc { font-size: 0.78rem; }
    .ppdb-req-list { line-height: 1.8; }
  }
  
  @media (max-width: 576px) {
    .ppdb-header { margin-bottom: 6px; }
    .ppdb-header-title { font-size: 1.1rem; margin-bottom: 6px; }
    .ppdb-header-text { font-size: 0.82rem; }
    .ppdb-btn { padding: 11px 18px !important; font-size: 0.88rem !important; width: 100%; justify-content: center; }
    .ppdb-status-card { padding: 16px !important; margin-bottom: 16px !important; }
    .ppdb-req-section { padding: 16px !important; }
    .ppdb-req-list { padding-left: 14px; line-height: 1.6; font-size: 0.82rem; }
    .ppdb-step-grid { gap: 10px; }
    .ppdb-step { padding: 14px; }
    .ppdb-step-num { width: 32px; height: 32px; font-size: 0.85rem; }
    .ppdb-step-title { font-size: 0.82rem; margin-bottom: 3px; }
    .ppdb-step-desc { font-size: 0.70rem; }
  }
  
  @media (max-width: 380px) {
    .ppdb-header-title { font-size: 0.95rem; }
    .ppdb-header-text { font-size: 0.75rem; }
    .ppdb-btn { font-size: 0.78rem !important; }
    .ppdb-req-list { font-size: 0.75rem; }
    .ppdb-step-title { font-size: 0.75rem; }
    .ppdb-step-desc { font-size: 0.65rem; }
  }
</style>

<div class="page-header">
  <h1>Penerimaan Peserta Didik Baru (PPDB)</h1>
  <p>Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }} - {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}</p>
</div>

<div class="page-content">
  @php
    $isOpen = ($settings['ppdb_status'] ?? 'open') === 'open';
  @endphp

  <div class="card-box ppdb-status-card" style="background: {{ $isOpen ? 'linear-gradient(135deg, #eff6ff, #ffffff)' : 'linear-gradient(135deg, #fef2f2, #ffffff)' }}; border-color: {{ $isOpen ? 'var(--primary-light)' : '#fca5a5' }};">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
      <div>
        <div class="ppdb-header">
          @if($isOpen)
            <span class="ppdb-header-badge" style="background: #dcfce7; color: #166534; display: inline-flex; align-items: center; border-radius: 20px; font-weight: 700;">
              <i class="fa-solid fa-circle-check"></i> PENDAFTARAN DIBUKA
            </span>
          @else
            <span class="ppdb-header-badge" style="background: #fee2e2; color: #991b1b; display: inline-flex; align-items: center; border-radius: 20px; font-weight: 700;">
              <i class="fa-solid fa-circle-xmark"></i> PENDAFTARAN DITUTUP
            </span>
          @endif
        </div>
        <h2 class="ppdb-header-title" style="color: {{ $isOpen ? 'var(--primary)' : '#b91c1c' }}; margin: 0; font-weight: 800;">
          <i class="fa-solid fa-bullhorn"></i> {{ $settings['ppdb_batch_title'] ?? 'PPDB Gelombang II Telah Dibuka!' }}
        </h2>
        <p class="ppdb-header-text" style="margin: 0;">{{ $settings['ppdb_batch_desc'] ?? 'Segera daftarkan putra-putri Anda untuk mendapatkan pendidikan terbaik.' }}</p>
      </div>

      @if($isOpen)
        <a href="{{ route('ppdb.register') }}" class="btn-login ppdb-btn"><i class="fa-solid fa-paper-plane"></i> Daftar Sekarang Online</a>
      @else
        <button type="button" class="btn-login ppdb-btn" style="background: #94a3b8; cursor: not-allowed;" disabled><i class="fa-solid fa-lock"></i> Pendaftaran Ditutup</button>
      @endif
    </div>
  </div>

  @if(!empty($settings['ppdb_requirements']))
  <div class="card-box ppdb-req-section">
    <h2 style="font-size: 1.3rem; color: var(--dark); margin: 0 0 16px 0; font-weight: 800;"><i class="fa-solid fa-list-check"></i> Syarat Pendaftaran</h2>
    @php
      $reqs = array_filter(array_map('trim', explode("\n", $settings['ppdb_requirements'])));
    @endphp
    <ul class="ppdb-req-list" style="color: var(--muted); margin: 0; list-style-position: inside;">
      @foreach($reqs as $req)
        <li class="ppdb-req-item">{{ $req }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  @if(!empty($settings['ppdb_step_1_title']) && !empty($settings['ppdb_step_2_title']))
  <div class="card-box">
    <h2 style="font-size: 1.3rem; color: var(--dark); margin: 0 0 16px 0; font-weight: 800;"><i class="fa-solid fa-timeline"></i> Alur Pendaftaran</h2>
    <div class="ppdb-step-grid">
      <div class="ppdb-step">
        <div class="ppdb-step-num">1</div>
        <h4 class="ppdb-step-title">{{ $settings['ppdb_step_1_title'] }}</h4>
        <p class="ppdb-step-desc">{{ $settings['ppdb_step_1_desc'] ?? 'Langkah pertama pendaftaran' }}</p>
      </div>
      @if(!empty($settings['ppdb_step_2_title']))
      <div class="ppdb-step">
        <div class="ppdb-step-num">2</div>
        <h4 class="ppdb-step-title">{{ $settings['ppdb_step_2_title'] }}</h4>
        <p class="ppdb-step-desc">{{ $settings['ppdb_step_2_desc'] ?? 'Langkah kedua pendaftaran' }}</p>
      </div>
      @endif
      @if(!empty($settings['ppdb_step_3_title']))
      <div class="ppdb-step">
        <div class="ppdb-step-num">3</div>
        <h4 class="ppdb-step-title">{{ $settings['ppdb_step_3_title'] }}</h4>
        <p class="ppdb-step-desc">{{ $settings['ppdb_step_3_desc'] ?? 'Langkah ketiga pendaftaran' }}</p>
      </div>
      @endif
      @if(!empty($settings['ppdb_step_4_title']))
      <div class="ppdb-step">
        <div class="ppdb-step-num">4</div>
        <h4 class="ppdb-step-title">{{ $settings['ppdb_step_4_title'] }}</h4>
        <p class="ppdb-step-desc">{{ $settings['ppdb_step_4_desc'] ?? 'Langkah keempat pendaftaran' }}</p>
      </div>
      @endif
    </div>
  </div>
  @endif
</div>
@endsection
