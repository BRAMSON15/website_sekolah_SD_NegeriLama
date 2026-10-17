@extends('layouts.app')

@section('title', 'Profil Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Profil Sekolah</h1>
  <p>Mengenal lebih dekat visi, misi, sejarah, dan struktur organisasi {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}</p>
</div>

<div class="page-content">
  <div class="card-box">
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-bullseye"></i> Visi & Misi</h2>
    @if(!empty($settings['school_vision']))
    <div style="margin-bottom: 24px;">
      <h3 style="font-size: 1.1rem; margin-bottom: 8px;">Visi</h3>
      <p style="color: var(--muted); font-size: 1rem; padding-left: 16px; border-left: 4px solid var(--primary);">
        "{{ $settings['school_vision'] }}"
      </p>
    </div>
    @endif
    <div>
      <h3 style="font-size: 1.1rem; margin-bottom: 8px;">Misi</h3>
      @if(!empty($settings['school_mission']))
      @php
        $missions = array_filter(array_map('trim', explode("\n", $settings['school_mission'])));
      @endphp
      <ul style="color: var(--muted); padding-left: 20px; font-size: 0.95rem; line-height: 1.8;">
        @foreach($missions as $mission)
          <li>{{ $mission }}</li>
        @endforeach
      </ul>
      @endif
    </div>
  </div>

  @if(!empty($settings['school_history']))
  <div class="card-box">
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-landmark"></i> Sejarah Sekolah</h2>
    <p style="color: var(--muted); line-height: 1.8;">
      {{ $settings['school_history'] }}
    </p>
  </div>
  @endif

  @if(!empty($settings['school_objectives']))
  <div class="card-box">
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-target"></i> Tujuan Sekolah</h2>
    @php
      $objectives = array_filter(array_map('trim', explode("\n", $settings['school_objectives'])));
    @endphp
    <ul style="color: var(--muted); padding-left: 20px; font-size: 0.95rem; line-height: 1.8;">
      @foreach($objectives as $objective)
        <li>{{ $objective }}</li>
      @endforeach
    </ul>
  </div>
  @endif
</div>
@endsection
