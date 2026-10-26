@extends('layouts.app')

@section('title', 'Profil Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<style>
  .profil-header h1 { font-size: 2.5rem; margin-bottom: 10px; }
  .profil-header p { font-size: 1.1rem; }
  .profil-section h2 { font-size: 1.4rem; margin-bottom: 12px; }
  .profil-section h3 { font-size: 1rem; margin-bottom: 6px; }
  .profil-section p, .profil-section ul { font-size: 0.93rem; }
  .profil-section li { margin-bottom: 6px; }
  
  @media (max-width: 768px) {
    .profil-header h1 { font-size: 2rem; }
    .profil-header p { font-size: 0.95rem; }
    .profil-section h2 { font-size: 1.3rem; margin-bottom: 10px; }
    .profil-section h3 { font-size: 0.95rem; }
    .profil-section p, .profil-section ul { font-size: 0.88rem; }
  }
  
  @media (max-width: 576px) {
    .profil-header h1 { font-size: 1.8rem; margin-bottom: 6px; }
    .profil-header p { font-size: 0.8rem; }
    .profil-section { padding: 16px !important; margin-bottom: 16px !important; }
    .profil-section h2 { font-size: 1.15rem; margin-bottom: 10px; }
    .profil-section h3 { font-size: 0.88rem; margin-bottom: 5px; }
    .profil-section p { font-size: 0.82rem; line-height: 1.5; }
    .profil-section ul { font-size: 0.82rem; padding-left: 14px; }
    .profil-section li { margin-bottom: 4px; }
  }
  
  @media (max-width: 380px) {
    .profil-header h1 { font-size: 1.4rem; }
    .profil-header p { font-size: 0.72rem; }
    .profil-section h2 { font-size: 1rem; }
    .profil-section h3 { font-size: 0.78rem; }
    .profil-section p, .profil-section ul { font-size: 0.75rem; }
  }
</style>

<div class="page-header profil-header">
  <h1>Profil Sekolah</h1>
  <p>Mengenal lebih dekat visi, misi, sejarah, dan struktur organisasi {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}</p>
</div>

<div class="page-content">
  <div class="card-box profil-section">
    <h2><i class="fa-solid fa-bullseye"></i> Visi & Misi</h2>
    @if(!empty($settings['school_vision']))
    <div style="margin-bottom: 18px;">
      <h3>Visi</h3>
      <p style="color: var(--muted); padding-left: 12px; border-left: 3px solid var(--primary);">
        "{{ $settings['school_vision'] }}"
      </p>
    </div>
    @endif
    <div>
      <h3>Misi</h3>
      @if(!empty($settings['school_mission']))
      @php
        $missions = array_filter(array_map('trim', explode("\n", $settings['school_mission'])));
      @endphp
      <ul style="color: var(--muted); padding-left: 18px; line-height: 1.7;">
        @foreach($missions as $mission)
          <li>{{ $mission }}</li>
        @endforeach
      </ul>
      @endif
    </div>
  </div>

  @if(!empty($settings['school_history']))
  <div class="card-box profil-section">
    <h2><i class="fa-solid fa-landmark"></i> Sejarah Sekolah</h2>
    <p style="color: var(--muted); line-height: 1.75;">
      {{ $settings['school_history'] }}
    </p>
  </div>
  @endif

  @if(!empty($settings['school_objectives']))
  <div class="card-box profil-section">
    <h2><i class="fa-solid fa-target"></i> Tujuan Sekolah</h2>
    @php
      $objectives = array_filter(array_map('trim', explode("\n", $settings['school_objectives'])));
    @endphp
    <ul style="color: var(--muted); padding-left: 18px; line-height: 1.7;">
      @foreach($objectives as $objective)
        <li>{{ $objective }}</li>
      @endforeach
    </ul>
  </div>
  @endif
</div>
@endsection
