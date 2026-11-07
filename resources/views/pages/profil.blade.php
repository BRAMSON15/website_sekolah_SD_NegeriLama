@extends('layouts.app')

@section('title', 'Profil Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<div class="pv-hero" style="background-image: linear-gradient(rgba(15, 23, 42, 0.62), rgba(30, 64, 175, 0.6)), url('{{ asset('mentahan2/img/image1.png') }}');">
  <div class="pv-hero-inner">
    <span class="pv-hero-chip"><i class="fa-solid fa-school"></i> Profil Sekolah</span>
    <h1>Mengenal {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}</h1>
    <p>Visi, misi, sejarah, dan tujuan pendidikan kami dalam membangun generasi cerdas, berkarakter, dan berprestasi.</p>
  </div>
</div>

<div class="pv-wrap">
  <div class="pv-vm-grid">
    @if(!empty($settings['school_vision']))
    <div class="pv-card pv-card--gradient" style="margin-bottom: 0;">
      <span class="pv-eyebrow"><i class="fa-solid fa-eye"></i> Visi Sekolah</span>
      <blockquote class="pv-quote" style="margin-top: 12px;">&ldquo;{{ $settings['school_vision'] }}&rdquo;</blockquote>
    </div>
    @endif

    @if(!empty($settings['school_mission']))
    <div class="pv-card" style="margin-bottom: 0;">
      <span class="pv-eyebrow"><i class="fa-solid fa-list-check"></i> Misi Sekolah</span>
      @php
        $missions = array_filter(array_map('trim', explode("\n", $settings['school_mission'])));
      @endphp
      <ul class="pv-check-list" style="margin-top: 14px;">
        @foreach($missions as $mission)
          <li>{{ $mission }}</li>
        @endforeach
      </ul>
    </div>
    @endif
  </div>

  @if(!empty($settings['school_history']))
  <div class="pv-card" style="margin-top: 26px;">
    <h2 class="pv-title"><i class="fa-solid fa-landmark"></i> Sejarah Sekolah</h2>
    <p style="color: var(--muted); line-height: 1.85; margin: 0; font-size: 0.95rem;">
      {{ $settings['school_history'] }}
    </p>
  </div>
  @endif

  @if(!empty($settings['school_objectives']))
  <div class="pv-card">
    <h2 class="pv-title"><i class="fa-solid fa-bullseye"></i> Tujuan Sekolah</h2>
    @php
      $objectives = array_filter(array_map('trim', explode("\n", $settings['school_objectives'])));
    @endphp
    <ul class="pv-check-list">
      @foreach($objectives as $objective)
        <li>{{ $objective }}</li>
      @endforeach
    </ul>
  </div>
  @endif
</div>
@endsection
