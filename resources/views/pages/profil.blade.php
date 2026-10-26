@extends('layouts.app')

@section('title', 'Profil Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<div class="page-header" style="@media (max-width: 576px) { padding: 36px 4%; } @media (max-width: 768px) { padding: 48px 5%; }">
  <h1 style="@media (max-width: 576px) { font-size: 1.8rem; margin-bottom: 6px; } @media (max-width: 768px) { font-size: 2rem; }">Profil Sekolah</h1>
  <p style="@media (max-width: 576px) { font-size: 0.8rem; } @media (max-width: 768px) { font-size: 0.95rem; }">Mengenal lebih dekat visi, misi, sejarah, dan struktur organisasi {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}</p>
</div>

<div class="page-content" style="@media (max-width: 576px) { padding: 32px 4%; } @media (max-width: 768px) { padding: 48px 5%; }">
  <div class="card-box" style="@media (max-width: 576px) { padding: 16px; margin-bottom: 16px; } @media (max-width: 768px) { padding: 20px; }">
    <h2 style="font-size: 1.4rem; color: var(--primary); margin-bottom: 12px; @media (max-width: 576px) { font-size: 1.15rem; margin-bottom: 10px; } @media (max-width: 768px) { font-size: 1.3rem; }"><i class="fa-solid fa-bullseye" style="@media (max-width: 576px) { margin-right: 6px; }"></i> Visi & Misi</h2>
    @if(!empty($settings['school_vision']))
    <div style="margin-bottom: 18px; @media (max-width: 576px) { margin-bottom: 14px; }">
      <h3 style="font-size: 1rem; margin-bottom: 6px; @media (max-width: 576px) { font-size: 0.92rem; margin-bottom: 5px; }">Visi</h3>
      <p style="color: var(--muted); font-size: 0.95rem; padding-left: 12px; border-left: 3px solid var(--primary); @media (max-width: 576px) { font-size: 0.85rem; padding-left: 10px; border-left-width: 2px; }">
        "{{ $settings['school_vision'] }}"
      </p>
    </div>
    @endif
    <div>
      <h3 style="font-size: 1rem; margin-bottom: 6px; @media (max-width: 576px) { font-size: 0.92rem; margin-bottom: 5px; }">Misi</h3>
      @if(!empty($settings['school_mission']))
      @php
        $missions = array_filter(array_map('trim', explode("\n", $settings['school_mission'])));
      @endphp
      <ul style="color: var(--muted); padding-left: 18px; font-size: 0.93rem; line-height: 1.7; @media (max-width: 576px) { padding-left: 14px; font-size: 0.82rem; line-height: 1.5; }">
        @foreach($missions as $mission)
          <li style="@media (max-width: 576px) { margin-bottom: 4px; }">{{ $mission }}</li>
        @endforeach
      </ul>
      @endif
    </div>
  </div>

  @if(!empty($settings['school_history']))
  <div class="card-box" style="@media (max-width: 576px) { padding: 16px; margin-bottom: 16px; } @media (max-width: 768px) { padding: 20px; }">
    <h2 style="font-size: 1.4rem; color: var(--primary); margin-bottom: 12px; @media (max-width: 576px) { font-size: 1.15rem; margin-bottom: 10px; } @media (max-width: 768px) { font-size: 1.3rem; }"><i class="fa-solid fa-landmark" style="@media (max-width: 576px) { margin-right: 6px; }"></i> Sejarah Sekolah</h2>
    <p style="color: var(--muted); line-height: 1.75; @media (max-width: 576px) { font-size: 0.85rem; line-height: 1.5; }">
      {{ $settings['school_history'] }}
    </p>
  </div>
  @endif

  @if(!empty($settings['school_objectives']))
  <div class="card-box" style="@media (max-width: 576px) { padding: 16px; margin-bottom: 16px; } @media (max-width: 768px) { padding: 20px; }">
    <h2 style="font-size: 1.4rem; color: var(--primary); margin-bottom: 12px; @media (max-width: 576px) { font-size: 1.15rem; margin-bottom: 10px; } @media (max-width: 768px) { font-size: 1.3rem; }"><i class="fa-solid fa-target" style="@media (max-width: 576px) { margin-right: 6px; }"></i> Tujuan Sekolah</h2>
    @php
      $objectives = array_filter(array_map('trim', explode("\n", $settings['school_objectives'])));
    @endphp
    <ul style="color: var(--muted); padding-left: 18px; font-size: 0.93rem; line-height: 1.7; @media (max-width: 576px) { padding-left: 14px; font-size: 0.82rem; line-height: 1.5; }">
      @foreach($objectives as $objective)
        <li style="@media (max-width: 576px) { margin-bottom: 4px; }">{{ $objective }}</li>
      @endforeach
    </ul>
  </div>
  @endif
</div>
@endsection
